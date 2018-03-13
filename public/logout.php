<?php

include_once('../private/initialise.php');

	user_logout();
	$location = 'login.php';
	header("Location: " . $location);
	exit();

?>