<?php

class Database
{
    private static $dbName = 'pos_db';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'root';
    private static $dbPassword = '';


    private static $cont = null;



    public static function letsconnect()
    {
        if (null == self::$cont)
        {
            try{

                self::$cont = new PDO("mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbPassword);

            }
            catch(PDOException $e) {
                die($e->getMessage());
            }

            return self::$cont;

            function disconnect()
            {
                $cont = null;
                echo "Disconnected";
            }
        }
    }


}


?>