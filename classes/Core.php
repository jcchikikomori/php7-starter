<?php

require_once('Init.php'); // INIT

// Required to do
use Jenssegers\Agent\Agent as UserAgent;
use Whoops\Handler\JsonResponseHandler as JSONErrorHandler;
use Whoops\Handler\PrettyPageHandler as PrettyErrorHandler;
use Whoops\Run as ErrorHandler;
use Medoo\Medoo as DB; // Using Medoo namespace as DB

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

        // ERROR HANDLING USING WHOOPS
        // TODO: Custom error pages/callbacks for deployed app
        if (ENVIRONMENT == 'development') {
            $errorReporting = new ErrorHandler();
            $errorHandler = new PrettyErrorHandler();
            $this->errorReporting($errorReporting, $errorHandler);
        }
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
     * @param string $charset Database Charset. utf8 is default and most compatible
     */
    public static function connect_database($driver=DB_TYPE,$charset='utf8')
    {
      $database_properties = [
        'database_type' => $driver,
        'database_name' => DB_NAME,
        'server' => DB_HOST,
        'username' => DB_USER,
        'password' => DB_PASS,
        'charset' => $charset,
        'port' => (defined(DB_PORT) && !empty(DB_PORT) ? DB_PORT : 3306), // if defined then use, else default
        //'prefix' => 'db_', // [optional] Table prefix
        //'socket' => '/tmp/mysql.sock', // [optional] MySQL socket (shouldn't be used with server and port)
        // [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php ERASE/EMPTY THIS IF YOU DON'T WANT THIS
        'option' => [ PDO::ATTR_CASE => PDO::CASE_NATURAL ],
        // [optional] Medoo will execute those commands after connected to the database for initialization. ERASE/EMPTY THIS IF YOU DON'T WANT THIS
        //'command' => [ 'SET SQL_MODE=ANSI_QUOTES' ]
      ];
      // SQLite Support
      if ($driver=='sqlite') { $database_properties['database_file'] = DB_FILE; }
      $database = new DB($database_properties); // DB START!
      // DB Errors within connection
      $database->errors = (null!==$database->error() || !empty($database->error())) ? $database->error() : array();
      return $database;
    }

    /**
     * Using Whoops error reporting
     */
    public function errorReporting($instance, $handler) {
        if (\Whoops\Util\Misc::isAjaxRequest()) {
            $jsonHandler = new JsonResponseHandler();
            $jsonHandler->addTraceToOutput(true);
            $jsonHandler->setJsonApi(true);
            $instance->pushHandler($jsonHandler); // and push it to the stack
        } else { // normal
            $instance->pushHandler($handler);
        }
        $instance->register(); //push to current stack
    }

    /**
     * Collect Response based from class you've defined.
     * @param array $classes Set of classes with set of feedback after execution
     */
    public function collectResponse(array $classes)
    {
        $response = array();
        foreach($classes as $class) {
            foreach($class->errors as $error) {
                $response['errors'][] = $error;
            }
            foreach($class->messages as $message) {
                $response['messages'][] = $message;
            }
        }
        Session::set('response', $response); // fill me up
    }
}
