// to deeply understant how this page works, read the short documentation about ROOTJS
// at this link: https://github.com/linev/jsroot/blob/master/docs/JSROOT.md  


function updateGUI() {
    // if getting histogram from THttpServer as JSON string, one should parse it like:
    // var histo = JSROOT.parse(your_json_string);

    // this is just generation of histogram
    var run = 58880;
    //console.log("read run: " + run);
    
    var filename = "output/gAnOut_" + run + ".root";
    JSROOT.OpenFile(filename, function(file) {
        //console.log(file);
        for (var i=1;i<2;i++)//for all the keys in the file
        {
            var cnt = 1;//in which div the image will be positioned
            var name = file.fKeys[i].fName; 
            //use toUpperCase to have a caps insensitive confrontation 
            console.log(name);
            //if(name.toUpperCase().indexOf(image.toUpperCase())>-1)//if name and image are equal ignoring case
            {
                file.ReadObject(name, function(obj) {//read the object in the file
                    //console.log('object_draw'+(cnt));
                    JSROOT.redraw('place1', obj, "colz");//draw the object, in the div object_drawCNT
                    // colz means with co
                });
            }
        }
    });    

}



$( document ).ready(function() {// start only when the page is already charged, to avoid all problems
  updateGUI();
});



