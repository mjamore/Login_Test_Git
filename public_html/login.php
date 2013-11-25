<?php
	// Enable sessions
	session_start();

	// Connect to DB via connect_to_db.php file
	include("../includes/php/connect_to_db.php");



	//vStore login form values in variables; strip any leading or trailing whitespaces
	$returningEmail = trim($_POST['returningEmail']);
	$returningPW = trim($_POST['returningPW']);

	// Sanitize email address that user input
	$safe_returningEmail = mysqli_real_escape_string($dbConnection, $returningEmail);




	// If user submits the registation form from home.php:
	if($_SERVER['REQUEST_METHOD'] == "POST" )
	{
		// If the email and password fields are blank:
		if ( empty($_POST['returningEmail']) || empty($_POST['returningPW']) )
		{
			// Tell the user their input was invalid; username/password were incorrect
		}
		else
		{
			// Check the values the user entered against the database
			// Make sure email address that was entered is in a valid format
			if(filter_var($safe_returningEmail, FILTER_VALIDATE_EMAIL))
			{
				// PHP has determined that the value the user entered is a valid email address
				$valid_returningEmail = $safe_returningEmail;
				echo "Email address was valid. <br />";
			}
			else
			{
				// PHP has determined that the user has not entered a valid email address; set the $valid_returningEmail variable to an empty string
				$valid_returningEmail = null;
				echo "email address was not valid.";
			}

			// Only run this code if the email address is valid
			//if($valid_returningEmail != '')
			if(isset($valid_returningEmail))
			{

				// Check to see if email address that user entered is already in the database

				// 1. Check database "email" column to see if there is a match to what the user entered
				$queryCheckAllEmails = "SELECT * FROM users WHERE email = '{$valid_returningEmail}' LIMIT 1";
				$queryCheckAllEmailsResult = mysqli_query($dbConnection, $queryCheckAllEmails);
				
				// If the email address the user entered is already in the database 'email' column, then check to make sure the password the user entered matches the database value
				if($dbEmail = mysqli_fetch_assoc($queryCheckAllEmailsResult))
				{
					echo "We have a match: " . $dbEmail['email'] . " is equal to " . $valid_returningEmail . "<br />";
					if($_POST['returningPW'] == $dbEmail['password'])
					{
						// log user in
						echo "Successful login!<br>";

						// Remember the user is logged in
						$_SESSION['authenticated'] = true;

						// Save username in cookie for a week
						$_SESSION['returningEmail'] = $_POST['returningEmail'];
					}
					else
					{
						// Set $_SESSION['authenticated'] to 'false' since the user is not logged in
						$_SESSION['authenticated'] = false;

						// Clear out username cookie; 
						$_SESSION['returningEmail'] = null;

						// passwords did not match
						echo "Password did not match database entry.<br>";
					}
				}
				else
				{
					// Username was not found in database
					echo "Username not found in database.<br>";
				}
			}
		}
	}

	if(isset($_POST['logoutSubmitBtn']))
	{
		// Set $_SESSION['authenticated'] to 'false' since the user is not logged in
		$_SESSION['authenticated'] = false;

		// Clear out username session; 
		$_SESSION['returningEmail'] = null;
	}


	// FOR: LOGIN FORM; If username and password were submitted, compare their values to our hardcoded values:
	if(!empty($_POST['returningEmail']) && !empty($_POST['returningPW']))
	{

		
	}
	
?>



<html>
<head>
	<title>Database Test</title>
	<link rel="stylesheet" type="text/css" href="../includes/css/site_wide.css" />
	<link rel="stylesheet" type="text/css" href="../includes/css/login.css" />
	<script src="../includes/js/lib/jquery-1.9.1.js"></script>
	<script src="../includes/js/login.js"></script>
</head>

<body>

	<?php include("../includes/php/page_title.php"); ?>

	<?php if($_SESSION['authenticated'] == 'true' ) { ?>
		<h3>Hello, <?php if(isset($_SESSION['returningEmail'])) echo "'" . htmlspecialchars($_SESSION['returningEmail']) . "'"; ?>!  You are logged in.</h3>
		<!-- When user clicks logout button, delete sessions and redirect to home.php -->
		<button id="logoutBtn">Logout</button>
		<br>
		<!-- Provide a link back to the homepage that will keep the user logged in -->
		<a href="/~Michael/Login_Test_Git/public_html/home.php">Return to the homepage.</a>
		
		
	<?php } else { ?>
		<h3>You did not supply valid login credentials.  You are not logged in.</h3>
		<a href="/~Michael/Login_Test_Git/public_html/home.php">Return to the homepage.</a>
	<?php }  ?>

	<?php include("../includes/php/display_db.php"); ?>

</body>
</html>

<!-- Close DB connection -->
<?php include("../includes/php/disconnect_from_db.php"); ?>