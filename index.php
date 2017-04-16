<?php

/**
 * MyPHP Plus by jccultima123
 *
 * @link https://github.com/jccultima123/MyPHP
 * @license http://opensource.org/licenses/MIT MIT License
 */

// Core components first such as main classes then load dependencies
require_once("classes/App.php");
// then Instantiate the class to use it
$app = new App();
// load the login class then instantiate again
require_once("classes/Auth.php");
$auth = new Auth();

/**
 * Collect responses first
 * YOU CAN DO THIS AGAIN BEFORE $this->render
 */
$app->collectResponse(array($app, $auth)); // should be a array object (never include Core class)

/**
 * Now put your own logic to render the page
 * (this is a sample then you can do another on your own)
 *
 * The instantiated class variables are we going to use
 */

$data = array(); // for rendering with data/callback

var_dump(Session::get('users'));

// if user logged in (using Auth class)
if ($auth->isUserLoggedIn() &&
    (!Session::get('add_user_requested')) ) {
	$app->render("logged_in.php"); // use Core class to render
}

// not logged in or want to add existing user
else if (!$auth->isUserLoggedIn() || $auth->addUserRequest()) {
    $data['add_user_requested'] = Session::get('add_user_requested');
    $data['logged_users'] = Session::get('users');
    $app->render("not_logged_in.php", $data);
}
