<?php

class Conexion{

	static public function conectar(){
        $server = "localhost";
        $user = "root";
        $password = "";
        $database = "pro_tmc"; 

		//PRODUCCUION
        //$user = "u732056592_erp";
        //$password = "CamposERP2026*/";
        //$database = "u732056592_erp"; 


		$link = new PDO("mysql:host=$server;dbname=$database", $user, $password);
		$link->exec("set names utf8");
		return $link;
	}
}