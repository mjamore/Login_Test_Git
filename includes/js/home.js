$(document).ready(function() {
	$('button#logoutBtn').click(function() {
		window.location = "http://localhost/~Michael/Login_Test_Git/public_html/logout.php";
	});

	$('div#registerOption').click(function() {
		$('div#buttonOptions').hide();
		$('div#newUsers').show();
		$('input[name="newEmail"]').focus();
	});

	$('div#loginOption').click(function() {
		$('div#buttonOptions').hide();
		$('div#returningUsers').show();
		$('input[name="returningEmail"]').focus();
	});
});