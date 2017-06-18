<?php

/**
 * Multi-user index
 */

// Core components first such as main classes then load dependencies
// then Instantiate the class to use it
require_once("classes/App.php"); $app = new App();

// load the login class then instantiate again
require_once("classes/Auth.php"); $auth = new Auth();

if (($auth->isUserLoggedIn() && $auth->multi_user_requested) ||
    // either multi-user login or switch user (requires multi-user too)
    (!$auth->isUserLoggedIn() && $auth->switch_user_requested)) {
    // then render
    $data['multi_user_requested'] = $auth->multi_user_requested;
    $data['switch_user_requested'] = $auth->switch_user_requested;
    $app->render("login_form", $data);
}
