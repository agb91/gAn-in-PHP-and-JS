<?php
    session_start(); // Starting Session
    if (!strcmp($_SESSION['logged'], "logged") == 0)
    {
        echo "not logged";
        header("location: logPage.php");
    }
    else
    {
        include 'Globals.php';
        include 'PHP/genericFunctions.php';
        include 'PHP/imagesFunctions.php';
        include 'PHP/runnerFunctions.php';
        include "PHP/imagesFunctionsRoot.php";


        //print_r($_POST);

	//first: understand in which case we are
	$textMode = $_POST["optSheet"];
	//echo "textMode: " . $textMode . "<br>";
	$whichRunSecond = cleanRuns( $_POST["whichRunSecond"]);
	$whichRunSecond = cleanString( $whichRunSecond );
	//echo "whichRunSecond: " . $whichRunSecond  . "<br>";

	$whichRunFirst = cleanRuns( $_POST["whichRun"] );
	$whichRunFirst = cleanString( $whichRunFirst );
	//echo "whichRunFirst: " . $whichRunFirst  . "<br>";

	$cardinality = getCardinality($textMode , $whichRunFirst , $whichRunSecond);
	//echo "case: " . $cardinality;

        $textFromTextMode = fileReaderGeneral("$gAnPath" . "runSheet.txt");
        $piecesOfRun = [];
        
        if($cardinality == "single" || $cardinality == "multipleRange")// so in the cases in which run number exists...
        {
            $piecesOfRun = explode(";", $whichRunFirst);
            //print_r( $piecesOfRun );

            $whichRunSecond = explode(";", $whichRunSecond)[0];// a this state the second is always a single number.. but we'll probably change idea there
	    //print_r( $piecesOfRunSecond );
        }

        $whichAnalysis = $_POST["selectedAnalysisSingle"];
        $whichAnalysis = $whichAnalysis . $_POST["selectedAnalysisMultiple"];
        //print_r($_POST);
        //echo "the read analysis is : " . $whichAnalysis;
        $whichAnalysis = cleanString( $whichAnalysis );


    	
    	//echo "text mode: " . $textMode;


    }
?>

<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <script src="JS/imagesJs.js"></script>
        <script src="JS/runnerJs.js"></script>
        <link rel="stylesheet" href="CSS/runner.css" media="screen">
        <link rel="stylesheet" href="CSS/images.css" media="screen">
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.js"></script>
        <script src="JSROOTlibraries/scripts/JSRootCore.js" type="text/javascript"></script>
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
                    <a class="nav-link" href="index.php">
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
                <nav id="navBlock" data-toggle="tooltip" title=" Select by run which results to show " class="fixedTopLeft" aria-label="Page navigation">
                    <ul class="pagination">            
                        <?php
                            /*! \brief this script allows us to show in the navbar the chosen runs 
                            *
                            *  we can select a run in the navbar, the program will show only the output
                            *  related to the chosen run (it is very useful if we selected multiple runs)
                            */

                            // clean the read values: no white spaces, no doubles, no comma or point or '-'




                            /*for ($i = 0; $i < count($piecesOfRun)-1; $i++) //show the possible runs computed, the user can chose
                            {
                            //navclick will hide the useless information and show only the run that the user selected
                            echo "<li><a onclick='navClick(" . $piecesOfRun[$i] . ")'> run: " . $piecesOfRun[$i] . "</a></li>";
                            //echo ($i+1) . "° run: |" . $piecesOfRun[$i] .  "|<br>";
                            } */
                        ?>
                    </ul>
                </nav>
                <?php
		    $runToPrint = getRunToPrint( $cardinality , $textFromTextMode, $whichRunFirst , $whichRunSecond);	
		    echo "<div id= 'run" . $runToPrint . "' style='display:block' name='disappearing'>";
		    echo "<h4>Runs selected : " . $runToPrint . "<br>";
                    echo "Kind of analysis selected: <span id='kindAnalysis'>" . $whichAnalysis . "</span></h4><br>";
                    	
		    if( $cardinality == "textual" ) // case textual input
                    {
			//echo "textual";
                    	$o = runRangeSheet($whichAnalysis, $gAnPath);
                    }
		    if( $cardinality == "single" )
		    {	
			//echo "single";
    			$o = run($piecesOfRun[0], $whichAnalysis, $gAnPath);
    		    }
		    if ( $cardinality == "multipleRange" )
		    {
			//echo "multipleRange: " . $piecesOfRun[0] . "---" . $whichRunSecond;
			$o = runRange($piecesOfRun[0], $whichRunSecond, $whichAnalysis, $gAnPath);
    		    }
		    
		    $outputBlocks = getBlocks( $o );
                    printBlocks( $outputBlocks );
		    //echo " debug part: ";
            	    $zomb = findZombies();
                    //print_r($zomb);
                    killZombies($zomb);
   	            echo "</div>";

                ?>
            </div>
        </div>







        <!-- FROM HERE IMAGES! -->








        <div id = "picturesTab" class = "imagesGeneral" >


	    <div id="imagesName" hidden></div>
	    <?php createCheckBoxImages(); ?>

            <?php
            //echo "alive! here is alive!";
            session_start(); // Starting Session
            if (!strcmp($_SESSION['logged'], "logged") == 0)
            {
                header("location: logPage.php");
            } 
            else
            {
                //echo "alive!";
                //read runs from get method
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
                //echo "my runs: ";
                //print_r($runs);
            }


            ?>
            <!--<div class="row">    
                <div class="col-xs-2"></div>
                <div class="col-xs-8">
                    <h1>The analyzed Runs show these images as output:</h1> 
                    <div class="row">   
                        <div data-toggle="tooltip" title="Choose between large, medium or little images"class="col-xs-4 well well-sm">
                            <h4 class="col-xs-12"> Set dimension: </h4>
                            <div class="dropdown col-xs-12">
                                <button id = "dimensionButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Images Dimension:
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                  <li><a href="#" onclick="setImageDimension(0)">Little</a></li>
                                  <li><a href="#" onclick="setImageDimension(1)">Medium</a></li>
                                  <li><a href="#" onclick="setImageDimension(2)">Big</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-4 well well-sm">
                            <h4 class="col-xs-12"> Group to show: </h4>
                            <div class="dropdown col-xs-12">
                                <button id="groupToShowButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Group to show:
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" onclick="selectImageType(0)">
                                            <?php 
                                                echoGroupList($allAnalyzesSingle);
                                            ?>
                                        </a>
                                    </li>
                                </ul>
                            </div> 
                        </div>  
                        <div class="col-xs-4 well well-sm">
                            <h4 class="col-xs-12"> Runs to show: </h4>
                            <div class="dropdown col-xs-12">
                                <button id="runToShowButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Runs to show:
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <?php

                                        //print the existing runs (the runs that the user selected in the homepage)
                                        showRuns($runs);
                                    ?>
                                </ul>
                            </div> 
                        </div> 


                    </div>    
                </div>
                <div class="col-xs-2"></div>
            </div>-->

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
 
            <!-- just to set the default configuration when the user enters in this page -->        
            <!--<script src="JS/imagesInitializer.js"></script>-->
        </div>    
    </body>    
</html>
