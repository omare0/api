<?php

	header('Content-type: application/json');

	$base = "mysql:host=localhost;dbname=omarecom_restaurantesmb";

	try {
	    $conn = new PDO($base, 'omarecom_forge', '4EUCBTzemcC1mTHCE1mn');
	} catch (PDOException $e) { echo $e; }

	$seleccionar_restaurantes = $conn->prepare("SELECT * FROM ciudades WHERE region_id = :region_id");
	$seleccionar_restaurantes->bindParam(":region_id", $_GET['region_id']);
	$seleccionar_restaurantes->execute();

	$restaurantes = $seleccionar_restaurantes->fetchAll(PDO::FETCH_ASSOC);

	$control = 0;

	foreach ($restaurantes as $restaurante) {
		$restaurantes[$control]['nombre'] = utf8_encode($restaurante['nombre']);

		++$control;
	}

	print_r(json_encode($restaurantes));

?>