<?php

// require_once('Init.php'); // INIT

// Required to do
use Jenssegers\Agent\Agent as UserAgent;
use Whoops\Handler\JsonResponseHandler as JSONErrorHandler;
use Whoops\Handler\PrettyPageHandler as PrettyErrorHandler;
use Whoops\Run as ErrorHandler;
use Medoo\Medoo as DB; // Using Medoo namespace as DB

/**
 * Firing up MyPHP!
 * Don't touch this if you don't know what you're doing!
 * Without this, the app won't run in the first place
 *
 * This class should only in the following:
 * - Load other libraries (in /libraries dir)
 * - Do action first (if you want) everytime the user requests (e.g: init)
 */
class Core
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
        // ======================= CONSTRUCTOR =======================

        /**
         * Time Zones
         * To see all current timezones, @see http://php.net/manual/en/timezones.php
         */
        date_default_timezone_set("Asia/Manila");

        /**
         * Environment
         * - define('ENVIRONMENT', 'development'); Enables Error Report and Debugging
         * - define('ENVIRONMENT', 'release'); Disables Error Reporting for Performance
         * - define('ENVIRONMENT', 'web'); For Webhosting (don't use if you are about to go development/offline)
         */
        if (!defined('ENVIRONMENT') && empty('ENVIRONMENT')) { define('ENVIRONMENT', 'release'); }

        /**
         * Reinitialize root directory
         * NOTE: Use DIRECTORY_SEPARATOR instead of slashes to avoid server confusions in paths
         * and PHP will find a right slashes for you
         * TODO: Not good for 'views' on some file systems & OS
         */
        define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

        /**
         * Fixed Paths
         * You can change them if you wish
         * Just don't break the right structure there
         */
        define('LIBS_PATH', ROOT . 'libraries' . DIRECTORY_SEPARATOR);
        define('CONF_PATH', ROOT . 'configs' . DIRECTORY_SEPARATOR);
        define('VIEWS_PATH', 'views' . DIRECTORY_SEPARATOR); // fix dir issues on different OSes
        define('ASSETS', 'assets' . DIRECTORY_SEPARATOR);
        // Templates
        define('HEADER', VIEWS_PATH . '_templates' . DIRECTORY_SEPARATOR . 'header.php');
        define('FOOTER', VIEWS_PATH . '_templates' . DIRECTORY_SEPARATOR . 'footer.php');
        // Custom template (TODO: Must be on configs)
        define('POST_HEADER_LOGGED', VIEWS_PATH . 'header_logged_in.php'); // maybe redundant

        // PHP version check
        if (version_compare(PHP_VERSION, '5.4.0', '<') AND version_compare(PHP_VERSION, '7', '>')) {
            exit("Sorry, This system does not run on a PHP version smaller than 5.3.7 and still unstable in ".PHP_VERSION);
        } else {
            // The Composer auto-loader (official way to load Composer contents) to load external stuff automatically
            $composer = ROOT.'vendor/autoload.php';
            $config = CONF_PATH.'system.php';
            if (file_exists($composer)) {
                require_once($composer); // `require` cause simply the app requires this
                if (!file_exists($config)) {
                    exit("File " . $config . " might be corrupted or missing.<br />Please create configs/system.php manually with configs/system.php.example. ");
                } else {
                    /**
                     * LOAD ALL CONFIGS ON configs directory
                     */
                    foreach (glob(CONF_PATH . '*.php') as $configs) { include_once($configs); }
                }
            } else {
                exit("The COMPOSER file " . $composer . " might be corrupted or missing.");
            }
        }

        /**
         * Load external libraries/classes by LOOP.
         * Have a look all the files in that directory for details.
         */
        foreach (glob(LIBS_PATH . '*.php') as $libraries) { require $libraries; }
        /**
         * if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
         * (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
         */
        if (version_compare(PHP_VERSION, '5.5.0', '<')) {
            require_once(ROOT . "libraries/php5/password_compatibility_library.php");
        }

        /**
         * Error reporting and User Configs
         * ER: Useful to show every little problem during development, but only show hard errors in production
         */
        switch (ENVIRONMENT) {
            case 'development':
                ini_set('display_errors', 1);
                error_reporting(E_ALL);
                break;
            case 'web':
            case 'release':
            case 'maintenance':
                // default:
                error_reporting(0);
                ini_set('display_errors', 0);
                break;
            default:
                exit("The application environment is not set correctly.");
        }

        // ======================= END OF INIT =======================

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
            Session::set('JSON_REQUESTED', true);
            $this->setForJsonObject(true);
            // print_r($agent->getRules()); check all devices
        }

        // ======================= END OF CONSTRUCTOR =======================
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
          // unset fields that don't need for sqlite
          unset($database_properties['database_name']);
          unset($database_properties['server']);
          unset($database_properties['username']);
          unset($database_properties['password']);
          unset($database_properties['charset']);
          unset($database_properties['port']);
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
