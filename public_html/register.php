<?php
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
		<link rel="stylesheet" type="text/css" href="../includes/css/register.css" />
	</head>
	<body>

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
		if($valid_newEmail != '') {
			

			// Check to see if email address that user entered is already in the database

			// 1. Check database "email" column to see if there is a match to what the user entered
			$queryCheckAllEmails = "SELECT * FROM users WHERE email = '{$valid_newEmail}' LIMIT 1";
			$queryCheckAllEmailsResult = mysqli_query($dbConnection, $queryCheckAllEmails);
			
			// If the email address the user entered is already in the database 'email' column, then notify the user that the email address has already been registered; otherwise, validate the 2 passwords and add the new user to the database
			if($dbEmail = mysqli_fetch_assoc($queryCheckAllEmailsResult)) {
				echo "We have a match: '" . $dbEmail['email'] . "' is equal to '" . $valid_newEmail . "'<br>";
				echo "'" . $valid_newEmail . "' has already been registered.  No change has been made to the database.<br>";
				echo "<a href='/~Michael/Login_Test_Git/public_html/home.php'>Return to Homepage</a>";
			} else {

				// Sanitize the user input to strip any code/tags that may have been entered
				$safe_newPW = mysqli_real_escape_string($dbConnection, $newPW);
				$safe_newConfPW = mysqli_real_escape_string($dbConnection, $newConfPW);

				// Check to make sure two passwords the user has entered are not blank and match each other
				if($safe_newPW != '' && $safe_newConfPW != '' && $safe_newPW === $safe_newConfPW) {

					// Add the new email address to the database and output a message to the user that says that they have been registered
					
					// Perform database query
					$queryAddUserToDB  = "INSERT INTO users (email, password) 
						VALUES ('{$newEmail}', '{$newPW}')";
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
				else {
					// If the 2 passwords the user entered did not match, notify the user
					echo "Passwords did not match.<br>";
					echo "'" . $valid_newEmail . "' has not been registered.<br>";
					echo "<a href='/~Michael/Login_Test_Git/public_html/home.php'>Return to Homepage</a>";
				}

			}
		} else {
			// If the email address that the user entered was not valid, notify the user
			echo "Must enter a valid email address.<br>";
			echo "'" . $safe_newEmail . "' has not been registered.<br>";
			echo "<a href='/~Michael/Login_Test_Git/public_html/home.php'>Return to Homepage</a>";
		}

		?>

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
	

	
<?php
	// 3. Use returned MySQL data (if any)
		// No data currently being returned; only inserting values into database.

	// 4. Release returned data from memory
		// Since we are not returning any information from the database, there is nothing to release from memory in this case

	// 5. Close database connection
	mysqli_close($dbConnection);

?>