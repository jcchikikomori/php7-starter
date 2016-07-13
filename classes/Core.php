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
        
        // echo 'dsadasda'; //test

        // Composer plugin test
        
        // $browser = new Browser(); // Browser() from composer
        // echo $browser;
        // if (($browser->getBrowser() == Browser::BROWSER_CHROME && $browser->getVersion() <= 30)) {
        //     echo 'Not Compatible!';
        // } else {
        // 	echo 'Compatible';
        // }

        // load external libraries/classes by LOOP. have a look all the files in that directory for details.
        foreach (glob(LIBS_PATH . '*.php') as $files) { require $files; }
    }
}