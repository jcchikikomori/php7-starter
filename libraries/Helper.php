<?php

/**
 * Combined needed helper functions for MyPHP
 * Created by jccultima123
 */
class Helper
{
    /**
     * Recommended REST values. You can change this if you wish
     * @param array $data - any of data or arrays you wish
     * @return string - JSON
     */
    public static function json_encode($data=[]) {
        $array = [];
        if (!empty($data)) {
            // you can change this based on MyPHP class
            foreach($data as $dat => $key) {
                $array[$dat] = $key; // much better!
            }
        }
        return json_encode($array); // return as response
    }

    /**
     * @param $json
     * @return mixed
     */
    public static function json_decode($json) {
        return json_decode($json);
    }
}