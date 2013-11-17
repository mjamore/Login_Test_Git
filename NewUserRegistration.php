<?php

// form submitted
if (($_SERVER['REQUEST_METHOD'] == 'POST' ) && (!empty($_POST['action']))):

	if (isset($_POST['newEmail'])) { $newEmail = $_POST['newEmail']; } else { $newEmail = ''; }
	if (isset($_POST['newPW'])) { $newPW = $_POST['newPW']; } else { $newPW = ''; }
	if (isset($_POST['newConfPW'])) { $newConfPW = $_POST['newConfPW']; } else { $newConfPW = ''; }

	$formerrors = false;

	// Throw error message if email field is blank
	if ( $newEmail === ''):
		$err_invalidEmail = '<div class="error">You must enter a valid address</div>';
		$formerrors = true;
	endif;

	// Make sure password is at least 8 characters
	if (strlen($newPW) < 8):
		$err_PWNot8Chars = '<div class="error">Your password must be at least 8 characters</div>';
		$formerrors = true;
	endif;

	// Check if the two passwords entered match each other
	if ($newPW !== $newConfPW):
		$err_PWsDoNotMatch = '<div class="error">Your passwords did not match</div>';
		$formerrors = true;
	endif;

	$formdata = array (
		'newEmail' => $newEmail,
		'newPW' => $newPW,
		'newConfPW' => $newConfPW
	);

	date_default_timezone_set('US/Eastern');
	$currtime = time();
	$datefordb = date('Y-m-d H:i:s', $currtime);
	$salty = dechex($currtime).$newPW;
	$salted = hash('sha1', $salty);

	//  Check for any form errors before sending email
	if (!($formerrors)):
		// $to = "michael.amore@yahoo.com";
		// $subject = "Bonerjerkers.com Contact Us Page - Message From $newEmail";
		// $message = "json_encode($formdata)";

		// $replyto = "From: $newEmail \r\n".
		// 			"Reply-To: michael.amore@yahoo.com \r\n";

		// // Mail form data
		// if (mail($to, $subject, $message)):
		// 	$msg = "Thanks for giving me your data.  I can't wait to sell it.";
		// else:
		// 	$msg = "Houston, we have a problem.";
		// endif;

		include("log_formdb.php");

		$forminfolink = mysqli_connect($host, $user, $password, $dbname);
		$forminfoquery = "INSERT INTO login_test (
			id,
			email,
			password
		)
		VALUES (
			'',
			'".$newEmail."',
			'".$salted."'
		)";

		// write to database
		if ($forminforesult = mysqli_query($forminfolink, $forminfoquery)):
			$msg = "Your form data has been processed. Thanks.";
		else:
			$msg = "Problem with database.";
		endif;

		mysqli_close($forminfolink);

	endif;

endif;

?>















