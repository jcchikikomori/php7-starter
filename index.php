<?php

/**
 * PHP7Starter init file
 *
 * PHP version 7.2
 *
 * @category App
 * @package  PHP7Starter
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  GIT: 0.51-alpha
 * @link     https://github.com/jcchikikomori/php7-starter
 */

// load required files
require_once "classes/App.php";

// load the login class then instantiate again
require_once "classes/Auth.php";
$auth = new classes\Auth();

// collect response from Auth constructor
$auth->collectResponse(array($auth));
// if user logged in (using Auth class)
if ($auth->isUserLoggedIn()) {
    // put data here using App's render()
    $auth->render("logged_in");
}
// not logged in
elseif (!$auth->isUserLoggedIn()) {
    $auth->render("login_form");
}
