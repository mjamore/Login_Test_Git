<?php
	session_start();

	require_once("../includes/php/helper_functions.php");

	$_SESSION['authenticated'] = false;
	$_SESSION['returningEmail'] = null;
	redirect("home.php");
	exit();
?>