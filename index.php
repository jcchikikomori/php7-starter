<?php

/**
 * MyPHP Plus by jccultima123
 *
 * @link https://github.com/jccultima123/MyPHP
 * @license http://opensource.org/licenses/MIT MIT License
 */

// Core components first such as main classes then load dependencies
// then Instantiate the class to use it
require_once("classes/App.php"); $app = new App();

// load the login class then instantiate again
require_once("classes/Auth.php"); $auth = new Auth();

/**
 * Now put your own logic to render the page
 * (this is a sample then you can do another on your own)
 *
 * The instantiated class variables are we going to use
 */

$data = array(); // for rendering with data/callback

$data['multi_user'] = $app->multi_user_status;
$data['logged_users'] = Session::get('users');

/**
 * One of the ways to debug your PHP application
 */
// var_dump(Session::get('users'));
var_dump(Session::get('response'));

// if user logged in (using Auth class)
if ($auth->isUserLoggedIn() && $app->multi_user_status) {
    $app->render("logged_in.php", $data); // use Core class to render
}

// not logged in or want to add existing user
else if (!$auth->isUserLoggedIn()) {
    $app->render("not_logged_in.php", $data);
}
