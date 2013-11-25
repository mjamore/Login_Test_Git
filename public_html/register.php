<?php
	
	// Connect to DB via connect_to_db.php file
	include("../includes/php/connect_to_db.php");



	// Store form values from login_test.php in variables; strip any leading or trailing whitespaces
	$newEmail = trim($_POST['newEmail']);
	$newPW = trim($_POST['newPW']);
	$newConfPW = trim($_POST['newConfPW']);

	// Sanitize email address that user input
	$safe_newEmail = mysqli_real_escape_string($dbConnection, $newEmail);	
	

?>

<html>
	<head>
		<title>Login Test Results Page</title>
		<link rel="stylesheet" type="text/css" href="../includes/css/site_wide.css" />
		<link rel="stylesheet" type="text/css" href="../includes/css/register.css" />
	</head>
	<body>

		<?php include("../includes/php/page_title.php"); ?>


		<?php

		// Make sure email address that was entered is in a valid format
		if(filter_var($safe_newEmail, FILTER_VALIDATE_EMAIL))
		{
			$valid_newEmail = $safe_newEmail;
			echo "Email address was valid.<br>";
		} else {
			$valid_newEmail = '';
			echo "Email address was invalid.<br>";
		}

		
		// Only run this code if the email address is valid
		if($valid_newEmail != '')
		{
			

			// Check to see if email address that user entered is already in the database

			// 1. Check database "email" column to see if there is a match to what the user entered
			$queryCheckAllEmails = "SELECT * FROM users WHERE email = '{$valid_newEmail}' LIMIT 1";
			$queryCheckAllEmailsResult = mysqli_query($dbConnection, $queryCheckAllEmails);
			
			// If the email address the user entered is already in the database 'email' column, then notify the user that the email address has already been registered; otherwise, validate the 2 passwords and add the new user to the database
			if($dbEmail = mysqli_fetch_assoc($queryCheckAllEmailsResult))
			{
				echo "'" . $valid_newEmail . "' has already been registered.  No change has been made to the database.<br>";
				echo "<a href='/~Michael/Login_Test_Git/public_html/home.php'>Return to Homepage</a>";
			}
			else
			{

				// Sanitize the user input to strip any code/tags that may have been entered
				$safe_newPW = mysqli_real_escape_string($dbConnection, $newPW);
				$safe_newConfPW = mysqli_real_escape_string($dbConnection, $newConfPW);

				if($safe_newPW !== '' && $safe_newConfPW !== '')
				{
					if($safe_newPW === $safe_newConfPW)
					{
						// combine these into one variable
						$equalPws = $safe_newPW;
						if(strlen($equalPws) < 8)
						{
							echo "Password must be at least 8 characters.<br>";
						}
						else
						{
							// Make sure PW contains at least 1 capital letter, at least 1 lowercase letter, and at least 1 number
							$uppercase = preg_match('@[A-Z]@', $equalPws);
							$lowercase = preg_match('@[a-z]@', $equalPws);
							$number    = preg_match('@[0-9]@', $equalPws);

							if(!$uppercase || !$lowercase || !$number)
							{
				  				// tell the user something went wrong
				  				echo "Password must contain at least 1 capital letter, at least 1 lowercase letter, and at least 1 number.";
							}
							else
							{
								// Perform database query
								$queryAddUserToDB  = "INSERT INTO users (email, password) 
									VALUES ('{$newEmail}', '{$equalPws}')";
								$queryAddUserToDBResult = mysqli_query($dbConnection, $queryAddUserToDB);

								// Test if there was a query syntax error
								if ($queryAddUserToDBResult) {
									// Success
									echo "'" . $valid_newEmail . "' has been registered.<br>";
									echo "<a href='/~Michael/Login_Test_Git/public_html/home.php'>Return to Homepage</a>";
								}
								else {
									// Failure
									die("Failed to add new user to database.  MySQL error: " . mysqli_error($dbConnection));
								}
							}
						}
					}
					else
					{
						echo "Passwords did not match.<br>";
					}
				}
				else
				{
					echo "You must fill in both password fields.<br>";
				}

			}
		}
		else
		{
			// If the email address that the user entered was not valid, notify the user
			echo "Must enter a valid email address.<br>";
			echo "'" . $safe_newEmail . "' has not been registered.<br>";
			echo "<a href='/~Michael/Login_Test_Git/public_html/home.php'>Return to Homepage</a>";
		}

		?>

		<?php include("../includes/php/display_db.php"); ?>

	</body>
</html>

<!-- Close DB connection -->
<?php include("../includes/php/disconnect_from_db.php"); ?>