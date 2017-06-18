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
     * For JSON
     * @var string $status
     */
    public $status;
    /**
     * Multi-user checks
     * @var bool
     */
    public $multi_user_requested = false;
    public $switch_user_requested = false;
    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        parent::__construct();

        $this->db_connection = $this->connect_database(); // if this class needed a database connection, use this line

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }

        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->doLogin();
            // Were gonna use Session library for handling $_SESSION objects
            if (Session::get('user_logged_in')) {
                // POST ACTIONS AFTER LOGIN
            }
        }

        elseif (isset($_GET['add_existing_user'])) {
            $this->multi_user_requested = true; // triggers multi user request
        }

        // this would log out current log session
        // but will not delete user session data
        elseif (isset($_GET['switch_user'])) {
            $this->switch_user_requested = true; // triggers switch user request
            $this->cleanUpUserSession();
        }

        // login via get data (multi-user)
        elseif (isset($_GET["login"]) &&
            (isset($_GET['u']) && !empty($_GET['u'])) && // u for user_id
            (isset($_GET['n']) && !empty($_GET['n'])) ) { // n for name/username
            $user_id = $_GET['u']; $user_name = $_GET['n'];
            $this->doLoginMultiUser($user_id, $user_name);
        }

        // logout via get data (multi-user)
        elseif (isset($_GET["logout"]) &&
            (isset($_GET['u']) && !empty($_GET['u'])) && // u for user_id
            (isset($_GET['n']) && !empty($_GET['n'])) ) { // n for name/username
            $user_id = $_GET['u'];
            $user_name = $_GET['n'];
            $this->doLogout($user_id, $user_name);
        }

        else {
            // return to default trigger values
            $this->multi_user_requested = false;
            $this->switch_user_requested = false;
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
                    $first_name = $result_row['first_name'];
                    $last_name = $result_row['last_name'];
                    Session::set('current_user', $user_id);
                    Session::set_user('user_name', $user_name);
                    Session::set_user('user_email', $result_row['user_email']);
                    Session::set_user('full_name', $first_name . " " . $last_name);
                    // Session::set_user('first_name', $first_name);
                    // Session::set_user('last_name', $last_name);
                    Session::set('user_logged_in', true);
                    Session::set_user('user_logged_in_as', $result_row['user_account_type']);
                }
                // response
                $this->messages[] = "Hi ".$user_name."!";
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
      $this->collectResponse(array($this));
    }
    /**
     * Multi-user version of doLogin()
     * NOTE: Check documentations/comments from doLogin()
     * @param $user_id
     * @param $user_name
     */
    private function doLoginMultiUser($user_id, $user_name)
    {
        // MULTI USER CHECKS
        if ($this->multi_user_status && Session::check_user($user_id)) {
            $result_of_login_check = $this->db_connection->count("users", [
                "user_id" => $user_id
            ]);
            // if this user exists
            if ($result_of_login_check == 1) {
                $result_row = $this->db_connection->get("users", [
                    //COLUMNS
                    'user_id', 'user_name', 'user_email', 'user_password',
                    'first_name', 'last_name', 'user_account_type',
                    'created', 'modified'
                ], [
                    // CONDITIONS
                    "OR" => [
                        "user_id" => $user_id,
                        "user_email" => $user_name // username or email
                    ]
                ]);
                // Check FOR REST API to avoid performance drops
                if ($this->isForJsonObject()==false) {

                    // write user data into PHP SESSION (a file on your server)
                    // $_SESSION['user_name'] = $result_row->user_name; // example

                    // Multi-user setup like google auth system
                    $user_id = $result_row['user_id'];
                    $user_name = $result_row['user_name'];
                    $first_name = $result_row['first_name'];
                    $last_name = $result_row['last_name'];
                    Session::set('current_user', $user_id);
                    Session::set_user('user_name', $user_name);
                    Session::set_user('user_email', $result_row['user_email']);
                    Session::set_user('full_name', $first_name . " " . $last_name);
                    // Session::set_user('first_name', $first_name);
                    // Session::set_user('last_name', $last_name);
                    Session::set('user_logged_in', true);
                    Session::set_user('user_logged_in_as', $result_row['user_account_type']);
                }
                // response
                $this->messages[] = "Hi ".$user_name."!";
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
                $this->errors[] = "This user does not exist.";
                $this->status = 'not_exist';
            }
        } else {
            // for REST response
            if ($this->isForJsonObject()) {
                $this->errors[] = "Please use the login form.";
            }
            $this->status = 'failed';
        }
        $this->collectResponse(array($this));
    }

    /**
     * perform the logout
     * @param $user_id
     * @param $user_name
     */
    public function doLogout($user_id=null, $user_name=null)
    {
        $set_user_name = Session::get_user('user_name',$user_id); // validation

        if ($this->multi_user_status && Session::destroy_user($user_id)) {
            if (empty($user_name)) {
                $this->messages[] = "You have been logged out";
            }
            elseif ($set_user_name == $user_name) { // validate
                $this->messages[] = $user_name." has been logged out";
            }
            $this->status = 'success';
        } else if (!$this->multi_user_status) {
            Session::destroy('users');
            $this->messages[] = "You have been logged out";
        }

        // cleaning up
        $this->cleanUpUserSession();

        // JSON
        if ($this->isForJsonObject()) {
            echo Helper::json_encode([
                'status' => $this->status,
                'messages' => $this->messages
            ]);
        }

        $this->collectResponse(array($this));
    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (Session::user_logged_in() && !isset($_GET["logout"])) { // you can use session lib
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Generate code then save to database
     */
    public function generateRandomCode() {
        $code = Helper::generateRandomCode(5); // 5 characters
        $query = $this->db_connection->insert("reset_codes", [ "code" => $code ]);
        if (!$query) { // IF NOT SUCCESSFUL
            $this->errors[] = "Unable to save random code!";
            $this->status = "failed";

            if ($this->isForJsonObject()) {
                return Helper::json_encode([
                    'status' => $this->status,
                    'errors' => $this->errors
                ]);
            }

            $this->collectResponse(array($this)); // COLLECT RESPONSE
            return false;
        }
        return $code;
    }

    /**
     * Verifies reset code for password change
     * @return bool
     */
    public function verifyResetCode($id, $reset_code) {
				// SOON
        if (isset($user_id) && isset($reset_code)) {
            $result = $this->db_connection->get("reset_codes",
                ['code', 'UNIX_TIMESTAMP(created)'], ["code" => $reset_code, "LIMIT" => 1] // [fields], [conditions]
            );
            if (($result['code'] == $reset_code) && ($result['created'] > 3600)) { // 3600 seconds
                $this->messages[] = "Verified. Please reset your password now.";
                $this->status = "success";
            } else {
                $this->errors[] = "Sorry, Reset code was already expired.";
                $this->status = "failed";
            }
        } else {
            $this->errors[] = "Sorry, Unable to verify your account. Please check your code from e-mail.";
            $this->status = "failed";
        }
        $this->collectResponse(array($this));
		}

    /**
     * Clean up current user session statuses
     * but it will not erase any user session data
     */
    public function cleanUpUserSession()
    {
        Session::set('current_user', null);
        Session::set('user_logged_in', false);
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
}
