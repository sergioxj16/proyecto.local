<?php
namespace sergio\Core;

use sergio\app\database\Connection;
use sergio\app\exceptions\AppException;


class App
{
    /**
     * @var array
     */
    private static $container = [];

    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public static function bind(string $key, $value)
    {
        static::$container[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws AppException
     */
    public static function get(string $key)
    {
        if (!array_key_exists($key, static::$container))
            throw new AppException("No se ha encontrado la clave $key en el contenedor");
        return static::$container[$key];
    }

    /**
     * @return PDO
     */
    public static function getConnection()
    {
        try {
            $config = static::get('config');
        } catch (AppException $e) {
            throw new AppException("Error al obtener la configuración: " . $e->getMessage());
        }

        if (!isset($config['database'])) {
            throw new AppException("La configuración de la base de datos no está definida.");
        }

        if (!array_key_exists('connection', static::$container)) {
            static::$container['connection'] = Connection::make();
        }

        return static::$container['connection'];
    }



}
