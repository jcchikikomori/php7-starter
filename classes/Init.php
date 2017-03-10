<?php

/**
 * Initialize the whole program!
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

        // checking for minimum PHP version
        if (version_compare(PHP_VERSION, '5.4.0', '<') AND version_compare(PHP_VERSION, '7', '>')) {
            exit("Sorry, This system does not run on a PHP version smaller than 5.3.7 and still unstable in ".PHP_VERSION);
        } else {
            // The Composer auto-loader (official way to load Composer contents) to load external stuff automatically
            $lib = ROOT.'vendor/autoload.php';
            $config = ROOT.'config.php';
            if (file_exists($lib)) {
                require $lib;
                if (!file_exists($config)) {
                    //TODO: Bypass config and use default values instead then give a error feedback
                    exit("File " . $config . " might be corrupted or missing.<br />Please create config.php manually with config.php.example. ");
                } else {
                    require ROOT.'config.php';
                }
            } else {
                exit("The COMPOSER file " . $lib . " might be corrupted or missing.");
            }
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

        // Fixed Paths
        define('LIBS_PATH', ROOT . 'libraries' . DIRECTORY_SEPARATOR);
        define('VIEWS_PATH', 'views' . DIRECTORY_SEPARATOR); // fix dir issues on different OSes
        define('ASSETS', 'assets' . DIRECTORY_SEPARATOR);
        // Templates
        define('HEADER', VIEWS_PATH . 'header.php');
        define('FOOTER', VIEWS_PATH . 'footer.php');
        define('POST_HEADER_LOGGED', VIEWS_PATH . 'header_logged_in.php'); // maybe redundant
        // Database Properties, if these are is not used
        // SOON
    }
}
