<?php

use Dotenv\Dotenv;

require_once "Conexion.php";
require ".secret.php";
require_once realpath(__DIR__ . '/vendor/autoload.php');
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

class BitacoraConnecion
{
    private $connection;
    public function __construct()
    {
        $this->connection = new Conexion(
            $_ENV['DB_HOST'], 
            $_ENV['DB_DATABASE'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD'],
            $_ENV['DB_SCHEMA']
        );
    }

    public function getBitacoraConnection()
    {
        return $this->connection;
    }

    public static function getConnectionString()
    {
        return "host=".$_ENV['DB_HOST']. " dbname=".$_ENV['DB_DATABASE'] ." user=".$_ENV['DB_USER']. " password=".$_ENV['DB_PASSWORD'].", options='--client_encoding=UTF8'";
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
?>