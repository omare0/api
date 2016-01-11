<?php

	header('Content-type: application/json');

	$base = "mysql:host=localhost;dbname=omarecom_restaurantesmb";

	try {
	    $conn = new PDO($base, 'omarecom_forge', '4EUCBTzemcC1mTHCE1mn');
	} catch (PDOException $e) { echo $e; }

	if (isset($_GET['id_restaurante'])) {
		$id_restaurante = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['id_restaurante']);

		$seleccionar_restaurantes = $conn->prepare("SELECT * FROM restaurantes_internacionales JOIN direcciones_internacionales ON restaurantes_internacionales.id = direcciones_internacionales.restaurante_internacional_id WHERE restaurantes_internacionales.id = :id_restaurante");
		$seleccionar_restaurantes->bindParam(":id_restaurante", $id_restaurante);
		$seleccionar_restaurantes->execute();

		$restaurantes = $seleccionar_restaurantes->fetchAll(PDO::FETCH_ASSOC);

		$control = 0;

		foreach ($restaurantes as $restaurante) {
			$restaurantes[$control]['nombre'] = utf8_encode($restaurante['nombre']);
			$restaurantes[$control]['descripcion'] = utf8_encode($restaurante['descripcion']);
			$restaurantes[$control]['direccion'] = utf8_encode($restaurante['direccion']);

			++$control;
		}

		print_r(json_encode($restaurantes));
	} else {
		$seleccionar_restaurantes = $conn->prepare("SELECT * FROM restaurantes_internacionales JOIN direcciones_internacionales ON restaurantes_internacionales.id = direcciones_internacionales.restaurante_internacional_id WHERE restaurantes_internacionales.ciudad_id = :ciudad_id");
		$seleccionar_restaurantes->bindParam(":ciudad_id", $_GET['ciudad_id']);
		$seleccionar_restaurantes->execute();

		$restaurantes = $seleccionar_restaurantes->fetchAll(PDO::FETCH_ASSOC);

		$control = 0;

		foreach ($restaurantes as $restaurante) {
			$restaurantes[$control]['nombre'] = utf8_encode($restaurante['nombre']);
			$restaurantes[$control]['descripcion'] = utf8_encode($restaurante['descripcion']);
			$restaurantes[$control]['direccion'] = utf8_encode($restaurante['direccion']);

			++$control;
		}

		print_r(json_encode($restaurantes));
	}

?>