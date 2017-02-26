<?php
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', 'db0305');
	define('DB_NAME', 'mp');
	define('DB_CONN', 'mysql');

	session_start();

	if(!isset($_SESSION['Username']))
		$_SESSION['LoggedIn'] = 0;

	require ('../PDOManager.php');
	include 'libs/class.messenger.php'; 

	$mp = new Messenger();

	if(!preg_match('/index/', $_SERVER['SCRIPT_NAME'])) {
		if($_SESSION['LoggedIn'] != 1){
		  header('location: index.php');
		}
	}