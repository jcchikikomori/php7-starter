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

        // Reinitialize root directory
        // TODO: Not good for 'views' on some file systems & OS
        define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

        // Fixed Paths
        define('LIBS_PATH', ROOT . 'libraries' . DIRECTORY_SEPARATOR);
        define('CONF_PATH', ROOT . 'configs' . DIRECTORY_SEPARATOR);
        define('VIEWS_PATH', 'views' . DIRECTORY_SEPARATOR); // fix dir issues on different OSes
        define('ASSETS', 'assets' . DIRECTORY_SEPARATOR);
        // Templates
        define('HEADER', VIEWS_PATH . 'header.php');
        define('FOOTER', VIEWS_PATH . 'footer.php');
        define('POST_HEADER_LOGGED', VIEWS_PATH . 'header_logged_in.php'); // maybe redundant
        // Database Properties, if these are is not used (SOON)

        // checking for minimum PHP version
        if (version_compare(PHP_VERSION, '5.4.0', '<') AND version_compare(PHP_VERSION, '7', '>')) {
            exit("Sorry, This system does not run on a PHP version smaller than 5.3.7 and still unstable in ".PHP_VERSION);
        } else {
            // The Composer auto-loader (official way to load Composer contents) to load external stuff automatically
            $composer = ROOT.'vendor/autoload.php';
            $config = CONF_PATH.'system.php';
            if (file_exists($composer)) {
                require $composer;
                if (!file_exists($config)) {
                    //TODO: Bypass config and use default values instead then give a error feedback
                    exit("File " . $config . " might be corrupted or missing.<br />Please create configs/system.php manually with configs/system.php.example. ");
                } else {
                    require $config;
                    //LOAD OTHER CONFIGS ON config directory
                    foreach (glob(CONF_PATH . '*.php') as $files) { require $files; }
                }
            } else {
                exit("The COMPOSER file " . $composer . " might be corrupted or missing.");
            }
        }

        // load external libraries/classes by LOOP. have a look all the files in that directory for details.
        foreach (glob(LIBS_PATH . '*.php') as $libraries) { require $libraries; }
        // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
        // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
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
