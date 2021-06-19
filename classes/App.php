<?php

// To identify that this is under [namespace] directory.
// Read more: https://www.php.net/manual/en/language.namespaces.basics.php
namespace classes;

// Dotenv
use Dotenv\Dotenv as Env;

// UserAgent plugin
use Jenssegers\Agent\Agent as UserAgent;

// Meedoo plugin
// Using Medoo as DB
use Medoo\Medoo as DB;

// require libraries
use PDO; // from PHP
use libraries\Session as Session;
use libraries\Helper as Helper;

/**
 * Firing up!
 * Don't touch this if you don't know what you're doing!
 * Without this, the app won't run in the first place
 *
 * This class should only in the following:
 * - Load other libraries (in /libraries dir)
 * - Do action first (if you want) everytime the user requests (e.g: init)
 *
 * PHP version 7.2
 *
 * @category App
 * @package  PHP7Starter
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  Release: 0.51-alpha
 * @link     https://github.com/jcchikikomori/php7-starter
 */
class App
{
    /**
     * @var Dotenv object
     */
    public $dotenv = null;
    /**
     * @var object $db_connection The database connection
     */
    public $db_connection = null;
    /**
     * @var Whoops object
     */
    public $whoops = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();
    /**
     * APP OPTIONS
     * These are the sets of customizations that you can do with your project
     */
    public $layouts = true; // Render with layouts
    public $multi_user_status = false; // multi-user system
    /**
     * @var array Collection of responses
     */
    public $response = array(); // collecting response

    /**
     * FIXED PATHS
     */
    protected $views_path; // default views path
    protected $assets_path; // For files under root/public
    protected $templates_path; // templates like default header
    protected $header_path; // layout header path
    protected $footer_path; // layout footer path

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // ======================= CONSTRUCTOR =======================

        /**
         * Reinitialize root directory first
         *
         * NOTE: Use DIRECTORY_SEPARATOR instead of slashes to avoid server confusions in paths
         * and PHP will find a right slashes for you
         */
        if (!defined('ROOT')) {
            define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
        }

        /**
         * Autoload Composer
         * - First, PHP version check (If current PHP version was less than 7)
         */
        if (version_compare(PHP_VERSION, '7', '<')) {
            exit("Sorry, your PHP Version " . PHP_VERSION . " is not compatible anymore for this system.");
        } else {
            $composer = ROOT . 'vendor/autoload.php';
            $configs = ROOT . 'configs' . DIRECTORY_SEPARATOR;
            $config = $configs . 'system.php'; // check default config
            /**
             * The Composer auto-loader (official way to load Composer contents)
             * to load external stuff automatically
             */
            (@include_once $composer) or die("The COMPOSER file " . $composer . " might be corrupted or missing.");
            /**
             * LOAD ALL CONFIGS ON configs directory
             */
            if (!file_exists($config)) {
                die("File " . $config .
                    " might be corrupted or missing.<br />Please do <code>composer dump-autoload</code>");
            } else {
                foreach (glob($configs . '*.php') as $configs) {
                    include_once $configs;
                }
            }
        }

        /**
         * Load .env straightforward
         */
        $dotenv = Env::createImmutable(ROOT);
        $dotenv->load();

        /**
         * Time Zones - set your own (optional)
         * To see all current timezones, @see http://php.net/manual/en/timezones.php
         * SAMPLE: date_default_timezone_set("Asia/Manila");
         */

        /**
         * Environment
         * - define('ENVIRONMENT', 'development'); Enables Error Report and Debugging
         * - define('ENVIRONMENT', 'release'); Disables Error Reporting for Performance
         * - define('ENVIRONMENT', 'web'); For Web Hosting / Deployment
         * (don't use if you are about to go development/offline)
         */
        if (!defined($_ENV['ENVIRONMENT']) && empty($_ENV['ENVIRONMENT'])) {
            define('ENVIRONMENT', 'release');
        }

        /**
         * Application folder
         * TODO: Restructure first
         */
        if (!defined('APP_DIR')) {
            define('APP_DIR', ROOT . 'application');
        }

        /**
         * Load external libraries/classes by LOOP.
         * Have a look all the files in that directory for details.
         */
        foreach (glob(ROOT . 'libraries' . DIRECTORY_SEPARATOR . '*.php') as $libraries) {
            require_once $libraries;
        }

        /**
         * Detect coding errors using Whoops!
         */
        $whoops = new \Whoops\Run();

