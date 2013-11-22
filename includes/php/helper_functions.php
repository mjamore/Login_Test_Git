<?php

function redirect($file)
	{
		$host = $_SERVER['HTTP_HOST'];
		$path = rtrim(dirname($_SERVER['PHP_SELF']), "/\\");
		header("Location: http://$host$path/$file");
	}

function logout()
	{
		
	}
?>