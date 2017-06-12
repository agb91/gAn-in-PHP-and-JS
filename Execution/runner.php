<?php


    session_start(); // Starting Session
    if (!strcmp($_SESSION['logged'], "logged") == 0)
    {
        echo "not logged";
        header("location: ../Login/logPage.php");
    }
    else
    {
    	
        include '../Globals.php';
        include 'imagesFunctions.php';
        include 'runnerFunctions.php';
        
        //print_r($_POST);
	
        if(  isset( $_POST["runsTextualInput"] ) && strlen( $_POST["runsTextualInput"]) > 1 )
        {
        	//echo "TA before: " . $_POST["runsTextualInput"];

        	
        	$textArea = cleanTextArea($_POST["runsTextualInput"]);
        	writeToTextArea( $textArea );	
        	//echo "<br>TA after: " . $textArea;
        	
        	$whichRunSecond = "-";
        	$whichRunFirst = "-";
        	echo "<br>textual input is: " . $textArea;
        }
        
		//first: understand in which case we are
        if(  isset( $_POST["whichRunSecond"] ) && strlen( $_POST["whichRunSecond"]) > 1 )
        {
        	$whichRunSecond = cleanString( $_POST["whichRunSecond"]);
			echo "<br>whichRunSecond definitive: " . $whichRunSecond  . "<br>";
        }
        
        if(  isset( $_POST["whichRun"] ) && strlen( $_POST["whichRun"]) > 1 )
        {
        	$whichRunFirst = cleanString( $_POST["whichRun"]);
			echo "<br> whichRunFirst definitive: " . $whichRunFirst  . "<br>";
        }
        
        $cardinality = getCardinality($whichRunFirst , $whichRunSecond);
		echo "<br> cardinality: " . $cardinality;
		
		
        $whichAnalysis = $_POST["selectedAnalysisSingle"];
        $whichAnalysis = $whichAnalysis . $_POST["selectedAnalysisMultiple"];
        $whichAnalysis = cleanString( $whichAnalysis );
        echo "<br>the read analysis is : " . $whichAnalysis;
      

    }
?>

<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="../JS/jquery.js"></script>
        <script src="../JS/imagesJs.js"></script>
        <script src="../JS/runnerJs.js"></script>
        <link rel="stylesheet" href="../CSS/runner.css" media="screen">
        <link rel="stylesheet" href="../CSS/images.css" media="screen">
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="../bootstrap/css/bootstrap-theme.css" rel="stylesheet" media="screen">
        <script src="../bootstrap/js/bootstrap.js"></script>
        <script src="../JSROOTlibraries/scripts/JSRootCore.js" type="text/javascript"></script>
        <!--<link rel="stylesheet" href="jqueryUI/jquery-ui.css">
        <script src="jqueryUI/jquery-ui.js"></script>-->
    </head>
    <body id="body" class="general">
        <div class = "row" >
            <ul class="nav nav-tabs navbar-default">
                <li class="nav-item">
                    <a class = "nav-link active" onclick = "showTextualRunner()" >
                        <h3> Textual Output </h3>    
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="Look at the images created by running gAn">
                    <?php 
                            echo "<a class = 'nav-link' onclick = 'showImages()' >";
                    ?>    
                        <h3> Images output </h3>
                    </a>
                </li>
                <li class="nav-item" data-toggle='tooltip' title='Download the .root file related to the selected run'>
                    <a class="nav-link" onclick="rootDownload()">
                        <h3> Download Output File 
                            <?php
                                echo "<div hidden id='rootFileRun'> " . $whichRunFirst . "<div>";    
                            ?>
                        </h3>    
                    </a>
                </li>
                <li class="nav-item" data-toggle='tooltip' title='Download all images as a vector based image files'>
                    <a class="nav-link" onclick="downloadImages()" >
                        <h3> Download All Images 
                            <?php
                                echo "<div hidden id='rootFileRun'> " . $whichRunFirst . "<div>";    
                            ?>
                        </h3>    
                    </a>
                </li>
                <li class="nav-item" data-toggle='tooltip' title='Return to the Homepage of this gAn-Web'>
                    <a class="nav-link" href="../Home/index.php">
                        <h3> New Analysis </h3>    
                    </a>
                </li>
            </ul>
        </div>







        <!-- now starts with textual runner -->






        <div id="runnerTab" class="runnerGeneral">
                           
            <div class="row">
                <div class="col-xs-3">
                    <h1> Results: </h1>
                </div>
                <div class="col-xs-9"></div>
            </div>
            <div>
                 <?php
                 	if( strcasecmp ( $cardinality, "single" ) == 0)
                 	{
                 		echo "<div id= 'run" . $whichRunFirst . "' style='display:block' name='disappearing'>";
                 		echo "<h4>Run selected : " . $whichRunFirst . "<br>";
                 	}
                 	if( strcasecmp ( $cardinality, "multiple" ) == 0)
                 	{
                 		echo "<div id= 'run" . $whichRunFirst . "-" . $whichRunFirst . "' style='display:block' name='disappearing'>";
                 		echo "<h4>Runs selected : " . $whichRunFirst . " - " . $whichRunSecond . "<br>";
                 	}
                 	
                    echo "Kind of analysis selected: <span id='kindAnalysis'>" . $whichAnalysis . "</span></h4><br>";
		                    	
                    if( strcasecmp ( $cardinality, "textual" ) == 0) // case textual input
		            {
		            	echo "<div style='display:block' name='disappearing'>";
		            	echo "<h4>Runs selected : textFile <br>";
		            }
		            if( strcasecmp ( $cardinality, "single" ) == 0)
				    {	
						echo "single";
		    			$o = runSingle( $whichRunFirst, $whichAnalysis, $gAnPath);
		    		}
		    		
		    		if( strcasecmp ( $cardinality, "multiple" ) == 0)
				    {
						echo "multipleRange: " . $whichRunFirst . "---" . $whichRunSecond;
						$o = runRange( $whichRunFirst, $whichRunSecond, $whichAnalysis, $gAnPath);
		    		}
		    		
		    		if( strcasecmp ( $cardinality, "textual" ) == 0)
		    		{
		    			echo "textual: ";
		    			$o = runTextual($whichAnalysis, $gAnPath);
		    		}
		    		
				    $outputBlocks = getBlocks( $o );
		            printBlocks( $outputBlocks );
				    echo "</div>";
		
                ?>
            </div>
        </div>







        <!-- FROM HERE IMAGES! -->








        <div id = "picturesTab" class = "imagesGeneral" >


	    <div id="imagesName" hidden></div>
	    	<?php createCheckBoxImages(); ?>

            <?php
            	if( strcasecmp ( $cardinality, "Single" ) == 0)
            	{
            		$runs = array($whichRunFirst);
            		echo "<p id='getRuns'>" . $whichRunFirst . "</p>";
            	}
            	else 
            	{
            		$runs = array($whichRunFirst,$whichRunSecond);
            		echo "<p id='getRuns'>" . $whichRunFirst . "-" . $whichRunSecond . "</p>";
            	}
            	
                
            ?>
            <div hidden id = "tipWell" class="well col-xs-2 fixedMiddleRight"> 
                "Right-click on the image for more options"  
            </div>

            <div class = "row">
	     		<div class="col-xs-1"></div>
                <div class= "col-xs-10">
                    <div id = "verticalBlock" style = "display:block" class = "" >

                            <?php
                				echoRootLikeSimple($runs, $whichAnalysis);
                            ?>
                    </div>
                </div> 
	     		<div class="col-xs-1"></div>  
            </div>
 
         </div>    
    </body>    
</html>
