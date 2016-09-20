<?php

require_once('Init.php');

/**
 * Core components
 *
 * This class should only in the following:
 * - Load other libraries (in /libraries dir)
 * - Do action first (if you want) everytime the user requests (e.g: init)
 */
class Core extends Init
{
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
        $this->setFeedback();
    }

    /**
     * Rendering views
     * @param string $part = Partial view
     * @param string $type = Rendering types
     * @param array $data = Sets of data to be also rendered/returned
     */
    public function render($part, $type = null, $data = array())
    {
      switch($type) {
        // For server-side rendering of partial views
        case 'ajax':
        case 'file':
        case 'partial':
          include($part);
        break;
        default:
          include(HEADER);
          include($part);
          include(FOOTER);
        break;
      }
    }

    /**
     * Database Connection
     * @param string $driver Database Driver. mysqli is default
     */
    public function connect_database($driver = null)
    {
        switch($driver) {
            case 'mysql':
            case 'mysqli':
            default:
                $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if ($db->connect_error) { die();
                } else {
                    return $db;
                }
            break;
            // PDO coming soon
            case 'PDO':
            case 'pdo':
                return false;
            break;
        }
    }

    private function setFeedback()
    {
        Session::set('feedback_positive', null);
        Session::set('feedback_negative', null);
        Session::set('feedback_note', null);
    }
}
