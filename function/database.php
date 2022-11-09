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
        if (null == $cont)
        {
            try{

                $cont = new PDO("mysql:host=".$dbHost.";"."dbname=".$dbName, $dbUsername, $dbPassword);

            }
            catch(PDOException $e) {
                die($e->getMessage());
            }

            return $cont;

            function disconnect()
            {
                $cont = null;
                echo "Disconnected";
            }
        }
    }


}


?>