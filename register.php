<?php

// checking requirements first using this class
require_once("classes/App.php"); $app = new App();

// load the auth class
require_once("classes/Auth.php"); $auth = new Auth();

// load the registration class for user's registration stuffs
require_once("classes/Registration.php"); $registration = new Registration();

/**
 * Now put your data here and include in render()
 */
$data = array(
    'user_types' => $registration->getUserTypes()
);

/**
 * You can add $app->multi_user_status condition
 * if you want a single-user mode
 */
if (!$auth->isUserLoggedIn()) {
    $app->render("register", $data);
} else {
    // error reporting
    $app->error("Must be logged out first.");
}
