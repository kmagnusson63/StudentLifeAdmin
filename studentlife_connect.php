 <?php
 	// error_reporting(0);
	define('DB_HOST','68.178.143.5');
	define('DB_USER','rrcproject');
	define('DB_PASS','UserPass1!');
	define('DB_NAME','rrcproject');
	// define('DB_HOST','192.168.8.10');
	// define('DB_USER','studentlife_user');
	// define('DB_PASS','password');
	// define('DB_NAME','studentlife');
	// Create a MySQLi resource object called $db.
	$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 

	// If an error occurs we can look here for more info:
	$connection_error = mysqli_connect_errno();
	$connection_error_message = mysqli_connect_error();
 ?>