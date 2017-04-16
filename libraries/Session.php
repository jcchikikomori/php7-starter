<?php

/**
 * Session class
 *
 * handles the session stuff. creates session when no one exists, sets and
 * gets values, and closes the session properly (=logout). Those methods
 * are STATIC, which means you can call them with Session::get(XXX);
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
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * sets a specific value to a specific key of the session
     * @param mixed $key
     * @param mixed $value
     */
    public static function set_user($key, $value)
    {
        $_SESSION['users'][$key] = $value;
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
     * @param mixed $key Usually a string
     * @return mixed
     */
    public static function user($id)
    {
        if (isset($_SESSION['users'][$id])) {
            return $_SESSION['users'][$id];
        }
    }

    /**
     * deletes all sessions
     */
    public static function destroy() {
        session_destroy();
    }

    /**
     * logging out all users
     */
    public static function destroy_user($key) {
        unset($_SESSION['users'][$key]);
    }

    public static function REST_ACTIVE_TEST() {
        return self::get('REST_API'); // or $_SESSION['REST_API']
    }

}
