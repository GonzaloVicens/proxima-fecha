<?php

/**
 * Clase Autenticar
 *
 */


namespace Proyecto\Auth;

use Proyecto\Model\Usuario;
use Proyecto\Core\App;

use Proyecto\DB\DBConnection;

class Autenticar
{
    /**
     * @param $usu
     * @param $pass
     * @return bool
     *
     * Chequea los datos del usuario
     *
     *
     * Devuelve Ok si los parámetros son correctos o false en caso contrario
     *
     */

    public static function login($usu, $pass)
    {
        $usuario = Usuario::buscarPorUsuario($usu);

        if($usuario)
        {
            if( $pass == $usuario->getPassword())
            {
                self::logUser($usuario);
                return true;
            } else {
            return false;
            }
        }else{
            return false;
        }
    }

    /**
     * @param $usuario
     */
    private static function logUser($usuario)
    {
        $_SESSION['user'] = $usuario;
    }

    /**
     * Quita o desprende el objeto Usuario de $_SESSION
     */
    public static function logout()
    {
        unset($_SESSION['user']);
    }

    /**
     * @return mixed
     */
    public static function getUser()
    {
        return $_SESSION['user'];
    }

    /**
     * @return bool
     */
    public static function userLogged()
    {
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }

}