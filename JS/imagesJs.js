//alert("loaded");

function showSingleImage(n)
{
    if ( $( "#inputCheckValue"+n ).is( ":checked" ) ) 
    {
         //alert( "I'll show image: " + n );
	 $( "#image" + n ).show();
    }
    else
    {
	//alert( "I'll hide image: " + n );
        $( "#image" + n ).hide();
    }
}

// if the user clicks on "images" on the navbar
function showImages()
{
    $( "#runnerTab" ).hide();
    $( "#picturesTab" ).show();  
        
    //var arraySvgIcons = $("[name='ToggleZoom']");
    //alert( arraySvgIcons.length );    
}

// if the user clicks on "textual" on the navbar
function showTextualRunner()
{
    $( "#runnerTab" ).show();
    $( "#picturesTab" ).hide();    
}

// The user selects one run, this function shows him only what he selected.
// This function does this checking the names of the images, these names contain 
// the run-numbers
function selRun(run)
{
    $( "#runToShowButton" ).text( "Selected Run: " + run );
    /*$("img[name*='n']").hide(); //firstly we hide all images (all images have names that begin with 'n')
    $("item[name*='n']").hide(); //exactly the same with the item (is a contain) of the carousel
    $("img[name*=" + run+  " ]").show(); // after we show the group that interest us
    $("item[name*=" + run+  " ]").show(); //exactly the same with the li of the carousel
    */
}



//this function allow to chose what kind of images shown (there are some groups:
// mimito, scint ecc)
function selectImageType(n)
{
    var groups = $("#hereTheGroups").text();
    groups = groups.split("-");
    //alert( groups );
    var thisGroup = groups[ (n + 1) ];
    //alert( thisGroup );
    $( "#groupToShowButton" ).text( "Selected group: " + thisGroup );
    //alert(thisGroup);
    var typeSelected="none";
    images = $( '[id*="image"]' )
    for ( i = 0; i < images.length; i++ )
    {
        thisImage = images[ i ];
        thisImage.style.display = 'none';
        //alert( thisImage.id );
        id = thisImage.id;
        //alert( id );
        if( id.indexOf(thisGroup) !== -1 )
        {
            thisImage.style.display = 'block';
        }
    }
}

//this function allows the changing of the layout of the images (vertical or 
//carousel)
function selectSlideImage(n)
{
    $("#carouselBlock").hide();
    $("#verticalBlock").hide();
    if(n==0)
    {
        $("#layoutButton").text("Vertical Layout Images");
        //$("#labelImagesLayout").text("Now: Layout Images Vertical");
        $("#verticalBlock").show();
    }
    if(n==1)
    {
        $("#layoutButton").text("Carousel Layout Images");
        //$("#labelImagesLayout").text("Now: Layout Images Carousel");
        $("#carouselBlock").show();
    }
}


//when I click on an image I expect that it opens a new window with the image
//shown
function imageClicked(n, runs)
{
    window.location.href =  'showOneImage.php/?whichImage='+n + '&runs=' + runs; 
}


//this function allows to change the images dimensione according to the choice 
//taken in the dropdown menu 
function setImageDimension(n)
{
    images = $( '[id*="image"]' )
    for ( i = 0; i < images.length; i++ )
    {
        thisImage = images[ i ];
        //alert(thisImage.style);
        thisImage.style.removeProperty("height");
    }
    if(n==0)//little (is this usefull? maybe is too little?)
    {
        $("#dimensionButton").text("Selected dimension: Little");

        $("#verticalBlock").toggleClass("big", false);
        $("#verticalBlock").toggleClass("medium", false);
        $("#verticalBlock").addClass("little");
    }
    if(n==1)//medium
    {
        $("#dimensionButton").text("Selected dimension: Medium");
        
        $("#verticalBlock").toggleClass("big", false);
        $("#verticalBlock").toggleClass("little", false);
        $("#verticalBlock").addClass("medium");
    }
    if(n==2)//large
    {
        $("#dimensionButton").text("Selected dimension: Big");

        $("#verticalBlock").toggleClass("medium", false);
        $("#verticalBlock").toggleClass("little", false);
        $("#verticalBlock").addClass("big");
    }
}

function img_find() {
    var imgs = document.getElementsByTagName("img");
    var imgSrcs = [];

    for (var i = 0; i < imgs.length; i++) {
        imgSrcs.push(imgs[i].src);
    }

    return imgSrcs;
}

