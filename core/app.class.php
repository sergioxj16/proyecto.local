<?php
require_once __DIR__ . '/../src/exceptions/AppException.php';
require_once __DIR__ . '/../src/database/connection.class.php';

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
        if (!array_key_exists('connection', static::$container))
            $config = static::get('config');
        static::$container['connection'] = Connection::make();
        return static::$container['connection'];
    }
}
