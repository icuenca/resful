<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los clientes GET
$app->get('/api/clientes', function(Request $request, Response $response){
	$consulta = 'SELECT* FROM clientes';

	try{
		//Instanciar la base de datos
		$db = new db();

		//conexion
		$db = $db->conectar();
		$ejecutar = $db->query($consulta);
		$clientes = $ejecutar->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		//Exportar a formato json
		echo json_encode($clientes);

	}catch(PDOException $e){
		echo '{"error": {"text": '. $e->getMessage() . '}';
	}
});

//Obtener el cliente por id GET DETALLE
$app->get('/api/clientes/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');


	$consulta = "SELECT* FROM clientes WHERE id = $id ; ";

	try{
		//Instanciar la base de datos
		$db = new db();

		//conexion
		$db = $db->conectar();
		$ejecutar = $db->query($consulta);
		$cliente = $ejecutar->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		//Exportar a formato json un solo cliente
		echo json_encode($cliente);

	}catch(PDOException $e){
		echo '{"error": {"text": '. $e->getMessage() . '}';
	}
});

//Agregar un cliente POST
$app->post('/api/clientes/agregar', function(Request $request, Response $response){
	
	$nombre 	= $request->getParam('nombre');
	$apellidos 	= $request->getParam('apellidos');
	$telefono 	= $request->getParam('telefono');
	$email 		= $request->getParam('email');
	$direccion 	= $request->getParam('direccion');
	$ciudad 	= $request->getParam('ciudad');
	$estado 	= $request->getParam('estado');

	$consulta = "INSERT INTO clientes(nombre, apellidos, telefono, email, direccion, ciudad, estado)
				 VALUES(:nombre,:apellidos,:telefono,:email,:direccion,:ciudad,:estado);";

	try{
		//Instanciar la base de datos
		$db = new db();

		//conexion
		$db = $db->conectar();

		$stmt = $db->prepare($consulta);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':apellidos', $apellidos);
		$stmt->bindParam(':telefono', $telefono);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':direccion', $direccion);
		$stmt->bindParam(':ciudad', $ciudad);
		$stmt->bindParam(':estado', $estado);
		$stmt->execute();

		echo '{"notice": {"text": "Cliente agregado"}';

	}catch(PDOException $e){
		echo '{"error": {"text": '. $e->getMessage() . '}';
	}
});

//Actualizar un cliente PUT
$app->put('/api/clientes/actualizar/{id}', function(Request $request, Response $response){
	
	$id 		= $request->getAttribute('id');

	$nombre 	= $request->getParam('nombre');
	$apellidos 	= $request->getParam('apellidos');
	$telefono 	= $request->getParam('telefono');
	$email 		= $request->getParam('email');
	$direccion 	= $request->getParam('direccion');
	$ciudad 	= $request->getParam('ciudad');
	$estado 	= $request->getParam('estado');

	$consulta = "UPDATE clientes SET 
					nombre 		= :nombre,
					apellidos 	= :apellidos,
					telefono 	= :telefono,
					email 		= :email,
					direccion 	= :direccion,
					ciudad 		= :ciudad,
					estado 		= :estado 
					WHERE id = $id";

	try{
		//Instanciar la base de datos
		$db = new db();

		//conexion
		$db = $db->conectar();

		$stmt = $db->prepare($consulta);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':apellidos', $apellidos);
		$stmt->bindParam(':telefono', $telefono);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':direccion', $direccion);
		$stmt->bindParam(':ciudad', $ciudad);
		$stmt->bindParam(':estado', $estado);
		$stmt->execute();

		echo '{"notice": {"text": "Cliente actualizado"}';

	}catch(PDOException $e){
		echo '{"error": {"text": '. $e->getMessage() . '}';
	}
});

//Borrar el cliente por id DELETE
$app->delete('/api/clientes/borrar/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');


	$consulta = "DELETE FROM clientes WHERE id = $id ;";

	try{
		//Instanciar la base de datos
		$db = new db();

		//conexion
		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt->execute();
		$db = null;

		echo '{"notice": {"text": "Cliente borrado"}';

	}catch(PDOException $e){
		echo '{"error": {"text": '. $e->getMessage() . '}';
	}
});