<?php

/**
 * Session class
 *
 * handles the session stuff. creates session when no one exists, sets and
 * gets values, and closes the session properly (=logout). Those methods
 * are STATIC, which means you can call them with Session::get(XXX);
 *
 * New tests: Multi-user setups like the Google Auth System
 *
 * @author panique from PHP-LOGIN
 * @modified by jccultima123
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Session
{
    /**
     * starts the session
     */
    public static function init()
    {
        // if no session exist, start the session
        if (session_id() == '') { session_start(); }
    }

    /**
     * sets a specific value to a specific key of the session
     * @param mixed $key
     * @param mixed $value
     * @param bool $append - For arrays / objects
     */
    public static function set($key, $value, $append = false)
    {
        if (is_array($value) && $append) {
            $arr = $_SESSION[$key]; // expecting as array/object
            array_merge($arr, $value);
            $_SESSION[$key] = $arr;
        } else {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * Alternate version of set() for users
     * sets a specific value to a specific key of the session
     * @param mixed $key
     * @param mixed $value
     * @param $id
     */
    public static function set_user($key, $value, $id=null)
    {
        if (!empty($id)) {
            // for existing active user
            $_SESSION['users'][$id][$key] = $value;
        } else {
            // other user options
            $_SESSION['users'][$key] = $value;
        }
    }

    /**
     * gets/returns the value of a specific key of the session
     * @param mixed $key Usually a string
     * @return mixed
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    /**
     * gets/returns the value of a specific user currently log in
     * @param $key - User Details
     * @return mixed
     */
    public static function get_user($key)
    {
        if (isset($_SESSION['users'])) {
            $current_id = $_SESSION['users']['current_user'];
            $id = (isset($current_id) ? $current_id : null);
            if (isset($_SESSION['users'][$id][$key])) {
                return $_SESSION['users'][$id][$key];
            }
        }
    }

    /**
     * TODO: Simple operations for a while
     * @return bool
     */
    public static function user_logged_in() {
        if (isset($_SESSION['users']['current_user'])) {
            return true;
        }
    }

    /**
     * deletes all sessions
     */
    public static function destroy() {
        session_destroy();
    }

    /**
     * logging out specific user
     * @param $key - user id or any key
     */
    public static function destroy_user($key) {
        unset($_SESSION['users'][$key]);
    }

    /**
     * REST API TESTS
     * @return mixed
     */
    public static function REST_ACTIVE_TEST() {
        return self::get('REST_API'); // or $_SESSION['REST_API']
    }

}
