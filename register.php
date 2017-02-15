<?php

/*
 * register.php
 */

// checking requirements first using this class
require_once("classes/Core.php");
$core = new Core();

// load the registration class
require_once("classes/Registration.php");

// create the registration object. when this object is created, it will do all registration stuff automatically
// so this single line handles the entire registration process.
$registration = new Registration();

// set data
$data['user_types'] = $registration->getUserTypes();

// show the register view (with the registration form, and messages/errors)
$core->render("user/register.php", $data);
