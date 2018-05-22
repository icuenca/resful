<?php

class db
{
	private $host 		= 'localhost';
	private $usuario 	= 'root';
	private $password 	= '1234567';
	private $base 		= 'misclientes';

	//VConectar a la BD
	public function conectar()
	{
		$conexion_mysql = "mysql:host=$this->host;dbname=$this->base";
		$conexionBD = new PDO($conexion_mysql, $this->usuario, $this->password);
		$conexionBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//Esta linea arregla la codificacion de caracteres utf8
		$conexionBD->exec("set names utf8");
		return $conexionBD;
	}
}