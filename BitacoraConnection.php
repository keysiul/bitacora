<?php
require_once "Conexion.php";
require ".secret.php";

/*
define("HOST",$dbhost);
define("DB",$dbdatabase);
define("USER",$dbuser);
define("PASSWORD",$dbpassword);
define("SCHEMA",$dbschema);
*/
class BitacoraConnecion
{
    private $connection;
    public function __construct()
    {
        $this->connection = new Conexion(HOST,DB,USER,PASSWORD,SCHEMA);
    }

    public function getBitacoraConnection()
    {
        return $this->connection;
    }

    public static function getConnectionString()
    {
        return "host=".HOST. " dbname=".DB ." user=".USER. " password=".PASSWORD.", options='--client_encoding=UTF8'";
    }
}

define("HOST",$dbhost);
define("DB",$dbdatabase);
define("USER",$dbuser);
define("PASSWORD",$dbpassword);
define("SCHEMA",$dbschema);

?>