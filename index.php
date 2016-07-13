<?php

/**
 * MyPHP Lite by jccultima123
 *
 * @license http://opensource.org/licenses/MIT MIT License
 */

// classes
require_once("classes/Core.php"); // core components first such as main classes then load dependencies
$core = new Core();

// load the login class
require_once("classes/Auth.php");

$auth = new Auth();
$view = new View();

include(HEADER);

// if ($auth->isUserLoggedIn()) { // if user logged in
// 	include("views/user/system.php");
// } else {
	include("views/index.php");
// }

include(FOOTER);