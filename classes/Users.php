<?php

class Users extends App
{
	/**
     * @var object $db_connection The database connection
     */
    public $db_connection = null;
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
        $this->db_connection = $this->connect_database();
    }

    public function getUserTypes()
    {
        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {

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