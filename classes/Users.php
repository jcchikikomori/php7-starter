<?php

class Users extends Core
{
	/**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        // parent was from the extended class
        parent::__construct();
    }

    public function getUserTypes()
    {
        // create a database connection
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }

        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {

            // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
            // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
            // PHP 5.3/5.4, by the password hashing compatibility library
            $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

            // check if user or email address already exists
            $sql = "SELECT * FROM user_types;";
            $query = $this->db_connection->query($sql);

            if ($query->num_rows) { // 1 is true
                $this->errors[] = "None.";
            } else {
                return mysqli_fetch_array($query);
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }
    
}

?>