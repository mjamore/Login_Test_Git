<?php
	// Enable sessions
	session_start();




	// Get database login credentials from external file
	include("../login_test_credentials.php");

	// 1. Connect to database
	$dbConnection = mysqli_connect($host, $user, $password, $dbName);

	// Test if connection occurred
	if(mysqli_connect_errno()) {
		die("Database connection failed: " .
			mysqli_connect_error() .
			" (" . mysqli_connect_errno() . ")"
		);
	}// Close database connection test



	// Store register form values in variables; strip any leading or trailing whitespaces
	$newEmail = trim($_POST['newEmail']);
	$newPW = trim($_POST['newPW']);
	$newConfPW = trim($_POST['newConfPW']);

	//vStore login form values in variables; strip any leading or trailing whitespaces
	$returningEmail = trim($_POST['returningEmail']);
	$returningPW = trim($_POST['returningPW']);

	// Sanitize email addresses that user input
	$safe_newEmail = mysqli_real_escape_string($dbConnection, $newEmail);
	$safe_returningEmail = mysqli_real_escape_string($dbConnection, $returningEmail);





	if(isset($_POST['newSubmitBtn']))
	{
		if ( empty($_POST['newEmail']) || empty($_POST['newPW']) || empty($_POST['newConfPW']) )
		{
			$errorRegister = true;
		}
	}

	if(isset($_POST['logoutSubmitBtn']))
	{
		// Set $_SESSION['authenticated'] to 'false' since the user is not logged in
		$_SESSION['authenticated'] = false;

		// Clear out username cookie; 
		setcookie("returningEmail", "", time() - 3600);
	}


	// FOR: LOGIN FORM; If username and password were submitted, compare their values to our hardcoded values:
	if(!empty($_POST['returningEmail']) && !empty($_POST['returningPW']))
	{

		// Make sure email address that was entered is in a valid format
		if(filter_var($safe_returningEmail, FILTER_VALIDATE_EMAIL))
		{
			$valid_returningEmail = $safe_returningEmail;
			echo "Email address was valid. <br />";
		}
		else
		{
			$valid_returningEmail = '';
			$errorLogin = true;
		}

		// Only run this code if the email address is valid
		if($valid_returningEmail != '') {

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
					setcookie("returningEmail", $_POST['returningEmail'], time() + 7 * 24 * 60 * 60);
				}
				else
				{
					// Set $_SESSION['authenticated'] to 'false' since the user is not logged in
					$_SESSION['authenticated'] = false;

					// Clear out username cookie; 
					setcookie("returningEmail", "", time() - 3600);

					// Display the login form error message
					$errorLogin = true;

					// passwords did not match
					$errorLogin = true;
					echo "Password did not match database entry.<br>";
				}
			}
			else
			{
				// Username was not found in database
				$errorLogin = true;
				echo "Username not found in database.<br>";
			}
		}
	}
	
?>



<html>
<head>
	<title>Database Test</title>
	<link rel="stylesheet" type="text/css" href="../includes/css/login.css" />
</head>

<body>
	<?php if($_SESSION['authenticated'] == 'true' ) { ?>
		<h3>Hello, <?php if(isset($_COOKIE['returningEmail'])) echo htmlspecialchars($_COOKIE['returningEmail']); ?>!  You are logged in.</h3>
		
		<!-- When user clicks logout button, set $_SESSION['authenticated'] to 'false' and reload the page -->
		<form name="logoutForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
			<input name="logoutSubmitBtn" type="submit" value="Logout" />
		</form>
	<?php } else { ?>
		<h3>You are not logged in.</h3>
	<?php }  ?>


	

	<div id="loginBox">
		
		<div id="newUsers">
			<form name="newUserRegistrationForm" id="newUserRegistrationForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
				<h3>Register</h3>
				<label>Email Address:
					<input name="newEmail" placeholder="ex. abc@123.com" value="<?php if(isset($_POST['newEmail'])) { echo $_POST['newEmail']; } ?>" />
				</label>
			
				<br>
				<label>Password:
					<input name="newPW" type="password"  />
				</label>
		
				<br>
				<label>Confirm Password:
					<input name="newConfPW" type="password" />
				</label>

				<?php if($errorRegister): ?>
						<div style="color:red;">You must fill out the form!</div>
				<?php endif ?>

				<br>
				<button name="newSubmitBtn" type="submit" value="submit">Register</button>
			</form>
		</div><!--close #newUsers-->

		<div id="returningUsers">
			<form name="returningUserLoginForm" id="returningUserLoginForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
				<h3>Login</h3>
				<label>Email Address:
					<input name="returningEmail" placeholder="ex. abc@123.com" value="<?php if(isset($_POST['returningEmail'])) { echo $_POST['returningEmail']; } ?>" />
				</label>

				<br>
				<label>Password:
					<input name="returningPW" type="password" />
				</label>

				<?php if($errorLogin): ?>
						<div style="color:red;">Email/Password were incorrect!</div>
				<?php endif ?>

				<br>
				<button name="returningLogin" type="submit" value="submit">Login</button>
			</form>
		</div><!--close #returningUsers-->
		
	</div><!--close #loginBox-->


	<div id="currentDB">

		<br>
		<br>
		<h3>Current usernames and passwords in the database</h3>
		<table>
			<thead>
				<tr>
					<td>id</td>
					<td>username</td>
					<td>password</td>
				</tr>
			</thead>
			<tbody>
				<?php

					// Get the entire contents of the 'users' table from the DB
					$queryGetAllDBInfo = "SELECT * FROM users";	
					$queryGetAllDBInfoResult = mysqli_query($dbConnection, $queryGetAllDBInfo);

					// Iterate through the results and print each database row in a new table row
					while($dbRow = mysqli_fetch_assoc($queryGetAllDBInfoResult)) {
						echo "<tr>";
						echo "<td>" . $dbRow["id"] . "</td>";
						echo "<td>" . $dbRow["email"] . "</td>";
						echo "<td>" . $dbRow["password"] . "</td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>

	</div><!--close #currentDB-->

</body>
</html>