<?php

/**
 * MyPHP Plus by jccultima123
 *
 * @link https://github.com/jccultima123/MyPHP
 * @license http://opensource.org/licenses/MIT MIT License
 */

// Core components first such as main classes then load dependencies
require_once("classes/Core.php");
// then Innstatiate the class to use it
$core = new Core();
// load the login class then instantiate again
require_once("classes/Auth.php");
$auth = new Auth();

/**
 * Collect feedbacks first
 * YOU CAN DO THIS AGAIN BEFORE $this->render
 * TODO: Collecting responses using view
 */
$core->collectResponse(array($core, $auth)); // should be a array object (never include Core class)

/**
 * Now put your own logic to render the page
 * (this is a sample then you can do another on your own)
 */

/**
 * The instantiated class variables are we going to use
 */
// NORMAL VIEW
if ($auth->isUserLoggedIn()) { // if user logged in (using Auth class)
	$core->render("logged_in.php"); // use Core class to render
} else { // not logged in
    // $core->layouts = false; // disable rendering with layouts
	$core->render("not_logged_in.php"); // do the fallback function
}
