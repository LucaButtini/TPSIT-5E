<?php

require_once 'func.php';
class DbConn
{
    private static PDO $db;

    public static function getDB($conf):PDO
    {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO($conf['dsn'], $conf['username'], $conf['password'], $conf['options']);
            } catch (PDOException $e) {
                logError($e);
            }
        }
        return self::$db;
    }
}