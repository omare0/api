<?php

	header('Content-type: application/json');

	$base = "mysql:host=localhost;dbname=omarecom_restaurantesmb";

	try {
	    $conn = new PDO($base, 'omarecom_forge', '4EUCBTzemcC1mTHCE1mn');
	} catch (PDOException $e) { echo $e; }

	$seleccionar_restaurantes = $conn->prepare("SELECT * FROM regiones");
	$seleccionar_restaurantes->execute();

	$restaurantes = $seleccionar_restaurantes->fetchAll(PDO::FETCH_ASSOC);

	$control = 0;

	foreach ($restaurantes as $restaurante) {
		$restaurantes[$control]['region'] = utf8_encode($restaurante['region']);

		++$control;
	}

	print_r(json_encode($restaurantes));

?>