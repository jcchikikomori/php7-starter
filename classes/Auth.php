<?php

/**
 * Class auth
 * handles the user's login and logout process
 */
class Auth extends Core
{
    /**
     * @var object The database connection
     */
    public $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();
    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        $this->db_connection = Core::connect_database(); // if this class needed a database connection, use this line
        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->doLogin();
            if (Session::get('user_logged_in')) {
                // logged in!
            }
        }
    }
    /**
     * log in with post data
     */
    private function doLogin()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {
            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);
                $user_password = $this->db_connection->real_escape_string($_POST['user_password']);
                // database query, getting all the info of the selected user
                $sql = "SELECT * FROM users
                        WHERE user_name = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);
                // if this user exists
                if ($result_of_login_check->num_rows == 1) {
                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();
                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($user_password, $result_row->user_password)) {
                        // write user data into PHP SESSION (a file on your server)
                        // $_SESSION['user_name'] = $result_row->user_name; // example
                        Session::set_user('user_id', $result_row->user_id);
                        Session::set_user('user_name', $result_row->user_name);
                        Session::set_user('user_email', $result_row->user_email);
                        Session::set_user('first_name', $result_row->first_name);
                        Session::set_user('last_name', $result_row->last_name);
                        Session::set_user('user_logged_in', true);
                        Session::set_user('user_logged_in_as', $result_row->user_account_type);
                        // Session::set_user('type_description', $result_row->user_type_description);
                        Session::set_user('type_description', $result_row->user_account_type);
                        // Session::set_user('user_provider', $result_row->user_provider_type);
                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }
    /**
     * perform the logout
     */
    public function doLogout()
    {
        Session::destroy_user(); // or session_destroy();
        $this->messages[] = "You have been logged out.";
    }
    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (Session::user('user_logged_in')) { // you can use session lib
            return $_SESSION['users']['user_logged_in']; // native use of sessions
        } else {
            return false;
        }
    }
}
