<?php

/**
 * Initialize the whole program!
 */
class Init
{
    public function __construct()
    {
        // Reinitialize root directory
        // TODO: Not good for 'views' on some file systems & OS
        define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

        // checking for minimum PHP version
        if (version_compare(PHP_VERSION, '5.3.7', '<') AND version_compare(PHP_VERSION, '5.6.23', '>')) {
            exit("Sorry, This system does not run on a PHP version smaller than 5.3.7 and still unstable in ".PHP_VERSION);
        } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
            // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
            // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
            require_once(ROOT . "libraries/password_compatibility_library.php");
        } else {
            // The Composer auto-loader (official way to load Composer contents) to load external stuff automatically
            $lib = ROOT.'vendor/autoload.php';
            $config = ROOT.'config.php';
            if (file_exists($lib)) {
                require $lib;
                if (!file_exists($config)) {
                    exit("File " . $config . " might be corrupted or missing.<br />Create a copy with config.php.example. ");
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
        if (defined('ENVIRONMENT')) {
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
            }
        } else {
            exit("The application environment is not set correctly.");
        }

        /**
         * FIXED FILES & DIRECTORIES
         */
        define('LIBS_PATH', ROOT . 'libraries' . DIRECTORY_SEPARATOR);
        define('VIEWS_PATH', 'views' . DIRECTORY_SEPARATOR); // fix dir issues on different OSes
        define('ASSETS', 'assets' . DIRECTORY_SEPARATOR);
        define('HEADER', VIEWS_PATH . 'header.php');
        define('FOOTER', VIEWS_PATH . 'footer.php');
        define('POST_HEADER_LOGGED', VIEWS_PATH . 'header_logged_in.php'); // maybe redundant
    }
}