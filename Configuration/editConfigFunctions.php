<?php
	function getGetArray()
	{
		$ris = [];
		foreach($_GET as $key => $value)
		{
			//echo 'Key = ' . $key . '<br />';
			array_push($ris,$key);
		}
		return $ris;
	}

	function getCleanGetArray() //without "path" variable...
	{
		$ris = [];
		$gets = getGetArray();
		for ( $i = 0; $i < ( count($gets) - 1 ) ; $i++ )
		{
			array_push($ris,$gets[$i]);
		}
		return $ris;
	}
	
	function workWithVerbose($xml, $groups)
	{
		$first = $groups[0];
		//echo  "<br><br><br>" .$first ;
		$xml->general->$first["v"] = $_GET[$first];
		return $xml;
	}
	
	function workWithCommonParemeters($xml, $groups)
	{
		$actual = $groups[0];
		echo "old: " . $xml->scints->scint_rebin->attributes()[0] . ";";
		$xml->scints->scint_rebin->attributes()[0] = cleanString( $_GET[$actual] );
		echo "   new : " . $xml->scints->scint_rebin->attributes()[0];
		for( $i = 1 ; $i < count($groups) ; $i++ )
		{
			//echo "cycle <br>" ;
			$actual = $groups[$i];
			$xml->analysis_base->$actual["v"] = cleanString( $_GET[$actual] );
		}
		return $xml;
	}
	
	function getAllGroups( $path )
	{
		//echo $path . "<br>";
		$parentGroups = getParentGroups($path);
		//print_r($parentGroups);
		$groups = [];
		array_push( $groups, "scint_rebin" );
		// general analyzes is the third
		$stack = getGroupsFromXml($path, $parentGroups[ 4 ] );
		for( $a = 0 ; $a < count( $stack ) ; $a++ )
		{
			array_push( $groups, $stack[ $a ] );
		}
		return $groups ;
	}

	function getAllValues( $path , $parent)
	{
		$ris = [];
		//rebin is the special one
		$rebin = readValue( $path , "scints" , "scint_rebin" );
		array_push( $ris, $rebin );
		//general analyzes is the third
		$stack = getGroupsFromXml($path, $parent );
		//print_r( $stack );
		for( $a = 0 ; $a < count( $stack ) ; $a++ )
		{
			$newValue = readValue( $path , $parent ,$stack[ $a ]);
			array_push( $ris, $newValue );
		}
		return $ris;
		
	}
	
	function getParentGroups( $path ) //parentGroup exists because the groups
	//(like mimitos, scints etc) are not directly under the xml tag..
	{
		//echo $path;
		$xml=simplexml_load_file($path) or die("Error: Cannot create object 1");
		$ris = [];
		foreach ($xml->children() as $child)
		{
			array_push($ris, $child->getName());
		}
		return $ris;
	}
	
	function getGroupsFromXml( $path, $parentGroup ) //parentGroup exists because the groups
	//(like mimito, scint etc) are not directly under the xml tag..
	{
		$xml=simplexml_load_file($path) or die("Error: Cannot create object 2");
		$ris = [];
		foreach ($xml->$parentGroup->children() as $child)
		{
			array_push($ris, $child->getName());
		}
		return $ris;
	}
	
	function readValue($path, $parent, $valueName)
	{
		//echo $valueName;
		$xml=simplexml_load_file($path) or die("Error: Cannot create object 3");
		$ris = $xml->$parent->$valueName->attributes()[0];
		return $ris;
	}
	
	



	
?>
