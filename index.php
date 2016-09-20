<?php

/**
 * MyPHP Plus by jccultima123
 *
 * @link https://github.com/jccultima123/MyPHP
 * @license http://opensource.org/licenses/MIT MIT License
 */

// classes
require_once("classes/Core.php"); // core components first such as main classes then load dependencies
$core = new Core();

// load the login class
require_once("classes/Auth.php");

$auth = new Auth();

include(HEADER);

if ($auth->isUserLoggedIn()) { // if user logged in
	$core->render("views/logged_in.php");
} else { // not logged in
	$core->render("views/not_logged_in.php", 'file');
}

include(FOOTER);