function downloadImages()
{
    var list = document.getElementsByTagName("svg");
    //alert( list[0] );
    for( i = 0; i < list.length; i++)
    {
        var svgData = list[ i ].outerHTML;
        //alert(svgData);
        //if( svgData.indexOf( '<svg class="jsroot root_canvas"' ) !== -1)
            
        if( svgData.indexOf( 'jsroot' ) !== -1)    
        {
            //alert( svgData );
            var svgBlob = new Blob([svgData], {type:"image/svg+xml;charset=utf-8"});
            var svgUrl = URL.createObjectURL(svgBlob);
            var downloadLink = document.createElement("a");
            downloadLink.href = svgUrl;
            downloadLink.download = "rootImageAegis.svg";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);    
        }      
    }
}

function isScrolledIntoView(el) {
    var elemTop = el.position().top;
    var myPosition = $( window ).scrollTop();
    //console.log( "top image: " + elemTop + ";  we are: " );
    var isVisible = ( elemTop <= myPosition );
    //console.log( isVisible );
    return isVisible;
}

function showTipWell()
{
    $( "#tipWell" ).show();
}

function hideTipWell()
{
    $( "#tipWell" ).hide();
}

// when the screen scroll understands if we are in the picture part
function scrolled()
{
    var picturesTab = $( "#picturesTab" );
    var ans = isScrolledIntoView( picturesTab );
    if( ans )
    {
        showTipWell();
    }
    else
    {
        hideTipWell();
    }
}

//simply wait a moment
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

//compare letters of the fName attribute
function compareStrings(a,b) {
  if (a.toString() < b.toString())
    return -1;
  if (a.toString() > b.toString())
    return 1;
  return 0;
}

/*
    why does this function exist? to assigna a position (and recover it) to each image
    , if we don't do this sometimes (rarely, but happens) the browser post the images 
    in the wrong order (in pmts this bug is horrible...)
*/
function getPositionFromName(needle, haystack)
{
    var answer = "";
    for(var i = 0; i < haystack.length ; i++)
    {
        var toCompare = haystack[i];
        //console.log(toCompare.slice(0, -4) + "  --vs--  " + needle);
        //if(toCompare.indexOf(needle) !== -1)
        if( compareStrings( toCompare.slice( 0, -4 ) , needle ) == 0 )
        {
            answer = haystack[i];
        }
    }
    return answer.split("---")[1];
}

function manageImagesMultiple(runsArray)//expected first and last runs
{
                var s = 0;
		var firstRun = runsArray[ 1 ];
		var lastRun = runsArray[ runsArray.length -1 ];
		var filename = "output/gAnOut_" + firstRun + "-" + lastRun + ".root";
		//alert(filename);
		var arrayFiles = [];
		//console.log( "The file name is: " + filename ); 
		//tipical error: filename doesn't exist. If error check this before. (maybe too many slash or no slash)
		JSROOT.OpenFile(filename, function(file) {
			//console.log("read file general: " + file);
		    for ( var i = 0; i < ( file.fKeys.length ); i++ )//for all the keys in the file
		    {
			console.log( "Multiple: I found the keys: " + file.fKeys[i].fName );
		        arrayFiles.push(file.fKeys[i].fName+"---"+i);
		    }
		    /*for( var h = 0; h < arrayFiles.length ; h++)
		    {
		        console.log("wrote array: " + arrayFiles[h]);
		    }*/

		    //actually only the first key make sense.. the lasts 2 are i and out,
		    // useless to print images
		    for ( var i = 0; i < ( file.fKeys.length - 1); i++ )//for all the keys in the file
		    {
		        var name = file.fKeys[i].fName;
			    //console.log("this is a read file key:" + name);
		        // for the hopened key open the (one, I hope) file
		        file.ReadObject(name, function(obj) 
		        {
		            var position = getPositionFromName(obj.fName, arrayFiles);
			    if( obj.fName != "out" )
			    {
			    	$( "#check" + position ).text( obj.fName );
			    	$( "#inputCheck" + position ).css("display", "");	
		            }
		            var kindAnalysis = $("#kindAnalysis").text();
				    var whereToDraw = 'image' + position; 
				
		            s++;
		            JSROOT.redraw( whereToDraw , obj);//draw the object, in the div whereToDraw
				});
		    }
		});  
}


