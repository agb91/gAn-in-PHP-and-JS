<?php

	include "..Globals.php";
	include "genericFunctions.php";

	//echo "alive <br>";

	$file = trim($_GET['run']);
	$file = substr( $file, 0, -1 );
	//echo "file: " . $file . "<br>";

	$file = '../output/gAnOut_' . $file . ".root";
	echo $file;
	if(!$file){ // file does not exist
	    die('file not found');
	} else {
		echo "Location: ".$file;
		header("Location: ".$file);
	}
?>
