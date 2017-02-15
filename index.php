<?php

/**
 * MyPHP Plus by jccultima123
 *
 * @link https://github.com/jccultima123/MyPHP
 * @license http://opensource.org/licenses/MIT MIT License
 */

// core components first such as main classes then load dependencies
require_once("classes/Core.php");
// then Innstatiate the class to use it
$core = new Core();
// load the login class then instantiate again
require_once("classes/Auth.php");
$auth = new Auth();

// Now include the HEADER constant (based on your config.php)
include(HEADER);

// Now put your own logic to render the page
// (this is a sample then you can do another on your own)

// Now, the instantiated class variables are going to be used
if ($auth->isUserLoggedIn()) { // if user logged in (using Auth class)
	$core->render("logged_in.php"); // use Core class to render
} else { // not logged in
	$core->render("not_logged_in.php", 'file'); // do the fallback function
}

// Don't forget the FOOTER
include(FOOTER);
