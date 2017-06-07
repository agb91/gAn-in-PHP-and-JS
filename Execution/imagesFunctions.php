<?php

include "editConfigFunctionsCommons.php";




function echoGroupList($allAnalyzesSingle)
{
    $cleanAnalyzes = getGroupsFromFolder( $allAnalyzesSingle );
    echo "<p hidden id='hereTheGroups'>";
    for ($i = 0; $i < count( $cleanAnalyzes ); $i++) 
    {
        echo '-' . $cleanAnalyzes[ $i ];
    } 
    echo "</p>";
    for ($i = 0; $i < count( $cleanAnalyzes ); $i++) 
    {
        echo '<li><a href="#" id="' . "groupButton". $i . '" onclick="selectImageType(' . ($i) . ')">' . $cleanAnalyzes[$i] . '</a></li>';
    } 
}

/*! \brief showRuns($runs)
 *
 *  only shows possible runs (runs requested by the user)
 */
function showRuns($runs)
{
    for ($i = 0; $i < count($runs); $i++) //the -1 is because the last is empty...
    {
        echo "<li><a href='#'' onclick='selRun(" . $runs[$i] . ")'>" . $runs[$i] . "</a></li>";    
    }
    //echo "<li><a href='#'' onclick='selRun(" . $runs . ")'>All</a></li>";    
}

function createCheckBoxImages()
{
	echo "<div class='centerTextAlign'>";
	echo "<span class='well centerTextAlign'>";
	for ($i = 0; $i < 12; $i++)
	{
		echo "<label id='inputCheck" . $i . "' style=display:none;' class='checkbox-inline'><input id='inputCheckValue" . $i . "' checked='checked' type='checkbox' value='" . $i . "' onclick='showSingleImage(" . $i .")' ><span id='check" . $i . "'></span></label>";
	}
	echo "</span></div><br><br>";
}

//this is ready for have a lot of different groups in the same file (more complex)
function echoRootLike($runs, $allAnalyzesSingle)
{
	$cleanAnalyzes = getGroupsFromFolder( $allAnalyzesSingle );
	for ($i = 0; $i < count($runs); $i++)
	{
		for ($a = 0; $a < count( $cleanAnalyzes ); $a++)
		{
			for( $s = 0; $s < 14 ; $s++ )
			{
				echo "<div id='image" . $runs[$i] . "-" . $cleanAnalyzes[ $a ] . $s . "' style='width: 100%'>";
				echo "</div>";
			}
		}
	}
}
function echoRootLikeMultiple($run1 , $run2 , $whichAnalysis)
{
	for( $s = 0; $s < 14 ; $s++ )
	{
		echo "<div id='image" . $run1 . "-" . $run2 . "-" . $whichAnalysis . $s . "' style='width: 100%'>";
		echo "</div>";
	}
}

function echoRootLikeText($textRuns , $whichAnalysis)
{
	for( $s = 0; $s < 14 ; $s++ )
	{
		echo "<div id='image". $textRuns . "-" . $whichAnalysis . $s . "' style='width: 100%'>";
		echo "</div>";
	}
}

//this is untill there is only one groups in a single file (easier)
function echoRootLikeSimple($runs, $whichAnalysis)
{
	//for ($i = 0; $i < count($runs); $i++)
	//{
		for( $s = 0; $s < 10 ; $s++ )
		{
			//echo "<div id='image" . $runs[$i] . "-" . $whichAnalysis . $s . "' style='width: 100%'>";
			echo "<div id='image" . $s . "' style='width: 100%'>";
			echo "</div>";
		}
	//}
}

?>
