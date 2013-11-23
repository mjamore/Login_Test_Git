<?php
	// Enable sessions
	session_start();

	$loggedIn = false;

	if($_SESSION['authenticated'] == "true")
	{
		$loggedIn = true;
	}

	// Connect to DB via connect_to_db.php file
	include("../includes/php/connect_to_db.php");

?>

<html>
	<head>
		<title>Database Test Homepage</title>
		<link rel="stylesheet" type="text/css" href="../includes/css/site_wide.css" />
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

		<?php include("../includes/php/page_title.php"); ?>

		<div id="pageExplaination">
			<p><span>Site Purpose: </span>This site was designed as an experimental test with the purpose of building a functioning PHP and MySQL login/registration system.  You can register a new email address/password, or you can use any of the login/password combinations that are already stored in the database to login.  Please send any feedback to xxxxx.@xxx.com.</p>
		</div>


		<!-- Only show the the options boxes and forms if the user is not logged in -->
		<?php if( $loggedIn == false ) { ?>

			<div class="centeringDIV">
				<div id="formConatiner">
					<div id="formRotator">

						<div id="registerSection">
							<div id="registerBackToButtonOptions"><p>&gt;</p></div>
							<div class="clearFloat"></div>
							<div id="newUsers">
								<form name="newUserRegistrationForm" id="newUserRegistrationForm" action="register.php" method="POST">
									<h1>Register</h1>
									<label>Email Address:
										<input name="newEmail" value="<?php if(isset($_POST['newEmail'])) { echo $_POST['newEmail']; } ?>" />
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
<!-- 									<button name="newSubmitBtn" type="submit" value="submit">Register</button>
 -->								<div id="registerBtn" type="submit" class="homepageButtons"><p>Register</p></div>
									</form>
							</div><!--close #newUsers-->
						</div><!-- close #registerSection -->

						<div id="buttonOptionsSection">
							<div id="buttonOptions">
								<div id="registerOption" class="homepageButtons"><p>Register</p></div>
								<div id="loginOption" class="homepageButtons"><p>Login</p></div>
							</div><!-- close #buttonOptions -->
						</div><!-- close #buttonOptionsSection -->

						<div id="loginSection">
							<div id="loginBackToButtonOptions"><p>&lt;</p></div>
							<div class="clearFloat"></div>
							<div id="returningUsers">
								<form name="returningUserLoginForm" id="returningUserLoginForm" action="login.php" method="POST">
									<h1>Login</h1>
									<label>Email Address:
									<br>
										<input name="returningEmail" value="<?php if(isset($_POST['returningEmail'])) { echo $_POST['returningEmail']; } ?>" />
									</label>

									<br>
									<label>Password:
										<input name="returningPW" type="password" />
									</label>

									<br>
									<div id="loginBtn" class="homepageButtons"><p>Login</p></div>	
								</form>
							</div><!--close #returningUsers-->
						</div><!-- close #loginSection -->

					</div><!-- close #formRotator -->
				</div><!-- close #formContainer -->
			</div><!-- close .centeringDIV -->
			<div class="clearFloat"></div>

		<?php }  ?>

		<?php include("../includes/php/display_db.php"); ?>

	</body>
</html>

<!-- Close DB connection -->
<?php include("../includes/php/disconnect_from_db.php"); ?>