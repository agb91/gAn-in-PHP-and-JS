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
        
        print_r($_POST);

		//first: understand in which case we are
        if(  isset( $_POST["whichRunSecond"] ) )
        {
			$whichRunSecond = cleanRuns( $_POST["whichRunSecond"]);
			$whichRunSecond = cleanString( $whichRunSecond );
			echo "<br>whichRunSecond: " . $whichRunSecond  . "<br>";
        }
        else 
        {
        	echo "<br> second run not set";
        }
        if(  isset( $_POST["whichRun"] ) )
        {
        	$whichRunFirst = cleanRuns( $_POST["whichRun"] );
        	$whichRunFirst = cleanString( $whichRunFirst );
			echo "<br> whichRunFirst: " . $whichRunFirst  . "<br>";
        }
        else
        {
        	echo "<br> second run not set";
        }
		
        $cardinality = getCardinality($textMode , $whichRunFirst , $whichRunSecond);
		//echo "<br> cardinality: " . $cardinality;
		if( $cardinality == "textual" )
		{
        	$textFromTextMode = fileReaderGeneral("../runSheet.txt");
        	echo "<br> textFromSheet: " . $textFromTextMode;
        	
		}
        
        $whichAnalysis = $_POST["selectedAnalysisSingle"];
        $whichAnalysis = $whichAnalysis . $_POST["selectedAnalysisMultiple"];
        $whichAnalysis = cleanString( $whichAnalysis );
        echo "<br>the read analysis is : " . $whichAnalysis;
        

    	
    	//echo "text mode: " . $textMode;


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
                 	$runToPrint = getRunToPrint( $cardinality , $textFromTextMode, $whichRunFirst , $whichRunSecond);	
				    echo "<div id= 'run" . $runToPrint . "' style='display:block' name='disappearing'>";
				    echo "<h4>Runs selected : " . $runToPrint . "<br>";
		                    echo "Kind of analysis selected: <span id='kindAnalysis'>" . $whichAnalysis . "</span></h4><br>";
		                    	
				    if( $cardinality == "textual" ) // case textual input
		            {
						echo "textual";
		                $o = runRangeSheet($whichAnalysis, $gAnPath);
		            }
				    if( $cardinality == "single" )
				    {	
						echo "single";
		    			$o = runSingle( $whichRunFirst, $whichAnalysis, $gAnPath);
		    		}
				    if ( $cardinality == "multipleRange" )
				    {
						echo "multipleRange: " . $whichRunFirst . "---" . $whichRunSecond;
						$o = runRange( $whichRunFirst, $whichRunSecond, $whichAnalysis, $gAnPath);
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
            
            	$runs = $whichRunFirst;
                $runs = explode(";", $runs);
                echo "<p id='getRuns' hidden>";
                for( $i = 0; $i < count( $runs ); $i++)
                {
                    echo "-" . $runs[ $i ];
                }
        		if ($cardinality == "multipleRange")
        		{
        			echo $whichRunSecond;
        			array_push($runs, $whichRunSecond);
        		}
                if($textMode == "on")
                {
                    echo $textFromTextMode;
                }
                echo "</p>";
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
 
         /div>    
    </body>    
</html>
