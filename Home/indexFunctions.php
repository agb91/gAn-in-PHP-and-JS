<?php

function getGroupsFromFolder( $allAnalyzes )
{
	$analyzes = scandir( $allAnalyzes );
	$cleanAnalyzes = [];
	for ( $i = 0 ; $i < count( $analyzes ) ; $i++ )
	{
		if ( substr( $analyzes[ $i ] , -2 ) == ".C")
		{
			$toAdd = $analyzes[ $i ];
			$toAdd = substr( $toAdd , 0 , ( strlen( $toAdd ) - 2 ) );
			array_push( $cleanAnalyzes , $toAdd );
			//echo $toAdd . "--";
		}
	}
	return $cleanAnalyzes;
}


function cleanString( $str )
{
	$str = trim( $str );
	//$str = filter_var($str, FILTER_SANITIZE_STRING);
	$str = htmlspecialchars($str, ENT_IGNORE, 'utf-8');
	$str = strip_tags( $str );
	//$str = filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$str = htmlentities( $str );
	$str = xss_clean( $str );
	//echo "<br><br><br>string before: " . $str;
	//$str = escapeshellarg( $str );//already did before the exec command
	//echo "<br>string after: " . $str . "<br><br><br><br>";
	
	return $str;
}

function xss_clean($data)
{
	// Fix &entity\n;
	$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
	$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
	
	// Remove any attribute starting with "on" or xmlns
	$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
	
	// Remove javascript: and vbscript: protocols
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
	
	// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
	
	// Remove namespaced elements (we do not need them)
	$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
	
	do
	{
		// Remove really unwanted tags
		$old_data = $data;
		$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	}
	while ($old_data !== $data);
	
	// we are done...
	return $data;
}


function fileReaderGeneral($path)
{
	$file = $path;
	//echo "opening: ".$file.'<br>';
	$myfile = fopen($file, "r") or die("Unable to open file! (general) ");
	$fileContent = fread($myfile,filesize($file));
	fclose($myfile);
	return trim($fileContent);
}

function findLastRunAndTime($dirRawFiles)
{
	//echo $dirRawFiles;
	$rawFiles = glob($dirRawFiles . "run_" ."*.*");
	//echo count($rawFiles);
	$lastNow = 0; //it is a number.. but printable by echo without problems
	$lastTime = ""; //it is better manage the time as a string
	for ($i = 0; $i < count($rawFiles); $i++) 
	{
		$thisFile = $rawFiles[$i]; //the structure is like: run_40883-20-07-2016
		// we take the part on the right of '_'
		$firstExploded = explode ( "_" , $thisFile)[1];
		// and after the first chuck splitted by -, that is the run number
		$chuncksVector = explode ( "-" , $firstExploded);
		$runNumberChunck = $chuncksVector[0];
		$timeChunck = $chuncksVector[1] . "/" . $chuncksVector[2] . "/" . $chuncksVector[3];
		//I search for the biggest number
		
		if (($runNumberChunck>$lastNow) == 1)
		{
			$lastNow = $runNumberChunck;
			//echo $lastNow;
			$lastTime = $timeChunck;
		}
	}
	return $lastNow . "-" . $lastTime;
}

function getLastTime( $dirRawFiles )
{
	$dataLast = findLastRunAndTime( $dirRawFiles );
	$splittedDataLast = explode ( "-" , $dataLast );
	return $splittedDataLast[ 1 ]; //and I write it
}

function lastRun( $dirRawFiles)
{
	$dataLast = findLastRunAndTime( $dirRawFiles );
	$splittedDataLast = explode ( "-" , $dataLast );
	echo $splittedDataLast[ 0 ]; //and I write it
	echo ", dated: <text id = 'lastTime'>" . $splittedDataLast[ 1 ] . "</text>";	
}	

function readText( $url )
{
	$text = file_get_contents( $url );
	return $text;                    
}

