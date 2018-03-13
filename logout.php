<?php

include_once('private/initialise.php');

	user_logout();
	$location = 'index.php';
	header("Location: " . $location);
	exit();

?>