<?php

/*
 * register.php
 */

// checking requirements first using this class
require_once("classes/App.php"); $app = new App();

// load the registration class
require_once("classes/Registration.php");

// create the registration object. when this object is created, it will do all registration stuff automatically
// so this single line handles the entire registration process.
$registration = new Registration();

// DEFAULT VIEW (WEB)
// collect feedbacks first
$app->collectResponse(array($registration)); // should be a array object (never include Core class)

// set data
$data['user_types'] = $registration->getUserTypes();

// show the register view (with the registration form, and messages/errors)
if (!$auth->isUserLoggedIn() || $auth->addUserRequest()) {
    $app->render("user/register.php", $data);
}