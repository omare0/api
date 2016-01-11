<?php

	$base = "mysql:host=localhost;dbname=omarecom_restaurantesmb";

	try {
	    $conn = new PDO($base, 'omarecom_forge', '4EUCBTzemcC1mTHCE1mn');
	} catch (PDOException $e) { echo $e; }

	$seleccionar_restaurantes = $conn->prepare("SELECT foto FROM restaurantes_internacionales;");
	$seleccionar_restaurantes->execute();

	$restaurantes = $seleccionar_restaurantes->fetchAll(PDO::FETCH_ASSOC);

	foreach ($restaurantes as $fotos) {
		echo 'curl -o ' . $fotos['foto'] . ' "https://api.guiarestaurantesmb.com/img/' . str_replace(" ", "%20", $fotos['foto']) . '"<br>';
	}

?>