<?php
namespace Proyecto\Session;

/**
 * Class Session
 * @package Proyecto\Session
 *
 * Administra las sesiones.
 */
class Session
{
    /**
     * Inicio de la sesión.
     */
    public static function start()
    {
        session_start();
    }

    /**
     * Destruye la sesión.
     */
    public static function destroy()
    {
        session_destroy();
    }

    /**
     * Guarda un valor en la sesión.
     *
     * @param $prop
     * @param $value
     */
    public static function set($prop, $value)
    {
        $_SESSION[$prop] = $value;
    }

    /**
     * Verifica si un valor existe en la sesión.
     *
     * @param $prop
     * @return bool
     */
    public static function has($prop)
    {
        return isset($_SESSION[$prop]);
    }

    /**
     * Obtiene un valor en la sesión. Si no existe,
     * retorna null.
     *
     * @param $prop
     * @return mixed|null
     */
    public static function get($prop)
    {
        if(self::has($prop)) {
            return $_SESSION[$prop];
        }
        return null;
    }
}