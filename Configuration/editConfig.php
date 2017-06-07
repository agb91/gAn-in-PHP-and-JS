	<!DOCTYPE html>
<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="../JS/jquery.js"></script>
        <script src="../JS/editConfigJs.js"></script>
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="../CSS/editConfig.css" rel="stylesheet" media="screen">
        <link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="configurator">  
        <?php
        session_start(); // Starting Session
        
        if (!strcmp($_SESSION['logged'], "logged") == 0)
        {
        	echo "not logged";
        	header("location: ../Login/logPage.php");
        }
        
        include '../Globals.php';
        include 'editConfigFunctions.php';
        
        $groups = getAllGroups( $xmlConfigFilePath );
        //print_r( $groups );
        $values = getAllValues( $xmlConfigFilePath , "analysis_base");
        //print_r( $values );
        //echo $values[0];

        ?>
        <script>

            path = '<?php echo $xmlConfigFilePath; ?>';
            
            groups = [];
            values = [];
            //why this horrible construction? because javacript is not very happy to use php code like argument..
            groups.push('<?php echo $groups[0]; ?>');
            groups.push('<?php echo $groups[1]; ?>');
            groups.push('<?php echo $groups[2]; ?>');
            groups.push('<?php echo $groups[3]; ?>');
            groups.push('<?php echo $groups[4]; ?>');
            groups.push('<?php echo $groups[5]; ?>');
            groups.push('<?php echo $groups[6]; ?>');
            groups.push('<?php echo $groups[7]; ?>');
            groups.push('<?php echo $groups[8]; ?>');
            groups.push('<?php echo $groups[9]; ?>');

            values.push('<?php echo $values[0]; ?>');
            values.push('<?php echo $values[1]; ?>');
            values.push('<?php echo $values[2]; ?>');
            values.push('<?php echo $values[3]; ?>');
            values.push('<?php echo $values[4]; ?>');
            values.push('<?php echo $values[5]; ?>');
            values.push('<?php echo $values[6]; ?>');
            values.push('<?php echo $values[7]; ?>');
            values.push('<?php echo $values[8]; ?>');
            values.push('<?php echo $values[9]; ?>');
        </script>   

        <div class = "row" >
            <ul class="nav nav-tabs navbar-default">
                <li class="nav-item">
                    <a class = "nav-link active" onclick="writeToFile(path)">
                        <h3> Save </h3>    
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="Look at the images created by running gAn">
                    <a class = "nav-link active" >
                        <h3> Set Default </h3>    
                    </a>
                </li>
                <li class="nav-item" data-toggle='tooltip' title='Download the .root file related to the selected run'>
                    <a class="nav-link" href="index.php">
                        <h3> Back Home </h3>    
                    </a>
                </li>
            </ul>
        </div>

        <div class='row'>
		    <br> 
		    <h1>Scales Group</h1> 
		    <br>
		    <div class='well well-sm col-xs-7'>	
			    <div class='row'>
				    <div class='col-xs-12'> <label for='rebin'><h4>Histogram Scale</h4></label></div>
				    <div class='col-xs-8'><input onchange='moveRange(this.value)' type='range' min='1' max='6' value='4' id='rebin'></div>
				    <div class='col-xs-3'><label id='rangeResult'> Histogram Scale: 10e4 </label></div>
			    </div>
			    <br><br>
		    </div>
		    <div class='well well-sm col-xs-7'>	
			    <div class='row'>
				    <div class='col-xs-12'> <label for='rebin'><h4>Verbosity Scale</h4></label></div>
				    <div class='col-xs-8'><input onchange='moveRange(this.value)' type='range' min='1' max='5' value='4' id='rebin'></div>
				    <div class='col-xs-3'><label id='rangeResult'> Verbosity Scale: 4 </label></div>
			    </div><br><br>
		    </div>
		</div>		
	
		<?php 
		    //normal ones
		    echo "<div class='row'>";
		    echo "<br> <h1>Sensor Enabling Group</h1> <br>";
	            for ($i = 1; $i < count($groups); $i++) 
	            {
	                echo '<div class="well well-sm col-xs-6">';
	                echo '<h4 class="col-xs-12"> ' . $groups[$i] . ' possible values: </h4>';
	                echo '<div class="dropdown col-xs-6">';
	                echo '<button id="' . $groups[$i] . 'Button" class="btn btn-primary dropdown-toggle buttonWidth" type="button" data-toggle="dropdown">' . $groups[$i] . ' possible values:
	                        <span class="caret"></span></button>
	                        <ul class="dropdown-menu">
	                          <li><a href="#" onclick="changer' . '(' . $i . ',0)">No</a></li>
	                          <li><a href="#" onclick="changer' . '(' . $i . ',1)">Yes</a></li>
	                        </ul>';
	                echo '</div>'; 
	                echo '<div class="col-xs-6">';
	                echo '<label id="label' . $groups[$i] . '"> ' . $groups[$i] . ' now:  </label>';
	                echo '</div>';
	                echo '</div>';
	            }
		    echo "</div>";

        ?>

        <script src="JS/editConfigInitializer.js"></script>

   
    </body>
</html>    



