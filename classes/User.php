<?php

class User extends App
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

		/**
		 * Sends new password to user or generates reset code
		 */
		public function resetPassword($id) {
				// SOON
		}

}

?>
