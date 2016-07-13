<?php

/**
 * system.php
 * System page for all when the user is logged in
 */

// classes
require_once("classes/Core.php"); // core components first such as main classes then load dependencies
$core = new Core(); // always initialize core!

// load needed classes (already inherited from Core so don't worry)
require_once("classes/Auth.php");
require_once("classes/System.php");

$auth = new Auth();
$view = new View();
$system = new System();
$logged_user = Session::get('user_logged_in_as');

if ($auth->isUserLoggedIn()) { // if user logged in
	include(HEADER);
	// ternary (another condition clause) note: () = if, ? then, : = else
	// include("views/".($logged_user == 'admin'?"admin/index.php":"user/index.php"));
	include("views/system.php");
	include(FOOTER);
} else {
	header("location: index.php"); exit();
}