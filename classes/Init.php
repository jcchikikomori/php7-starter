<?php

/**
 * Start to Fire up MyPHP!
 * Don't touch this if you don't know what you're doing!
 * Without this, the app won't run in the first place
 */
class Init
{
    public function __construct()
    {
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
    }
}
