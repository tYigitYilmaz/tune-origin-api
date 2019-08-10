<?php
//include_once (dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."index.php");
//include_once (BASE_DIR.'config/db1.php');
//include_once (dirname(__DIR__).'/config/db1.php');
namespace Core;

class DB
{
    private static $writeDBConnection;
    private static $readDBConnection;
    public static $db_host = DB_HOST;
    public static $db_name = DB_NAME;
    public static $db_user = DB_USER;
    public static $db_pass = DB_PASS;

    public static function connectWriteDB() {
        if(self::$writeDBConnection === null) {
            self::$writeDBConnection = new PDO('mysql:host='.self::$db_host.';dbname='.self::$db_name.';charset=utf8', self::$db_user, self::$db_pass);
            self::$writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        return self::$writeDBConnection;
    }

    public static function connectReadDB() {
        if(self::$readDBConnection === null) {
            self::$readDBConnection = new PDO('mysql:host='.self::$db_host.';dbname='.self::$db_name.';charset=utf8', self::$db_user, self::$db_pass);
            self::$readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        return self::$readDBConnection;
    }
}
