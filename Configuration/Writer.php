<?php
//I read the path of the received config file
$path = $_GET["path"];
$path = cleanString( $path );
echo "path: " . $path . "<br>";

$groups = getCleanGetArray(); //without path
print_r($groups);

$xml=simplexml_load_file($path) or die("Error: Cannot create object");
//print_r( $xml );

//$xml = workWithVerbose($xml, $groups);
$xml = workWithCommonParemeters($xml, $groups);
//print_r( $xml );



echo "<br> alive at end <br>";

$xml->asXml($path);
echo "<br> wrote";

header ("LOCATION: ../Home/index.php");
?>