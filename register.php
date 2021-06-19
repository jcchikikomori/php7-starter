<?php

/**
 * Registration init file
 *
 * PHP version 7.2
 *
 * @category Registration
 * @package  PHP7Starter
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  GIT: 0.51-alpha
 * @link     https://github.com/jcchikikomori/php7-starter
 */

require_once "classes/App.php";
require_once "classes/Auth.php";
require_once "classes/Registration.php";

$registration = new classes\Registration(); // TODO: Get from constructed App class

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
if (!$registration->isUserLoggedIn()) {
    $registration->render("register", $data);
} else {
    // error reporting
    $registration->error("Must be logged out first.");
}