function splitText( $rawText )
{
	$result = [];
	$pieces = explode( "date:" , $rawText );
	for ( $i = 1 ; $i < count( $pieces ) ; $i++ )
	{
		array_push( $result , $pieces[$i] );		
	}
	//print_r($pieces);
	return $result;
}

function writeOneChunk( $text )
{
	$rows = explode( ";" , $text );
	for( $i = 0 ; $i < count( $rows ) ; $i++ )
	{
		echo trim( $rows[ $i ] ) . "<br>";
	}
}

function writeDates( $dates )
{
    echo "<ul class='nav nav-tabs moveUp'>";
	//first I write all the dates in an hidden space to let javascript see them
	echo "<p id='allDates' hidden>";
	for( $i = 0 ; $i < count( $dates ) ; $i++ )
	{
		echo $dates[$i] . ";-;";
	}
	echo "</p>";
	//after I prepare the navbar that show the dates and allows the users to select them
	for( $i = 0 ; $i < count( $dates ) ; $i++ )
	{
		echo "<li onclick='selectDate(" . $i .")' ><a id='link" . $i ."' onclick='setGreen(" . $i .")' class='white' href='#''> " . $dates[ $i ] .  "</a></li>" ;
	}
	echo "</ul>";
                    
}




function getDates( $chunks )
{
	$results = [];
	for ( $i = 0 ; $i < count( $chunks ) ; $i++ )
	{
		$token = substr( $chunks[ $i ] , 0 , 10 );
		array_push( $results , $token );
	}	
	return $results;
}

function readAnalyzes( $allAnalyzesSingle, $allAnalyzesMore, $n)
{
	//echo "---" . $allAnalyzesSingle . "---";
	$analyzes = scandir( $allAnalyzesSingle );
	$addingAnalyzes = scandir( $allAnalyzesMore );
	$analyzes= array_merge($analyzes, $addingAnalyzes );
	
	$cleanAnalyzes = [];
	
	if( $n == 0 )
	{
		echo "<div id='analyzesSingle' hidden>";
    }
    else
    {
    	echo "<div id='analyzesMultiple' hidden>";
    }
    for ( $i = 0 ; $i < count( $analyzes ) ; $i++ )
	{
		if ( (substr( $analyzes[ $i ] , -2 ) == ".C") && ( strpos( $analyzes[ $i ], 'Empty') == false )  )
		{
			$toAdd = $analyzes[ $i ];
			$toAdd = substr( $toAdd , 0 , ( strlen( $toAdd ) - 2 ) );
			array_push( $cleanAnalyzes , $toAdd );
			echo $toAdd . "--";
		}
	}
	//array_push( $cleanAnalyzes , "Ingmari's code" );
	//echo "Ingmari's code--";
	echo "</div>";
	echo "<div class='dropdown col-xs-12'>";
	if( $n == 0 )
	{
		echo "<button id='buttonSelectAnalysisSingle' class='btn btn-default dropdown-toggle littlePadding' type='button' data-toggle='dropdown'>Select an Analysis:";
	}
	else
	{
		echo "<button id='buttonSelectAnalysisMultiple' class='btn btn-default dropdown-toggle littlePadding' type='button' data-toggle='dropdown'>Select an Analysis:";
	}
    echo "<span class='caret'></span></button>";
    echo "<ul class='dropdown-menu'>";
    echo "<li class='dropdown-header'>Defaults</li>";
    for ( $i = 0 ; $i < count( $cleanAnalyzes ) ; $i++ )
	{
		echo "<li><a href='#' onclick='setAnalysis(" . $i . " , " . $n . ")'>" . $cleanAnalyzes[ $i ] . "</a></li>"; 
	}
    echo "</ul>";
    echo "</div>"; 
    echo "<p hidden>";
    if( $n == 0 )
    {
    	echo "<input type='text' id='selectedAnalysisSingle' name='selectedAnalysisSingle' class='form-control'>";
    }
    else
    {
    	echo "<input type='text' id='selectedAnalysisMultiple' name='selectedAnalysisMultiple' class='form-control'>";	
    }
    echo "</p>";
    

}

?>
