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
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();
    /**
     * @var bool $for_json_object Identifier if we gonna load data to json only or not
     */
    public $for_json_object = false;
    /**
     * @var bool $layouts Render with layouts
     */
    public $layouts = true;
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

        // initialize user agent
        $agent = new UserAgent();

        // =============== THE REST ARE TESTS ================

        // detect if using mobile
        if(!isset($_SESSION['isMobile'])){ $_SESSION['isMobile'] = $agent->isMobile(); }
        if($_SESSION['isMobile']) { // you can use the better `Session::get('isMobile')`
            $this->messages[] = "You are browsing using mobile!";
        }

        // REST API TEST. TODO: Must save this as a session
        // Requires POSTMAN for Chrome
        // print_r($agent->getHttpHeaders()); // use this for browser/device check & other headers
        if ($agent->getHttpHeader('HTTP_POSTMAN_TOKEN') && $agent->browser('Chrome')) {
            Session::set('POSTMAN_REST_API', true);
            $this->setForJsonObject(true);
            // print_r($agent->getRules()); check all devices
        }
    }
    /**
     * Rendering views
     * @param string $part = Partial view
     * @param array $data = Sets of data to be also rendered/returned
     */
    public function render($part, $data = array())
    {
        /**
         * UPDATE: Check if its not for JSON response
         */
        if (!$this->isForJsonObject()) {
            if ($this->layouts) {
                include(HEADER);
                include(VIEWS_PATH . $part);
                include(FOOTER);
            } else {
                include(VIEWS_PATH . $part);
            }
        }
    }

    /**
     * Database Connection
     * @param string $driver Database Driver. mysqli is default
     * @param string $charset Database Charset. utf8 is default and most compatible
     * @return DB
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
      if ($driver=='sqlite') {
          $database_properties['database_file'] = DB_FILE;
          unset($database_properties['database_name']);
      }
      $database = new DB($database_properties); // DB START!
      // DB Errors within connection
      $database->errors = (null!==$database->error() || !empty($database->error())) ? $database->error() : array();
      return $database;
    }

    /**
     * Using Whoops error reporting
     * @param $instance
     * @param $handler
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
     * UPDATE: Combined into one
     * @param array $classes Set of classes with set of feedback after execution
     * @param bool $reset Reset response (BETA! set this as true if it's the last one)
     */
    public function collectResponse(array $classes, $reset=true)
    {
        $response = $reset ? array() : Session::get('response');
        foreach($classes as $class) {
            foreach($class->errors as $error) {
                $response['messages'][] = '[ERR] '.$error;
            }
            foreach($class->messages as $message) {
                $response['messages'][] = '[MSG] '.$message;
            }
        }
        Session::set('response', $response); // fill me up
    }

    /**
     * For JSON
     * @return bool
     */
    public function isForJsonObject()
    {
        return $this->for_json_object;
    }

    /**
     * UPDATE: Disable layouts
     * @param bool $for_json_object
     */
    public function setForJsonObject($for_json_object)
    {
        $this->for_json_object = $for_json_object;
        if ($for_json_object) {
            $this->layouts=false;
            header("Content-Type: application/json");
        }
    }
}
