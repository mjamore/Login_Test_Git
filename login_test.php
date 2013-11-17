<?php include "NewUserRegistration.php"; ?>

<html>
<head>
	<title>Database Test</title>
	<link rel="stylesheet" type="text/css" href="includes/login.css" />
</head>

<body>
	<div id="loginBox">
		
		<div id="newUsers">
			<form name="newUserRegistrationForm" id="newUserRegistrationForm" action="NewUserRegistration2.php" method="POST">
				<h3>Register</h3>
				<label>Email Address: <input name="newEmail" placeholder="ex. abc@123.com"  /></label>
			
				<br>
				<label>Password: <input name="newPW" type="password"  /></label>
		
				<br>
				<label>Confirm Password: <input name="newConfPW" type="password" /></label>
				
				<br>
				<button name="newSubmitBtn" type="submit" value="submit">Register</button>
			</form>
		</div><!--close #newUsers-->

		<div id="returningUsers">
			<form name="returningUserLoginForm" id="returningUserLoginForm" action="ReturningUserLogin.php" method="POST">
				<h3>Login</h3>
				<label>Email Address: <input name="returningEmail" type="email" placeholder="ex. abc@123.com" /></label>
				<br>
				<label>Password: <input name="returningPW" type="password" /></label>
				<br>
				<input name="returningLogin" type="submit" value="Login" />
			</form>
		</div><!--close #returningUsers-->
		
	</div><!--close #loginBox-->


	<div id="currentDB">

		<h3>Current usernames and passwords in the database</h3>
		<table>
			<thead>
				<tr>
					<td>Usernames</td>
					<td>Passwords</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>UN1</td>
					<td>PW1</td>
				</tr>

				<tr>
					<td>UN2</td>
					<td>PW2</td>
				</tr>
				
				<tr>
					<td>UN3</td>
					<td>PW3</td>
				</tr>
				
				<tr>
					<td>UN4</td>
					<td>PW4</td>
				</tr>
				
				<tr>
					<td>UN5</td>
					<td>PW5</td>
				</tr>
			</tbody>
		</table>

	</div><!--close #currentDB-->

</body>
</html>