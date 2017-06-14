<?php
	session_start(); // Starting Session
	//echo "I'm checking..";
	if (isset($_POST['submit'])) 
	{
		if (empty($_POST['password'])) 
		{
			echo "Password is invalid";
		}
		else
		{
			$password=$_POST['password'];
			$realPassword = "975cc36a3d025867b93bc724481aff55";
			
			if (strcmp( md5($password) , $realPassword) == 0) 
			{
				$_SESSION['logged']="logged"; // Initializing Session
				echo "session now : " . $_SESSION['logged'];
				header("location: ../Home/index.php"); // Redirecting To Home Page
				//echo "all is ok";
			}
			else 
			{
				echo "<div class='error'> <h1> This Password is not valid </h1></div><br><br>";
			}
			
		}
	}
?>
