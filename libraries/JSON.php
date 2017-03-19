<?php

/**
 * Created by jccultima123
 */
class JSON
{
    /**
     * Recommended REST values. You can change this if you wish
     * @param array $class Import from current class
     * @param array $callbacks Callbacks like return/response data
     * @return string
     */
    public static function encodeREST($class, $callbacks=[]) {
        foreach($class->errors as $error) {
            $array['messages'][] = '[ERR] '.$error;
        }
        foreach($class->messages as $message) {
            $array['messages'][] = '[MSG] '.$message;
        }
        if (!empty($callbacks)) {
            foreach($callbacks as $callback) {
                $array['callbacks'][] = $callback;
            }
        }
        return json_encode($array); // return as response
    }

    /**
     * @param $json
     * @return mixed
     */
    public static function decodeREST($json) {
        return json_decode($json);
    }
}