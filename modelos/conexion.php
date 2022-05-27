

<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=us-cdbr-east-05.cleardb.net;dbname=heroku_7e1d733973ac94e",
			            "bcc24b0b0aff61",
			            "c7549968");

		$link->exec("set names utf8");

		return $link;

	}

}