function manageImagesText(textRuns)
{
        var s = 0;
        var filename = "output/gAnOut_" + textRuns.substring(1) + ".root";
        //alert(filename);
        var arrayFiles = [];
        //console.log( "The file name is: " + filename ); 
        //tipical error: filename doesn't exist. If error check this before. (maybe too many slash or no slash)
        JSROOT.OpenFile(filename, function(file) {
            //console.log("read file general: " + file);
            for ( var i = 0; i < ( file.fKeys.length ); i++ )//for all the keys in the file
            {
                console.log( "Textual: I found the keys: " + file.fKeys[i].fName );
                arrayFiles.push(file.fKeys[i].fName+"---"+i);
            }
            /*for( var h = 0; h < arrayFiles.length ; h++)
            {
                console.log("Textual log array: " + arrayFiles[h]);
            }*/

            //actually only the first key make sense.. the lasts 2 are i and out,
            // useless to print images
            for ( var i = 0; i < ( file.fKeys.length - 1); i++ )//for all the keys in the file
            {
                var name = file.fKeys[i].fName;
                //console.log("this is a read file key:" + name);
                // for the hopened key open the (one, I hope) file
                file.ReadObject(name, function(obj) 
                {
                    var position = getPositionFromName(obj.fName, arrayFiles);
	            if( obj.fName != "out" )
		    {
			$( "#check" + position ).text( obj.fName );
		        $( "#inputCheck" + position ).css("display", "");	
		    }        
                    var kindAnalysis = $("#kindAnalysis").text();
                    var whereToDraw = "image" + position; 
                    s++;
                    JSROOT.redraw( whereToDraw , obj);//draw the object, in the div whereToDraw
                });
            }
        });  
}


function manageImagesSingle(runsArray)//single or spread runs
{
		alert("Single, itaratiorns: " + runsArray.length);
	    for( var a = 0; a < (runsArray.length)  ; a++ )
	    {// the first and the last are useless.. 
		    //var n = 0;
		    var s = 0;
		    var thisRun = runsArray[ a ];
		    alert( "a=" + a + ";  runsArray = " + runsArray );
		    alert(thisRun);
		    var filename = "../output/gAnOut_" + thisRun + ".root";
		    alert("filename: |" + filename + "|");
			var arrayFiles = [];
			//console.log( "The file name is: " + filename ); 
			//tipical error: filename doesn't exist. If error check this before. (maybe too many slash or no slash)
			JSROOT.OpenFile(filename, function(file) {
			//console.log("read file general: " + file);
		    for ( var i = 0; i < ( file.fKeys.length ); i++ )//for all the keys in the file
		    {
		        console.log( "Standard: I found the keys: " + file.fKeys[i].fName );
		        arrayFiles.push(file.fKeys[i].fName+"---"+i);
		        logName(file.fKeys[i].fName);
		    }
		    /*for( var h = 0; h < arrayFiles.length ; h++)
		    {
		        console.log("wrote array: " + arrayFiles[h]);
		    }*/

		    //actually only the first key make sense.. the lasts 2 are i and out,
		    // useless to print images
		    //console.log(file.fKeys);
		    for ( var i = 0; i < ( file.fKeys.length ); i++ )//for all the keys in the file
		    {
		        var name = file.fKeys[i].fName;
			console.log("this is a read file key:" + name);
		        // for the hopened key open the (one, I hope) file
		        file.ReadObject(name, function(obj) 
		        {
			    
			    //console.log("hidden name: " + obj.fName);
			    var position = getPositionFromName(obj.fName, arrayFiles);
			    if( obj.fName != "out" )
			    {
			        $( "#check" + position ).text( obj.fName );
			        $( "#inputCheck" + position ).css("display", "");	
			    }		            
			    var kindAnalysis = $("#kindAnalysis").text();
			    //var whereToDraw = 'image' + thisRun + '-' + kindAnalysis + position; 
			    var whereToDraw = 'image' + position; 
		            s++;
		            JSROOT.redraw( whereToDraw , obj, "colz");//draw the object, in the div whereToDraw
			})
		    }
		});  
	    }
}

function logName(name)
{
	var old = $( "#imagesName" ).text();
	$( "#imagesName" ).text( old + "-" + name );
}

function updateGUI() 
{
	var runs = $( "#getRuns" ).text();
	alert(runs);
	
	var runsArray = runs.split("-");
	alert(runsArray);
	
	//var groups = $( "#hereTheGroups").text();
	//var groupsArray = groups.split("-");
	//alert( groupsArray );

	var cardinality = $( "#cardinality" ).text();
	alert(cardinality);	
	//console.log(runsArray);

	if (cardinality == "Single" || cardinality == "single")
	{
		manageImagesSingle(runsArray);
	}

	if (cardinality == "Multiple" || cardinality == "multiple")
	{
		manageImagesMultiple(runsArray);   
	} 

	if (cardinality == "textual")
	{
		manageImagesText(runs)  
	}

}

$( document ).ready(function() {// start only when the page is already charged, to avoid all problems
  updateGUI();
  //every time user scrolls the page
  window.onscroll = function() { scrolled() };
});

