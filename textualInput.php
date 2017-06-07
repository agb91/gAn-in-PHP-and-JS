<!DOCTYPE html>
<html>
    <head>
        <title>gAn web interface</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <script src="jqueryUI/jquery-ui.js"></script>
        <script src="JS/textualInput.js"></script>
        <link rel="stylesheet" href="jqueryUI/jquery-ui.css">
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="CSS/index.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="indexGeneral"> 
	<div class="form-group">
		<label for="comment">Insert some runs:</label>
		<textarea id="runs" class="form-control" rows="5" id="comment"></textarea>
	</div>
	<div hidden id="analysis"><?php $a = $_GET["analysis"]; echo $a; ?></div>
	<button type="button" class="btn btn-primary" onclick="save()">Save</button>


        
    </body>
</html>

