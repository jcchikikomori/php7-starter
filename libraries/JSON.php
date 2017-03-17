<?php

/**
 * Created by jccultima123
 */
class JSON
{
    /**
     * Recommended REST values. You can change this if you wish
     * @param array $arrays
     * @param $response
     * @return string
     */
    public static function encodeREST(array $arrays, $response) {
        $array = array();
        $array['response'] = $response;
        $array['data'] = $arrays; // datas like fetched from database
        return json_encode($array);
    }

    /**
     * @param $json
     * @return mixed
     */
    public static function decodeREST($json) {
        return json_decode($json);
    }
}