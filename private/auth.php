<?php
	include_once('../private/initialise.php');
	
	function user_session($login) {
		session_regenerate_id();

		$_SESSION['username'] = $login['username'];

		$id = get_user_id($_SESSION['username']); 

		$_SESSION['id'] = $id['0'];

		// $_SESSION['id'] = get_user_id($login['username']);
		
		$user = get_user_by_id($_SESSION['id']);

		$_SESSION['contactID'] = $user['contactID'];
		$_SESSION['description'] = $user['description'];
		$_SESSION['firstName'] = $user['firstName'];
		$_SESSION['lastName'] = $user['lastName'];
		$_SESSION['emailAddress'] = $user['emailAddress'];
		$_SESSION['cityName'] = $user['cityName'];
		$_SESSION['countryName'] = $user['countryName'];
		$_SESSION['buyerID'] = $user['buyerID'];
		$_SESSION['sellerID'] = $user['sellerID'];
		$_SESSION['last_login'] = date_create();

		return true;
	}

	function user_logout() {
		unset($_SESSION['username']);
		unset($_SESSION['id']);
		unset($_SESSION['contactID']);
		unset($_SESSION['description']);		
		unset($_SESSION['firstName']);
		unset($_SESSION['lastName']);
		unset($_SESSION['emailAddress']);
		unset($_SESSION['cityName']);
		unset($_SESSION['countryName']);
		unset ($_SESSION['buyerID']);
		unset($_SESSION['last_login']);

		session_destroy();
		return true;
	}

	function is_logged_in() {
		return isset($_SESSION['username']);
	}


	function require_login() {
		if(!is_logged_in()) {
		    $location = 'login.php';
        	header("Location: " . $location);
        	exit();
	} else {
	}




}


?>