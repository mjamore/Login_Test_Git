<?php
	// Enable sessions
	session_start();

	$loggedIn = false;

	if($_SESSION['authenticated'] == "true")
	{
		$loggedIn = true;
	}

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

?>

<html>
	<head>
		<title>Database Test Homepage</title>
		<link rel="stylesheet" type="text/css" href="../includes/css/home.css" />
		<script src="../includes/js/lib/jquery-1.9.1.js"></script>
		<script src="../includes/js/home.js"></script>
	</head>

	<body>

		<?php if($loggedIn == true ) { ?>
			<!-- This div should only be shown if the user has logged in successfully. -->
			<div id="loggedInStatus">
				<p>Logged in as <?php echo "'" . $_SESSION['returningEmail'] . "'" ?></p>
				<button id="logoutBtn">Logout</button>
				<div class="clearFloat"></div>
			</div>
		<?php }  ?>

		<div id="pageExplaination">
			<p>These pages were designed as an experimental test with the purpose of building a functioning PHP and MySQL login/registration system.  You can register a new email address/password, or you can use any of the login/password combinations that are already stored in the database to login.  Please send any feedback to xxxxx.@xxx.com.</p>
		</div>


		<!-- Only show the the options boxes and forms if the user is not logged in -->
		<?php if( $loggedIn == false ) { ?>

			<div id="buttonOptions">
				<div id="registerOption" class="homepageButtons"><p>Register</p></div>
				<div id="loginOption" class="homepageButtons"><p>Login</p></div>
			</div>
		
			<!-- This div should not be shown if the user is currently logged in -->
			<div id="loginBox">
				
				<div id="newUsers">
					<form name="newUserRegistrationForm" id="newUserRegistrationForm" action="register.php" method="POST">
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

						<br>
						<button name="newSubmitBtn" type="submit" value="submit">Register</button>
					</form>
				</div><!--close #newUsers-->

				<br>

				<div id="returningUsers">
					<form name="returningUserLoginForm" id="returningUserLoginForm" action="login.php" method="POST">
						<h3>Login</h3>
						<label>Email Address:
							<input name="returningEmail" placeholder="ex. abc@123.com" value="<?php if(isset($_POST['returningEmail'])) { echo $_POST['returningEmail']; } ?>" />
						</label>

						<br>
						<label>Password:
							<input name="returningPW" type="password" />
						</label>

						<br>
						<button name="returningLogin" type="submit" value="submit">Login</button>
					</form>
				</div><!--close #returningUsers-->
				
			</div><!--close #loginBox-->
		<?php }  ?>

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