        /**
         * Use PrettyPageHandler
         */
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        /**
         * Detect if request comes from REST
         */
        if (\Whoops\Util\Misc::isAjaxRequest()) {
            $whoops->removeLastHandler();
            $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler());
        }

        /**
         * Finally register Whoops handler
         */
        $whoops->register();

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

        /**
         * Multi-user default value
         */
        if (!defined('MULTI_USER')) {
            define('MULTI_USER', false);
        }

        /**
         * Multi-user
         * Default is false
         */
        $this->multi_user_status = MULTI_USER;

        /**
         * Fixed Paths
         * You can change them if you wish
         * Just don't break the right structure/variables there
         */
        $this->templates_path = ROOT . 'views' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
        $this->views_path = ROOT . 'views' . DIRECTORY_SEPARATOR;
        $this->assets_path = ROOT . 'assets' . DIRECTORY_SEPARATOR;
        $this->header_path = $this->templates_path . 'header.php';
        $this->footer_path = $this->templates_path . 'footer.php';

        // ======================= END OF INIT =======================

        // create/read session, absolutely necessary
        Session::init(); // or session_start();

        // initialize user agent
        $agent = new UserAgent();

        // detect if using mobile
        if ($agent->isMobile()) {
            $this->messages[] = "You are browsing using mobile!";
        }

        // You can test dotenv by uncommenting these lines below
        // (by either using $_ENV or straight constant)
        // $this->messages[] = $_ENV['WOWOWIN'];
        // $this->messages[] = ENVIRONMENT;

        // AJAX Detection
        // $this->setForJsonObject(true);

        // var_dump($agent->getHttpHeaders()); // use this for browser/device check & other headers
        // var_dump($agent->getRules()); //check all devices

        // ======================= END OF CONSTRUCTOR =======================
    }

    /**
     * Rendering views
     *
     * @param string $part  = Partial view
     * @param array  $data  = Sets of data to be also rendered/returned
     * @param object $class
     */
    public function render($part, $data = array(), $class = null)
    {
        // Check if its not for JSON response
        if (!$this->isForJsonObject()) {
            extract($data); // extract array keys into variables
            if ($this->isLayouts()) {
                include $this->header_path;
                include $this->views_path . $part . '.php';
                include $this->footer_path;
            } else {
                include $this->views_path . $part . '.php';
            }
        }
    }

    /**
     * Render partial file wihout checking layout switch
     *
     * @param string $part = Partial view
     */
    public function render_partial($part)
    {
        include $this->views_path . $part . '.php';
    }

    /**
     * Custom message params
     * Title - $data['error_title'] - String
     * Message - $data['error_message'] - REQUIRED
     * Debugging - $data['debug'] - Array()
     */
    public function error($message, $data = array())
    {
        $data['error_message'] = $message;
        $this->render('templates/error_page', $data);
    }

    /**
     * Database Connection - Powered by Meedoo
     *
     * @source https://medoo.in/api/new - Check this for more details about this function
     * @param  string $driver  Database Driver. mysqli is default
     * @param  string $charset Database Charset. utf8 is default and most compatible
     * @return DB
     */
    public function connect_database($driver = DB_TYPE, $charset = 'utf8')
    {
        $database_properties = [
          'database_type' => $driver,
          'database_name' => DB_NAME,
          'server' => DB_HOST,
          'username' => DB_USER,
          'password' => DB_PASS,
          'charset' => $charset,
          'port' => (defined(DB_PORT) && !empty(DB_PORT) ? DB_PORT : 3306), // if defined then use, else default
          'option' => [ PDO::ATTR_CASE => PDO::CASE_NATURAL ],
          'error' => PDO::ERRMODE_SILENT
        ];

        // SQLite Support
        if ($driver == 'sqlite') {
            $database_properties['database'] = DB_FILE;
            // unset fields that don't need for sqlite
            unset($database_properties['database_name']);
            unset($database_properties['server']);
            unset($database_properties['username']);
            unset($database_properties['password']);
            unset($database_properties['charset']);
            unset($database_properties['port']);
        }
        return new DB($database_properties); // DB START!
    }

    /**
     * Collect Response based from class you've defined.
     *
     * @param  array $classes Set of classes with set of feedback after execution
     * @param  null  $tag     Custom tags (e.g: [INFO])
     *                       WARNING: Currently using
     *                       ternary conditions inside
     *                       the loop
     *                       https://davidwalsh.name/php-shorthand-if-else-ternary-operators
     * @return mixed
     */
    public function collectResponse(array $classes, $tag = null)
    {
        $response = Session::get('response');
        foreach ($classes as $class) {
            foreach ($class->errors as $error) {
                $response['messages'][] = '[' . (!empty($tag) ? $tag : 'ERR') . '] ' . $error;
            }
            foreach ($class->messages as $message) {
                $response['messages'][] = '[' . (!empty($tag) ? $tag : 'MSG') . '] ' . $message;
            }
            // reset class ent
            $class->errors = array();
            $class->messages = array();
        }
        Session::set('response', $response); // fill me up
    }

    /**
     * For JSON
     *
     * @return bool
     */
    public function isForJsonObject()
    {
        // traditional way
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    /**
     * Set JSON headers
     */
    public function setForJsonObject()
    {
        if ($this->isForJsonObject()) {
            $this->layouts = false;
            header("Content-Type: application/json");
        }
    }

    /**
     * @return bool
     */
    public function isLayouts()
    {
        return $this->layouts;
    }

    /**
     * @param bool $layouts
     */
    public function setLayouts($layouts)
    {
        $this->layouts = $layouts;
    }
}
