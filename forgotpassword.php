<?php

// checking requirements first using this class
require_once("classes/App.php"); $app = new App();

// load the auth class
require_once("classes/Auth.php"); $auth = new Auth();

// user management class
require_once("classes/User.php"); $user = new User();

// Immediate Password Reset Action
if (isset($_GET['resetpasswordwithcode'])) {
    if (isset($_POST['reset_password_with_code'])) {
        $email = $_POST['email'];
        $code = $_POST['reset_code'];
        if ($auth->verifyResetCode($email, $code)) {
            // for now, email is required
            $data = array(
                'email_address' => $email,
                'reset_code' => $code
            );
            $app->render("forgot_password_success", $data); exit(); // this should be a success page
        }
    } else {
        // default page
        $app->render("forgot_password_code"); exit(); // this should be a success page
    }
// RESETTING PASSWORD
} else if (isset($_POST['reset_new_password'])) {

    $email = $_POST['email'];
    $code = $_POST['reset_code'];
    $data = array(
        'email_address' => $email,
        'reset_code' => $code
    );

    $result = $user->resetPassword($_POST);
    if ($result) {
      $app->render("login_form", $data); exit();
    } else {
      $app->render("forgot_password_success", $data); exit();
    }
}

/**
 * You can add $app->multi_user_status condition
 * if you want a single-user mode
 */
if (!$auth->isUserLoggedIn()) {
    // echo "<h2>".$auth->generateRandomCode(5)."</h2>"; // TRY THIS ONE (CODE GENERATOR). SAVES TO DATABASE
    $app->render("forgot_password");
} else {
    // error reporting
    $app->error("Must be logged out first.");
}
