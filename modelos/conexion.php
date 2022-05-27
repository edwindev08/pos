

<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=us-cdbr-east-05.cleardb.net;dbname=heroku_ca100350e92d663",
			            "b48548ca76ce24",
			            "847ba98a");

		$link->exec("set names utf8");

		return $link;

	}

}

