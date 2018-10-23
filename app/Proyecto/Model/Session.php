<?php

class Session
{
    /**
     * @var bool
     */
    protected static $sessionStarted = false;

    /**
     *
     */
    public static function start()
    {
        if(!self::$sessionStarted) {
            session_start();
            self::$sessionStarted = true;
        }
    }

    /**
     *
     */
    public static function destroy()
    {
        if(self::$sessionStarted) {
            session_destroy();
            self::$sessionStarted = false;
        }
    }

    /**
     * @param $prop
     * @param $value
     */
    public static function set($prop, $value)
    {
        self::start();
        $_SESSION[$prop] = $value;
    }

    /**
     * @param $prop
     * @return null
     */
    public static function get($prop)
    {
        self::start();
        if(self::has($prop)) {
            return $_SESSION[$prop];
        } else {
            return null;
        }
    }

    /**
     * @param $prop
     * @return bool
     */
    public static function has($prop)
    {
        return isset($_SESSION[$prop]);
    }


    /**
     * @param $prop
     * @return bool
     */
    public static function clear($prop)
    {
        self::start();
        unset($_SESSION[$prop]);
    }
}