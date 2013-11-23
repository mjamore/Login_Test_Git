/////////////////////////////////////////////////////////////////////////
// Known bugs:
// 1. The callback function works properly when the register option button
//    is clicked (the #formRotator animates smoothly and the appropriate form
//	  field gains focus), however the callback function for the login option
//    button does not animate smoothly as long as the 'give focus to returningEmail'
//    statement is running.  As a workaround, a setTimeout() function is being used
//    so the animation will run smoothly
/////////////////////////////////////////////////////////////////////////

$(document).ready(function() {

	var animationSpeed = 200;

	// When the logout button is clicked, redirect the user to logout.php
	$('button#logoutBtn').click(function() {
		window.location = "http://localhost/~Michael/Login_Test_Git/public_html/logout.php";
	});

	// When the register button is clicked, hide the button options, and show the register form
	$('div#registerOption').click(function() {
		$('input[name="newEmail"]').focus();
		$('#formRotator').animate({
			marginLeft: "0px"
		}, animationSpeed);
		$('#returningUserLoginForm').hide();
		$('#newUserRegistrationForm').show();
	});

	// When viewing the register form, click the icon to go back to the button options
	$('div#registerBackToButtonOptions').click(function() {
		$('#formRotator').animate({
			marginLeft: "-300px"
		}, animationSpeed);
	});

	// When the login button is clicked, hide the button options, and show the login form
	$('div#loginOption').click(function() {
		$('#formRotator').animate({
			marginLeft: "-600px"
		}, animationSpeed);
		setTimeout(function() {
			$('input[name="returningEmail"]').focus();
		}, animationSpeed);
		$('#newUserRegistrationForm').hide();
		$('#returningUserLoginForm').show();
	});

	// When viewing the login form, click the icon to go back to the button options
	$('div#loginBackToButtonOptions').click(function() {
		$('#formRotator').animate({
			marginLeft: "-300px"
		}, animationSpeed);
	});

	$('div#registerBtn').click(function() {
		$('#newUserRegistrationForm').submit();
	});

	$(document).keypress(function(e)
	{
		if(e && e.keyCode == 13)
			{
				$('form:visible').submit();	
			}
	});

	// $('div#loginBtn').click(function() {
	// 	$('form:visible').submit();
	// });


});