//when jquery is loaded and document is ready (we can't do nothing before): 
$( document ).ready(function() {
    $( "#datepicker" ).datepicker();
    lastDate = $( "#lastTime" ).text();
    dd = lastDate.split( "/" )[0];
    mm = lastDate.split( "/" )[1];
    yy = lastDate.split( "/" )[2];
    $( "#datepicker" ).datepicker( 'setDate' , mm + '/' + dd + "/" + yy );

    //to use the tooltip we have to initialize it here
    $('[data-toggle="tooltip"]').tooltip();

    //the following commands are always are executed sometimes in single
    //version of the interface, some other times in multiple 
    //validate the inserted runs
    //first of all, disable the run-send-button (until the run number isn't correct)
    //$( "#sendRunButtonSingle" ).prop("disabled",true);
    $( "#sendRunButtonSingle" ).prop("disabled",true);
    $( "#sendRunButtonMultiple" ).prop("disabled",true);
    $( "#warningRunNumberMultiple" ).hide();
    $( "#warningSelectAnalysisMultiple" ).hide();

    $( "#areaBlock" ).keyup(function() {//check every time the user uses the keyboard 
    	validate();
    });
    
    $( "#whichRunsMultiple" ).keyup(function() {//check every time the user uses the keyboard 
        validate();
    });
    $( "#whichRunsMultipleSecond" ).keyup(function() {//check every time the user uses the keyboard 
        validate();
    });	

    $( "#buttonSelectAnalysisMultiple" ).click(function() {//check every time the user click this button
        validate();
    });
    $( "#whichRunsMultiple" ).click(function() {//check every time the user clicks with the mouse on the input form
        validate();
    });
    $( "#whichRunsMultipleSecond" ).click(function() {//check every time the user clicks with the mouse on the input form
        validate();
    });

    $( "#mouseOverTargetMultiple" ).mouseover(function() {
        validate();
    });
});

function showRange()
{
    $( "#rangeBlock" ).show();
    $( "#areaBlock" ).hide();
}

function showArea()
{
    $( "#rangeBlock" ).hide();
    $( "#areaBlock" ).show();
}

function hideInputNumbers()
{
    if ( $('#sheetSelector').is(':checked') ) 
    {
	$( "#opacityChanges" ).addClass( "transparent" );
    }
    else
    {
	$( "#opacityChanges" ).toggleClass( "transparent" );
    }
}

//select if you want to work with single or multiple runs
function selectSingleVsMultiple( n )
{
    $( "#chooseModality" ).hide();
    $( "#changeModality" ).show();
    if( n == 0)//and the other red
    {
        $( "#modalityWell").text( "You are working with Single Run Analysis" );
        $( "#modalityWell").show();    
    }
    else
    {
        $( "#modalityWell").text( "You are working with Multiple Runs Analysis" );
        $( "#modalityWell").show();
    }
    showOtherObject(n);    
}

function setGreen(n)
{
    var dates = $( "#allDates" ).text();
    var dates = dates.split( ";-;" );
    for( var i = 0; i < dates.length ; i++)
    {
        $( "#link" + i ).toggleClass( "green" , false );
        $( "#link" + i ).addClass("white");
    }
    $( "#link" + n ).toggleClass( "white" , false );
    $( "#link" + n ).addClass("green");
}

function changeModality()
{
    location.reload();//simple reload the page and re-propose the choice
}

//show all the rest of the page
function showOtherObject( n )
{
    $( "#workBlock" ).show();
    if( n == 0)
    {
        $( "#multiple" ).hide();
        $( "#single" ).show();
    }
    else
    {
        $( "#multiple" ).show();
        $( "#single" ).hide();
    }
    
}

function readCleanRunSecond() // the second run in the multiple case is particulare.. we'll think about if this function has reason to exist
{
    var secondRun = $("#whichRunsMultipleSecond").val();
    return secondRun;
}

//it is a good idea if we standardize comma and '-' with semicolon
function readCleanRunFirst()
{
    var insertedRun = " ";
    insertedRun = $("#whichRunsMultiple").val();
    insertedRun = insertedRun.replace(new RegExp(",", "g"), ";");// we want to allow the user to separate the run numbers 
    //also with comma and '-' and point
    insertedRun = insertedRun.replace(new RegExp("-", "g"), ";");
    insertedRun = insertedRun.replace(new RegExp(" ", "g"), "");
    if( insertedRun.substr( insertedRun.length - 1 ) == ";" )
    {
        insertedRun = insertedRun.substr( 0 , insertedRun.length - 1 );
    }
    return insertedRun;
}

function selectDate( thisDate )
{
    var dates = $( "#allDates" ).text();
    var dates = dates.split( ";-;" );
    //var rex = /\S/;
    //dates = dates.filter(rex.test.bind(rex));
    for( var i = 0; i < dates.length ; i++)
    {
        $( "#run" + i ).hide();    
    }
    $( "#run" + thisDate ).show();
}

