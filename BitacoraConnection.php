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
    /**
     * Returns a string version of a pg_query_params query
     * @return string 
     */
    public function debugParamQuery(string $query, array $params) : string
    {
        $debug = preg_replace_callback( 
            '/\$(\d+)\b/',
            function($match) use ($params) { 
                $key=($match[1]-1); return ( is_null($params[$key])?'NULL':pg_escape_literal($params[$key]) ); 
            },
            $query);
        return $debug;
    }
}

define("HOST",$dbhost);
define("DB",$dbdatabase);
define("USER",$dbuser);
define("PASSWORD",$dbpassword);
define("SCHEMA",$dbschema);

?>