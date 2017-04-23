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
 * If you are in multi-user mode, just simply add new view file with _multi_user naming
 */

// if user logged in (using Auth class)
if ($auth->isUserLoggedIn()) {
    // put data here using App's render()
    $app->render("logged_in");
    // NOTE: you can use $app->render("logged_in.php") without $data if you don't want to
}

// not logged in
else if (!$auth->isUserLoggedIn()) {
    $app->render("not_logged_in");
}
