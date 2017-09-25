<?php
	
	// Database Connection Information
	$servername    = "127.0.0.1";
	$database_user = "";
	$db_password      = "";
	$dbname        = "";

	$connection = mysqli_connect($servername, $database_user, $db_password, $dbname);
	session_start(); // Starting Session
	
	$user_check    = $_SESSION['login_user'];
	$ses_sql       = mysqli_query($connection, "select Name from sodingUser where Name = '$user_check'");
	
	$row           = mysqli_fetch_assoc($ses_sql);
	$login_session = $row['Name'];
	if (!isset($login_session)) {
	    mysql_close($connection); // Closing Connection
	    header('Location: index.php'); // Redirecting To Home Page
	}
?>