 function rootDownload()
 {
 	var run = $("#rootFileRun").text().trim();
 	toHref = 'downloadRootFile.php?run=' + run ;
    window.location.href = toHref;
 }

