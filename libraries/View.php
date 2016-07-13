<?php

class View
{

    public static function getFeedback($object) {
        // show potential errors / feedback (from login object)
        if (isset($object)) {
            if ($object->errors) {
                echo '<div class="alert bg-warning alert-dismissible" role="alert"><button class="close" aria-label="close" data-dismiss="alert" type="button"><span aria-hidden="true">x</span></button>';
                    echo '<ul class="list-unstyled"><strong>OOPS!</strong><br /><br />';
                        foreach ($object->errors as $error) {echo '<li>' . $error . '</li>';}
                    echo '</ul>';
                echo '</div>';
            }
            if ($object->messages) {
                echo '<div class="alert bg-success alert-dismissible" role="alert"><button class="close" aria-label="close" data-dismiss="alert" type="button"><span aria-hidden="true">x</span></button>';
                    echo '<ul class="list-unstyled"><strong>MESSAGE</strong><br /><br />';
                        foreach ($object->messages as $message) {echo '<li>' . $message . '</li>';}
                    echo '</ul>';
                echo '</div>';
            }
        } // else {echo 'feedback error';}
    }
    
    public static function loginDetectUser() {
        // using Session library. See in libraries/Session.php
        if (Session::get('user_logged_in_as') == 'admin' && Session::get('user_logged_in_as') != NULL) {
            require VIEWS_PATH . 'login/admin.php';
        } else if (Session::get('user_logged_in_as') != 'user' && Session::get('user_logged_in_as') != NULL) {
            require VIEWS_PATH . 'login/user.php';
        } else {
            require VIEWS_PATH . 'login/default.php';
        }
    }
    
}
