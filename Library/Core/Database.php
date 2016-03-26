<?php
/**
 * KK-Framework
 * Author: kookxiang <r18@ikk.me>
 */

namespace Core;

class Database extends \PDO
{
    private static $instance;

    /**
     * Initialize database config
     * @link http://php.net/manual/pdo.construct.php
     * @param string $dsn Data Source Name, contains the information required to connect to the database.
     * @param string $username Username for the DSN string
     * @param string $password Password for the DSN string
     * @param array $options A key=>value array of driver-specific connection options.
     * @throws Error
     */
    public static function initialize($dsn, $username = null, $password = null, $options = array())
    {
        if (self::$instance) {
            throw new Error('');
        }
        self::$instance = new Database($dsn, $username, $password, $options);
    }


    /**
     * Get current database connection
     * @return Database
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * Magic method: shorten code Database::getInstance()->xxx() to Database::_xxx()
     * @param $name string method name
     * @param $arguments array
     */
    public static function __callStatic($name, $arguments)
    {
        if ($name{0} == '_') {
            $name = substr($name, 1);
        }
        if (method_exists(self::$instance, $name)) {
            call_user_func_array(array(self::$instance, $name), $arguments);
        }
    }
}