function validate( ) 
{
    var insertedRunFirst = readCleanRunFirst();
    var insertedRunSecond = readCleanRunSecond();
    var MultipleRuns;
   
    var numberProblemsFirst = 0;
    var numberProblemsSecond = 0;
    var analysisProblems = 0;

    //have you selected an analysis?
    if( $("#buttonSelectAnalysisMultiple").text() == "Select an Analysis:"  )
    {
        analysisProblems++;
    }

    if ( acceptable ( insertedRunFirst ) == 1 )
	{
	    numberProblemsFirst++;
	}

	if ( ( acceptable ( insertedRunSecond ) == 1 ) && !(insertedRunSecond === "") ) 
		//the second can be empty.. insingle run analysis case
	{
	    numberProblemsSecond++;
	}

	//related to the first input
    if (numberProblemsFirst == 0)        
    {
        //$( "#warningRunNumberMultiple" ).hide();
    	$( "#rowOfMultipleInputFirst" ).removeClass( "has-error has-feedback" );
    }
    else
    {
        //$( "#warningRunNumberMultiple" ).show();
    	$( "#rowOfMultipleInputFirst" ).addClass( "has-error has-feedback" );
    }

    //related to the second input
    if (numberProblemsSecond == 0)        
    {
        //$( "#warningRunNumberMultiple" ).hide();
    	$( "#rowOfMultipleInputSecond" ).removeClass( "has-error has-feedback" );
    }
    else
    {
        //$( "#warningRunNumberMultiple" ).show();
    	$( "#rowOfMultipleInputSecond" ).addClass( "has-error has-feedback" );
    }

	var totNumbersProblems = numberProblemsFirst + numberProblemsSecond;
	if( totNumbersProblems == 0 )
	{
	    $( "#warningRunNumberMultiple" ).hide();	
	}
	else
	{
	    $( "#warningRunNumberMultiple" ).show();	
	}

    if (analysisProblems == 0)        
    {
        $("#warningSelectAnalysisMultiple").hide();
    }
    else
    {
        $("#warningSelectAnalysisMultiple").show();
    }

   
	var textual = $( "#runsTextualInput" ).val();
    
	var insertedRows = textual.split(/\r?\n/);
    
    var numberProblemsText = 0;
        	
    for (r in insertedRows)
	{
    	var insertedArray = insertedRows[r].split( "-" ); 
    	for (i in insertedArray) 
	    {
    		insertedArray[i] = insertedArray[i].trim();
            if ( acceptable ( insertedArray[ i ] ) == 1 )
            {
            	numberProblemsText++;
            }
	    }
	}
            
    if (numberProblemsText == 0)        
    {
        $( "#runsTextualInput" ).removeClass( "red-border" );
    }
    else
    {
        $( "#runsTextualInput" ).addClass( "red-border" );
    }
    

    if( ( numberProblemsText==0 || totNumbersProblems==0) && analysisProblems == 0)
    {
        $("#sendRunButtonMultiple").prop("disabled",false);
        $("#sendRunButtonMultiple").removeClass( "red" ).addClass( "green" );        }
    else
    {
        $("#sendRunButtonMultiple").prop("disabled",true);
        $("#sendRunButtonMultiple").removeClass( "green" ).addClass( "red" );
    }

}

function manageWait() {
    $( "#commonTop" ).hide();
    $( "#commonSemiTop" ).hide();
    $( "#workBlock" ).hide();
    $( "#modalityWell").hide();
    //$( "#commonWait").show();
    w = document.getElementById("commonWait");
    w.style.display = 'block';//show the label with "wait until...."
   

}


//check if there is another chunk with the same name, (double runs are useless)
function checkAlreadyExist(needle)
{
        needle = " " + needle; //javascript wants a string or it will crash with the trim....
        haystack = $("#whichRunsMultiple").val().split(";");
        var alreadyExist = false;
        for (i in haystack) 
        {
            //console.log("needle " + needle);
            if(haystack[i].trim()==needle.trim())
            {
                alreadyExist = true;
            }
        }
        return alreadyExist;
}

/*
add the range of runs written in the modal to the input form
*/
//write which analysis the user chooses 
function setAnalysis( i , n )
{
    if( n == 0)
    {
        var analyzes = $("#analyzesSingle").text();
        var analyzesVector = analyzes.split("--");
        var selectedAnalysis = analyzesVector[ i ];
        $("#selectedAnalysisSingle").val(selectedAnalysis);
        $("#buttonSelectAnalysisSingle").text("Selected: " + selectedAnalysis);
    }
    else
    {
        var analyzes = $("#analyzesMultiple").text();
        var analyzesVector = analyzes.split("--");
        var selectedAnalysis = analyzesVector[ i ];
        $("#selectedAnalysisMultiple").val(selectedAnalysis);
        $("#buttonSelectAnalysisMultiple").text("Selected: " + selectedAnalysis);
    }
    validate( n );
}

//has this run number some problems? (not unique, not a number, not empty)
// 0=good;      1=bad
function acceptable( r )
{
    //console.log(r);
    var risp = 1;
    if($.isNumeric(r) )
    {  
        risp = 0;
    }
    //console.log(risp);
    return risp;
}



