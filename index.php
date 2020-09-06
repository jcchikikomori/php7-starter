<?php

/**
 * php7-starter by jccultima123
 *
 * @link https://github.com/jcchikikomori/php7-starter
 * @license http://opensource.org/licenses/MIT MIT License
 */

// Core components first such as main classes then load dependencies
// then Instantiate the class to use it
require_once("classes/App.php"); $app = new App();

// load the login class then instantiate again
require_once("classes/Auth.php"); $auth = new Auth();

// if user logged in (using Auth class)
if ($auth->isUserLoggedIn()) {
    // put data here using App's render()
    $app->render("logged_in");
    // NOTE: you can use $app->render("logged_in.php") without $data if you don't want to
}

// not logged in
else if (!$auth->isUserLoggedIn()) {
    $app->render("login_form");
}