<?php

/*! \brief This script contains global parameters (related to on which machine is gAn installed)
 *         and some very common functions
 *
 */



$xmlConfigFilePath = "/opt/lampp/htdocs/test-interChangeble/gAn-afterDegree/AEgSettingsBAQ.xml"; // path of the ini file
$sourceRootPath = "/home/andrea/Downloads/buildRoot/bin/thisroot.sh"; //path of thisroot.sh
$gAnPath = "/opt/lampp/htdocs/test-interChangeble/gAn-afterDegree/"; //new path of gAn
$baseFolder = "/opt/lampp/htdocs/test-interChangeble/afterDegree/"; //basic folder that includes the project
$dirRawFiles = "/opt/lampp/htdocs/test-interChangeble/gAn-afterDegree/data/";
$allAnalyzesSingle = "/opt/lampp/htdocs/test-interChangeble/gAn-afterDegree/analysis";
$allAnalyzesMultiple = "/opt/lampp/htdocs/test-interChangeble/gAn-afterDegree/analysis";




static $groups = array();

/*! \brief cleanRuns($row)
 *
 *  this function takes a raw input string and cleans it: standardizes the separators,
 *  trims it, toggles duplicates, returns a clean string 
 */
function cleanRuns($row)
{
	$result = "";
	$row = str_replace(",", ";",$row);
    $row = str_replace("-", ";",$row);
    $row = str_replace(".", ";",$row); //. is quite horrible: can pass through isNumeric and set it to true, is better to avoid the risk
	$piecesOfRun = explode(";", $row);
	$piecesOfRun = array_map('trim',$piecesOfRun);// toggle white spaces
	$piecesOfRun = array_unique($piecesOfRun);// toggle duplicates if there are
	for ($i = 0; $i < count($piecesOfRun); $i++) //return a clean string
	{
		if( strlen($piecesOfRun[$i])!=0 )
		{
		    $result = $result . $piecesOfRun[$i] . ";";
		}
	}   
	//echo $result;
	return $result;
}


/*! \brief setGroups($arrayGroups)
 *
 *  seems to be useful store here the objects group read from inifile.
 *  This function is to store (a setter)
 */
function setGroups($arrayGroups)
{
	$groups = $arrayGroups;	
}

/*! \brief getGroups()
 *
 *  seems to be useful store here the objects group read from inifile.
 *  This function is to read after store (a getter)
 */
function getGroups()
{
	return $groups;
}


?>
