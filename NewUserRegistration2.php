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



	// Store form values from login_test.php in variables
	$newEmail = $_POST['newEmail'];
	$newPW = $_POST['newPW'];
	$newConfPW = $_POST['newConfPW'];

	// Sanitize email address that user input
	$safe_newEmail = mysqli_real_escape_string($dbConnection, $newEmail);	
	

?>

<html>
	<head>
		<title>Login Test Results Page</title>
		<link rel="stylesheet" type="text/css" href="includes/css/register_results.css" />
	</head>
	<body>

		<?php

		// Make sure email address that was entered is in a valid format
		if(filter_var($safe_newEmail, FILTER_VALIDATE_EMAIL))
		{
			$valid_newEmail = $safe_newEmail;
			echo "Email address was valid. <br />";
		} else {
			$valid_newEmail = '';
			echo "Email address was invalid. <br />";
		}

		
		// Only run this code if the email address is valid
		if($valid_newEmail != '') {
			echo "<br />" . $valid_newEmail . "<br />";
			// Check to see if email address that user entered is already in the database

			// 1. Check database "email" column to see if there is a match to what the user entered
			$queryCheckAllEmails = "SELECT * FROM users WHERE email = '{$valid_newEmail}' LIMIT 1";

			$queryCheckAllEmailsResult = mysqli_query($dbConnection, $queryCheckAllEmails);
			//confirm_query($queryCheckAllEmailsResult);
			if($dbEmail = mysqli_fetch_assoc($queryCheckAllEmailsResult)) {
				echo "We have a match: " . $dbEmail['email'] . " is equal to " . $valid_newEmail . "<br />";
				echo "This username has already been registered.";
				return $dbEmail;
			} else {

				$safe_newPW = mysqli_real_escape_string($dbConnection, $newPW);
				$safe_newConfPW = mysqli_real_escape_string($dbConnection, $newConfPW);

				// Check to make sure two passwords the user has enter match each other
				if($safe_newPW != '' && $safe_newConfPW != '' && $safe_newPW === $safe_newConfPW) {

					// If there is not a match, add the entry to the database and output a message to the user that says that they have been registered
					
					// Perform database query
					$queryAddUserToDB  = "INSERT INTO users (email, password) 
						VALUES ('{$newEmail}', '{$newPW}')";

					$queryAddUserToDBResult = mysqli_query($dbConnection, $queryAddUserToDB);

					// Test if there was a query syntax error
					if ($queryAddUserToDBResult) {
						// Success
						echo "New user has been added to database.";
						// probably would do: redirect_to("somepage.php");
					}
					else {
						// Failure
						die("Query syntax was not valid.  MySQL error: " . mysqli_error($dbConnection));
					}
				}
				else {
					echo "Passwords did not match.";
				}

			}
		} else {
			echo "Must enter an email address.";
		}

		?>

		<div id="currentDB">

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
						$queryGetAllDBInfo = "SELECT * FROM users";	
						$queryGetAllDBInfoResult = mysqli_query($dbConnection, $queryGetAllDBInfo);

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