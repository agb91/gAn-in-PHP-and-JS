//alert ("called");

function changer(position, newValue)
{
    group = groups[position];
    values[position] = newValue;
    if(newValue==1)
    {
        $("#label"+group).text(group + " now: "+"Yes");
        $("#" + group + "Button").text(group + " " +"Yes"); 
    }
    else
    {
        $("#label"+group).text(group + " now: "+"No");
        $("#" + group + "Button").text(group + " " +"No"); 
    }
    $("#configConfirmationButton").toggleClass("btn-primary",false);
    $("#configConfirmationButton").addClass("green");
}

function moveRange (n)
{
	$( "#rangeResult" ).text( "Selected Scale: 10e" + n );
}

//send to the apposite php file the chosen parameters, using GET (if I use
// post it is the same...)
function writeToFile(file)
{
    var toPrintValues = [];
    for (i = 0; i < groups.length; i++)
    {
        if(values[i]==1)
        {
            toPrintValues.push("yes");
        }
        else
        {
            toPrintValues.push("no");
        }
    }

    var toAlert = "";
    toAlert = "you 've inserted: \n ";
    for (i = 0; i < groups.length; i++)
    {
        toAlert+= groups[i] + " : " + values[i] + " \n ";
    }
 

    var toHref = "";
    toHref = 'PHP/editConfigFunction.php/?';
    for (i = 0; i < groups.length; i++)
    {
        if(i==0)
        {
            toHref+= groups[i] + '=' + values[i];
        }
        else// the & symbol is useless at the beginning....
        {
            toHref+='&' + groups[i] + '=' + values[i];
        }        
    }
    toHref+="&path=" + file;
  
    window.location.href = toHref;
}


