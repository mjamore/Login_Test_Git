<?php
	// Enable sessions
	session_start();

	$error = false;

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

	// This will be replaced by DB, once it is integrated
	define('USER', 'jharvard');
	define('PASS', 'crimson');

	// If username and password were submitted, compare their values to our hardcoded values:
	//if( $_POST['returningEmail'] != '' && $_POST['returningPW'] != '' )
	if(isset($_POST['returningLogin']))
	{
		// If email and PW the user entered were equal to our hardcoded values
		if( $_POST['returningEmail'] == USER && $_POST['returningPW'] == PASS )
		{
			// Remember the user is logged in
			$_SESSION['authenticated'] = true;

			// Save username in cookie for a week
			setcookie("returningEmail", $_POST['returningEmail'], time() + 7 * 24 * 60 * 60);

		}
		// If email and PW the user entered were not equal to our hardcoded values:
		else
		{
			// Set $_SESSION['authenticated'] to 'false' since the user is not logged in
			$_SESSION['authenticated'] = false;

			// Clear out username cookie; 
			setcookie("returningEmail", "", time() - 3600);

			// Display the login form error message
			$errorLogin = true;
//////////////////////////////////////////////////////
// Current issue is that when form is first submitted with 
// the correct credentials, the label does not display the username;
// it does display, however, when you reload the page
//////////////////////////////////////////////////////

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

</body>
</html>