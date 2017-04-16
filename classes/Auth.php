<?php

/**
 * Class auth
 * handles the user's login and logout process
 */
class Auth extends App
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
     * For JSON
     * @var string $status
     */
    public $status;
    /**
     * For multi-user setup
     * @var bool
     */
    public $add_user_requested = false;
    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        parent::__construct(); // Load App constructor

        $this->db_connection = App::connect_database(); // if this class needed a database connection, use this line

        // $this->messages[] = "Auth class is saying that your database server is working. You can remove me inside.."; // TRY THIS OUT
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

        // multi-user setup!
        elseif (isset($_GET["add_existing_user"])) {
            Session::set('add_user_requested', true);
            $this->add_user_requested = true;
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
        $user_name = strip_tags($_POST['user_name']); // escape the POST stuff (ANTI INJECTION)
        $user_password = strip_tags($_POST['user_password']);
        /**
         * OLD database query, getting all the info of the selected user
         * $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "';";
         * $result_of_login_check = $this->db_connection->query($sql);
         */
        $result_of_login_check = $this->db_connection->count("users", [
            "OR" => [
                "user_name" => $user_name,
                "user_email" => $user_name // username or email
            ]
        ]);
        // if this user exists
        if ($result_of_login_check == 1) {
            // get result row (as an object)
            // NOTE: we are really gonna use arrays. In PHP 5.4+, array is like this [], others are old array()
            $result_row = $this->db_connection->get("users", [
              //COLUMNS
              'user_id', 'user_name', 'user_email', 'user_password',
              'first_name', 'last_name', 'user_account_type',
              'created', 'modified'
            ], [
              // CONDITIONS
              "OR" => [
                  "user_name" => $user_name,
                  "user_email" => $user_name // username or email
              ]
            ]);
            // using PHP 5.5's password_verify() function to check if the provided password fits
            // the hash of that user's password
            if (password_verify($user_password, $result_row['user_password'])) {
                // Check FOR REST API to avoid performance drops
                if ($this->isForJsonObject()==false) {

                    // write user data into PHP SESSION (a file on your server)
                    // $_SESSION['user_name'] = $result_row->user_name; // example

                    // Multi-user setup like google auth system
                    $user_id = $result_row['user_id'];
                    $user_name = $result_row['user_name'];
                    Session::set_user('current_user', $user_id);
                    Session::set_user('user_name', $user_name, $user_id);
                    Session::set_user('user_email', $result_row['user_email'], $user_id);
                    Session::set_user('first_name', $result_row['first_name'], $user_id);
                    Session::set_user('last_name', $result_row['last_name'], $user_id);
                    Session::set_user('user_logged_in', true, $user_id);
                    Session::set_user('user_logged_in_as', $result_row['user_account_type'], $user_id);
                    // Session::set_user('active', true, $user_id);

                }
                // response
                $this->messages[] = "Hi ".$user_name."!";
                // $this->messages[] = "<pre>".print_r(Session::get('users'), true)."</pre>";
                $this->status = 'success';
                // check again if the user requested json object
                if ($this->isForJsonObject()) {
                    // FETCH USER AS JSON
                    $user = array(
                        'user_id'=>$result_row['user_id'],
                        'user_name'=>$result_row['user_name'],
                        'name'=>$result_row['first_name'].' '.$result_row['last_name'],
                        'user_email'=>$result_row['user_email'],
                        'created'=>$result_row['created'],
                        'modified'=>$result_row['modified']
                    );
                    $this->getUserJSON($user);
                }
            } else {
                $this->errors[] = "Wrong password. Try again.";
                $this->status = 'wrong_password';
            }
        } else {
            $this->errors[] = "This user does not exist.";
            $this->status = 'not_exist';
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
        $this->status = 'success';
        // JSON
        if ($this->isForJsonObject()) {
            echo Helper::json_encode([
                'status'=>$this->status,
                'messages'=>$this->messages
            ]);
        }
    }
    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        // if (Session::get_user('user_logged_in') && !isset($_GET["logout"])) { // you can use session lib
        if (Session::user_logged_in() && !isset($_GET["logout"])) { // you can use session lib
            // return $_SESSION['users']['id]['user_logged_in']; // native use of session sample
            return true;
        } else {
            return false;
        }
    }

    /**
     * TODO: Simple operations for a while
     * @return bool
     */
    public function addUserRequest()
    {
        return $this->add_user_requested;
    }

    /**
     * Get users data in JSON format
     * @param array $user
     */
    private function getUserJSON(array $user) {
        // gonna use the json library
        echo Helper::json_encode([
            'status'=>$this->status,
            'errors'=>$this->errors,
            'messages'=>$this->messages,
            'user'=>$user
        ]);
    }

    /**
     * Add some process after the end of processes inside this class
     * You can put your json response here
     */
    public function __destruct()
    {
        // JSON TEST
        if ($this->isForJsonObject()) {
            $this->setLayouts(false);
        }
    }
}
