<?php

	ob_start(); //output buffering turned on

	session_start();

  	require_once('database.php');
  	require_once('database_functions.php');
  	require_once('functions.php');
  	require_once('validation_functions.php');
  	require_once('auth.php');

  	$db = db_connect();
  	$errors = [];

?>