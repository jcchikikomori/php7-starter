<?php

require_once('Init.php'); // require Init class!

use Medoo\Medoo; // Using Medoo namespace (NEW DB FRAMEWORK)

/**
 * Core components
 *
 * This class should only in the following:
 * - Load other libraries (in /libraries dir)
 * - Do action first (if you want) everytime the user requests (e.g: init)
 */
class Core extends Init
{
    /**
     * @var object $db_connection The database connection
     */
    public $db_connection = null;
    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        parent::__construct();

        // Composer plugin test
        // You can use this if you want.
        // $browser = new Browser(); // Browser() from composer
        // echo $browser;
        // if (($browser->getBrowser() == Browser::BROWSER_CHROME && $browser->getVersion() <= 30)) {
        //     echo 'Not Compatible!';
        // } else {
        // 	echo 'Compatible';
        // }

        // load external libraries/classes by LOOP. have a look all the files in that directory for details.
        foreach (glob(LIBS_PATH . '*.php') as $files) { require $files; }
        // create/read session, absolutely necessary
        Session::init(); // or session_start();
    }
    /**
     * Rendering views
     * @param string $part = Partial view
     * @param string $type = Rendering types
     * @param array $data = Sets of data to be also rendered/returned
     */
    public function render($part, $data = array(), $type = null)
    {
      switch($type) {
        // For server-side rendering of partial views
        case 'ajax':
        case 'file':
        case 'partial':
          include(VIEWS_PATH . $part);
        break;
        default:
          include(HEADER);
          include(VIEWS_PATH . $part);
          include(FOOTER);
        break;
      }
    }
    /**
     * Database Connection
     * @param string $driver Database Driver. mysqli is default
     */
    public static function connect_database($driver='mysql')
    {
      $database = new Medoo([
        // required
        'database_type' => $driver,
        'database_name' => DB_NAME,
        'server' => DB_HOST,
        'username' => DB_USER,
        'password' => 'your_password',
        'charset' => 'utf8',
        'port' => 3306,
        // [optional] Table prefix, COMMENT THIS IF YOU DON'T WANT THIS
        'prefix' => 'db_',
        // [optional] MySQL socket (shouldn't be used with server and port), COMMENT THIS IF YOU DON'T WANT THIS
        'socket' => '/tmp/mysql.sock',
        // [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
        // ERASE/EMPTY THIS IF YOU DON'T WANT THIS
        'option' => [
          PDO::ATTR_CASE => PDO::CASE_NATURAL
        ],
        // [optional] Medoo will execute those commands after connected to the database for initialization
        // ERASE/EMPTY THIS IF YOU DON'T WANT THIS
        'command' => [
          'SET SQL_MODE=ANSI_QUOTES'
        ]
      ]);
      /**
        switch($driver) {
            case 'mysql':
            case 'mysqli':
            default:
                $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if ($db->connect_error) {
                  // die();
                  return false;
                } else {
                  if (!$db->set_charset("utf8")) {
                    return false;
                  } else {
                    return $db; // will return DB connection as object
                  }
                }
            break;
            // PDO coming soon
            case 'PDO':
            case 'pdo':
                return false;
            break;
            case 'V2':
            case 'meedoo':
            break;
        }
        */
    }
    /**
     * Collect Response based from class you've defined.
     * @param array $classes Set of classes with set of feedbacks after execution
     */
    public function collectResponse($classes = array())
    {
        $response = array(); // set empty
        foreach($classes as $class) {
          $response['errors'] = $class->errors;
          $response['messages'] = $class->messages;
        }
        Session::set('response', $response); // fill me up
    }
}
