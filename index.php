<?php
	session_start();
	/*

			RRC Admin Web Portal for Student Life App
			

			Allow admin access to Student Life App database items

	*/
	// require database connection script
	require('studentlife_connect.php');


	/*
		Add functions script
	*/
	require('functions.php');
	
	/*
		Check connection is SSL
	*/
	if(isset($_GET['logout']))
	{
		$_SESSION['logged_in'] = false;
		header('Location:index.php');
	}
	
	/* 
		Check login
	*/
	// Is logged_in set?
	if(!(isset($_SESSION['logged_in'])))
	{
		$_SESSION['logged_in'] = false;
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>RRC - Student Life App Admin</title>

		<!-- css -->
		<link rel="stylesheet" href="css/main.css" >
		<link rel="stylesheet" href="css/posts.css" >
		<link rel="stylesheet" href="css/events.css" >
		<link rel="stylesheet" href="css/admins.css" >
		<link rel="stylesheet" href="css/users.css" >
		<link rel="stylesheet" href="css/facebook.css" >
		<link rel="stylesheet" href="css/tokens.css" >

		
	</head>
	<body>
		<?php include('header.php'); ?>
		
			<div id="content">
				<?php $_SESSION['logged_in'] ? require('main.php') : require('login.php'); ?>
			</div>
		
		<?php include('footer.php'); ?>
	</body>
</html>