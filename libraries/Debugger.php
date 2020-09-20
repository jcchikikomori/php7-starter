<?php

namespace libraries;

/**
 * Debugger
 * Author: John Cyrill Corsanes
 */
class Debugger
{
    /**
     * Dumps a variable
     * TODO: Make a environment setup for developers
     *
     * @param  [type] $obj
     * @return void
     */
    public static function dump($obj)
    {
        echo var_dump($obj);
    }
}
