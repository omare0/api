<?php

    header('Content-type: application/json');

    $base = "mysql:host=localhost;dbname=omarecom_restaurantesmb";

    try {
        $conn = new PDO($base, 'omarecom_forge', '4EUCBTzemcC1mTHCE1mn');
    } catch (PDOException $e) { echo $e; }

    if (isset($_GET['promocion'])) {
        $promocion = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['promocion']);

        if (isset($_GET['plan_id'])) {
            if ($_GET['plan_id'] > 0 && $_GET['plan_id'] < 10) {
                $plan_id = '0' . preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['plan_id']);
            } else {
                $plan_id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['plan_id']);
            }

            $seleccionar_restaurantes = $conn->prepare("SELECT * FROM restaurantes WHERE plan_id LIKE :plan_id AND promocion != '';");
            $seleccionar_restaurantes->bindValue(":plan_id", "%$plan_id%", PDO::PARAM_STR);
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

        if (isset($_GET['plan_id'])) {
            if ($_GET['plan_id'] > 0 && $_GET['plan_id'] < 10) {
                $plan_id = '0' . preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['plan_id']);
            } else {
                $plan_id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['plan_id']);
            }

            $seleccionar_restaurantes = $conn->prepare("SELECT * FROM restaurantes WHERE plan_id LIKE :plan_id;");
            $seleccionar_restaurantes->bindValue(":plan_id", "%$plan_id%", PDO::PARAM_STR);
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
            $seleccionar_planes = $conn->prepare("SELECT * FROM planes");
            $seleccionar_planes->execute();

            $planes = $seleccionar_planes->fetchAll(PDO::FETCH_ASSOC);

            $control = 0;

            foreach ($planes as $plan) {
                $planes[$control]['plan'] = utf8_encode($plan['plan']);

                ++$control;
            }

            print_r(json_encode($planes));
        }

    }

?>