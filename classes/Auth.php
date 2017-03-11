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
        // $this->messages[] = "Auth class is saying that your database server is working. You can remove me inside..";
        $this->messages[] = "[AUTH] Welcome to MyPHP";
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
        // escape the POST stuff
        $user_name = strip_tags($_POST['user_name']);
        $user_password = strip_tags($_POST['user_password']);
        // database query, getting all the info of the selected user
        // $sql = "SELECT * FROM users
        //         WHERE user_name = '" . $user_name . "';";
        // $result_of_login_check = $this->db_connection->query($sql);
        $result_of_login_check = $this->db_connection->count("users", [
          // TODO: using OR condition for username/email
          "user_name" => $user_name
        ]);
        // if this user exists
        if ($result_of_login_check == 1) {
            // get result row (as an object)
            // NOTE: we are really gonna use arrays. In PHP 5.4+, array is like this [], others are old array()
            $result_row = $this->db_connection->get("users", [
              //COLUMNS
              'user_id', 'user_name', 'user_email', 'user_password',
              'first_name', 'last_name', 'user_account_type'
            ], [
              // CONDITIONS
            	'user_name' => $user_name
            ]);
            // using PHP 5.5's password_verify() function to check if the provided password fits
            // the hash of that user's password
            if (password_verify($user_password, $result_row['user_password'])) {
                // write user data into PHP SESSION (a file on your server)
                // $_SESSION['user_name'] = $result_row->user_name; // example
                Session::set_user('user_id', $result_row['user_id']);
                Session::set_user('user_name', $result_row['user_name']);
                Session::set_user('user_email', $result_row['user_email']);
                Session::set_user('first_name', $result_row['first_name']);
                Session::set_user('last_name', $result_row['last_name']);
                Session::set_user('user_logged_in', true);
                Session::set_user('user_logged_in_as', $result_row['user_account_type']);
            } else {
                $this->errors[] = "Wrong password. Try again.";
            }
        } else {
            $this->errors[] = "This user does not exist.";
        }
      }
    }
    /**
     * perform the logout
     */
    public function doLogout()
    {
        Session::destroy(); // or session_destroy();
        $this->messages[] = "You have been logged out.";
    }
    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (Session::user('user_logged_in') && !isset($_GET["logout"])) { // you can use session lib
            return $_SESSION['users']['user_logged_in']; // native use of sessions
        } else {
            return false;
        }
    }
}
