<?php
namespace Proyecto\DB;

/**
 * Clase en modo Singleton para manejo de la conexión.
 */
class DBConnection
{
	// Creamos una propiedad estática en donde almacenar la
	// conexión.
	private static $db = null;

	// Como la clase va a estar en modo Singleton, lo primero
	// que necesitamos es asegurarnos de que nadie pueda 
	// instanciar la clase.
	// Para esto, usamos un constructor privado.
	private function __construct() {}

	/**
	 * Abre la conexión a la base de datos.
	 */
	private static function openConnection()
	{
		// Definimos los valores de la conexión.
		// Normalmente estos valores salgan de un archivo
		// de configuración externo.

		$host = "localhost";
		$user = "root";
		$pass = "";
		$base = "DW4_PROXIMAFECHA";
/*
        $host = "localhost";
        $user = "p4000541_PFECHA";
        $pass = "mikaDA72zu";
        $base = "p4000541_PFECHA";
*/

        $dsn = "mysql:host=$host;dbname=$base;charset=utf8";

//		echo "DBConnection: Abriendo la conexión....<br>";

		try {
			self::$db = new \PDO($dsn, $user, $pass);
		} catch(\Exception $e) {
			//die("Error al conectar con la base de datos :(");
			echo "Error al conectar con la base de datos";
		}
	}

	// Creamos un método estático para poder pedir la conexión.
	// Como es static, no requiere de una instancia previa para
	// ser invocado.
	/**
	 * Retorna el objeto PDO en modo Singleton.
	 *
	 * @return \PDO
	 */
	public static function getConnection()
	{
		// Verificamos si tenemos o no la conexión.
		if(is_null(self::$db)) {
			// Abrimos la conexión.
			self::openConnection();
		}

		// Retornamos la conexión.
		return self::$db;
	}

    public static function getStatement($query)
    {
        try{
            $statement = self::getConnection()->prepare($query);
            return $statement;
        } catch (Exception $e) {
            echo "Hubo un problema con la base de datos, vuelva a intentarlo más tarde.";
            exit;
        }
    }

}