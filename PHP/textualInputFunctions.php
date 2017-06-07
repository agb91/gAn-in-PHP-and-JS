<?php

	$whereToWrite = $_GET["whereToWrite"];
	$fileContent = $_GET["whatToWrite"];
	
	//echo $whereToWrite . "---" . $fileContent . "---> " . strlen( $whereToWrite );
	if( strlen( $whereToWrite ) > 5 )
	{
		$whereToWrite = $whereToWrite . "runSheet.txt";
		$myfile = fopen($whereToWrite, "w") or die("Unable to open file!");
		$fileContent = preg_replace("/[^0-9\-]/","",$fileContent);
		fwrite($myfile, $fileContent );
		fclose($myfile);
	}


?>
