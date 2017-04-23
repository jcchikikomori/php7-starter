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
    public static function json_encode(array $data=[]) {
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

    /**
     * Display Messages
     */
    public static function getFeedback() {
        $obj = Session::get('response');
        if (isset($obj)) {
            if (!empty($obj['messages'])) {
                echo '<div class="alert bg-success alert-dismissible" role="alert"><button class="close" aria-label="close" data-dismiss="alert" type="button"><span aria-hidden="true">x</span></button>';
                echo '<ul class="list-unstyled"><strong>MSG FROM SERVER</strong><br /><br />';
                foreach ($obj['messages'] as $message) {echo '<li>' . $message . '</li>';}
                echo '</ul>';
                echo '</div>';
            }
        }
        // else {echo 'Session error';}
        Session::destroy('response');
    }
}