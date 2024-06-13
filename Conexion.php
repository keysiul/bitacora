<?php

	class Conexion{
		private $conexion;
		public function __construct($server, $bd, $user, $password, $schema){
			$this->conexion=pg_connect("host=$server dbname=$bd user=$user password=$password options='--client_encoding=UTF8'"); 
			if(!$this->conexion){
				echo "Connection error";
				die("Conection error");
			}

			$selBD = pg_query($this->conexion,"set search_path to $schema");

			if(!$selBD){
				die("Error accessing the database");
			}
		}

		public function getCon(){
			return $this->conexion;
		}

		public function execute($query){
			return pg_query($this->conexion,$query);
		}

		public function closeConection()
		{
			pg_close($this->conexion);
		}
	}

?>