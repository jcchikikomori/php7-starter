<?php

class System extends Core
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
        // parent was from the extended class
        // parent::__construct(); // already declared on Core
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function getView()
    {
        // change character set to utf8 and check it
        include("views/system/dashboard.php");
    }
    
}

?>