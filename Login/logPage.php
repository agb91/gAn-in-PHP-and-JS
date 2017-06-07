<?php
	include('loginFunctions.php'); // Includes Login Script
?>
<!DOCTYPE html>
<html>
	<head>
		<title>gAn web interface</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="../JS/jquery.js"></script>
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="../CSS/logPage.css" rel="stylesheet" media="screen">
        <link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body class="indexGeneral">
		<div id = "commonTop" class="col-xs-12">
            <div class="row">
                <div class="col-xs-3"></div>
                <div class="col-xs-6">
                    <img src="../images/aegisLogo-black.gif" class="logoImage">
                </div>
                <div class="col-xs-3"></div>
            </div>
        </div>
        <div class = "space"></div>
		<div class="container">
			<h2 class="form-signin-heading">Insert AEgIS experiment's password to start</h2>
			<form action="" method="post" class="form-signin">
				<label for="inputPassword" class="sr-only">Password</label>
				<input id="password" name="password" placeholder="**********" type="password" class="form-control">
				<br>
				<button class="btn btn-lg btn-primary btn-block" name="submit" type="submit" value=" Login "> Login </button>
				<!--<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>-->
			</form>
		</div> 
	</body>
</html>