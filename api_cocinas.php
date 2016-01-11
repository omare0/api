<?php

	header('Content-type: application/json');

	$base = "mysql:host=localhost;dbname=omarecom_restaurantesmb";

	try {
	    $conn = new PDO($base, 'omarecom_forge', '4EUCBTzemcC1mTHCE1mn');
	} catch (PDOException $e) { echo $e; }


	if (isset($_GET['promocion'])) {
		$promocion = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['promocion']);

		if (isset($_GET['cocina_id'])) {
			$cocina_id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['cocina_id']);

			$seleccionar_restaurantes = $conn->prepare("SELECT * FROM restaurantes WHERE cocina_id = :cocina_id AND promocion != '';");
			$seleccionar_restaurantes->bindParam(":cocina_id", $cocina_id);
			$seleccionar_restaurantes->execute();

			$restaurantes = $seleccionar_restaurantes->fetchAll(PDO::FETCH_ASSOC);

			$control = 0;

			foreach ($restaurantes as $restaurante) {
				$restaurantes[$control]['nombre'] = utf8_encode($restaurante['nombre']);
				$restaurantes[$control]['descripcion'] = utf8_encode($restaurante['descripcion']);
				$restaurantes[$control]['ideal_para'] = utf8_encode($restaurante['ideal_para']);
				$restaurantes[$control]['marco_recomienda'] = utf8_encode($restaurante['marco_recomienda']);
				$restaurantes[$control]['direccion'] = utf8_encode($restaurante['direccion']);
				$restaurantes[$control]['cocina'] = utf8_encode($restaurante['cocina']);
				$restaurantes[$control]['promocion'] = utf8_encode($restaurante['promocion']);


				++$control;
			}

			print_r(json_encode($restaurantes));
		}

	} else {

		if (isset($_GET['cocina_id'])) {
			$cocina_id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['cocina_id']);

			$seleccionar_restaurantes = $conn->prepare("SELECT * FROM restaurantes WHERE cocina_id = :cocina_id");
			$seleccionar_restaurantes->bindParam(":cocina_id", $cocina_id);
			$seleccionar_restaurantes->execute();

			$restaurantes = $seleccionar_restaurantes->fetchAll(PDO::FETCH_ASSOC);

			$control = 0;

			foreach ($restaurantes as $restaurante) {
				$restaurantes[$control]['nombre'] = utf8_encode($restaurante['nombre']);
				$restaurantes[$control]['descripcion'] = utf8_encode($restaurante['descripcion']);
				$restaurantes[$control]['ideal_para'] = utf8_encode($restaurante['ideal_para']);
				$restaurantes[$control]['marco_recomienda'] = utf8_encode($restaurante['marco_recomienda']);
				$restaurantes[$control]['direccion'] = utf8_encode($restaurante['direccion']);
				$restaurantes[$control]['cocina'] = utf8_encode($restaurante['cocina']);
				$restaurantes[$control]['promocion'] = utf8_encode($restaurante['promocion']);


				++$control;
			}

			print_r(json_encode($restaurantes));
		} else {
			$seleccionar_cocinas = $conn->prepare("SELECT * FROM cocinas");
			$seleccionar_cocinas->execute();

			$cocinas = $seleccionar_cocinas->fetchAll(PDO::FETCH_ASSOC);

			$control = 0;

			foreach ($cocinas as $cocina) {
				$cocinas[$control]['cocina'] = utf8_encode($cocina['cocina']);

				++$control;
			}

			print_r(json_encode($cocinas));
		}

	}

?>