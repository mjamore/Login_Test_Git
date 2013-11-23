<?php
	// Get database login credentials from external file
	include("login_test_credentials.php");

	// 1. Connect to database
	$dbConnection = mysqli_connect($host, $user, $password, $dbName);

	// Test if connection occurred
	if(mysqli_connect_errno()) {
		die("Database connection failed: " .
			mysqli_connect_error() .
			" (" . mysqli_connect_errno() . ")"
		);
	}// Close database connection test
?>