<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    date_default_timezone_set('America/Mexico_City');

    if (!isset($_SESSION['usuario_usuario'])) {
        header("Location: login");
    } else {

        include_once 'config.php';

        $guardar_direccion = $conn->prepare("INSERT INTO direcciones (restaurante_id, direccion, telefono, web, latitud, longitud, created_at, updated_at) VALUES (:restaurante_id, :direccion, :telefono, :web, :latitud, :longitud, :created_at, :updated_at);");
        $guardar_direccion->bindParam(":restaurante_id", $restaurante_id);
        $guardar_direccion->bindParam(":direccion", $direccion);
        $guardar_direccion->bindParam(":telefono", $telefono);
        $guardar_direccion->bindParam(":web", $web);
        $guardar_direccion->bindParam(":latitud", $latitud);
        $guardar_direccion->bindParam(":longitud", $longitud);
        $guardar_direccion->bindParam(":created_at", $created_at);
        $guardar_direccion->bindParam(":updated_at", $updated_at);

        $guardar_restaurante = $conn->prepare("INSERT INTO restaurantes (cocina_id, plan_id, zona_id, nombre, nespresso, descripcion, calificacion_comida, calificacion_ambiente, calificacion_servicio, ideal_para, marco_recomienda, precio_promedio, promocion, foto, created_at, updated_at, higiene) VALUES (:cocina_id, :plan_id, :zona_id, :nombre, :nespresso, :descripcion, :calificacion_comida, :calificacion_ambiente, :calificacion_servicio, :ideal_para, :marco_recomienda, :precio_promedio, :promocion, :foto, :created_at, :updated_at, :higiene);");
        $guardar_restaurante->bindParam(":cocina_id", $cocina_id);
        $guardar_restaurante->bindParam(":plan_id", $plan_id);
        $guardar_restaurante->bindParam(":zona_id", $zona_id);
        $guardar_restaurante->bindParam(":nombre", $nombre);
        $guardar_restaurante->bindParam(":nespresso", $nespresso);
        $guardar_restaurante->bindParam(":descripcion", $descripcion);
        $guardar_restaurante->bindParam(":calificacion_comida", $calificacion_comida);
        $guardar_restaurante->bindParam(":calificacion_ambiente", $calificacion_ambiente);
        $guardar_restaurante->bindParam(":calificacion_servicio", $calificacion_servicio);
        $guardar_restaurante->bindParam(":ideal_para", $ideal_para);
        $guardar_restaurante->bindParam(":marco_recomienda", $marco_recomienda);
        $guardar_restaurante->bindParam(":precio_promedio", $precio_promedio);
        $guardar_restaurante->bindParam(":promocion", $promocion);
        $guardar_restaurante->bindParam(":foto", $foto);
        $guardar_restaurante->bindParam(":created_at", $created_at);
        $guardar_restaurante->bindParam(":updated_at", $updated_at);
        $guardar_restaurante->bindParam(":higiene", $higiene);

        if (isset($_POST['crear'])) {

            $cocina_id = $_POST['cocina_restaurante'];
            $plan_id_arr = $_POST['plan_restaurante'];
            $plan_id = '';
            foreach ($plan_id_arr as $plan_data) {
                if($plan_data > 0 && $plan_data < 10){
                    $plan_id .= '0'.$plan_data.',';
                } else {
                    $plan_id .= $plan_data.',';
                }
            }
            $zona_id = $_POST['zona_restaurante'];
            $nombre = utf8_decode($_POST['nombre_restaurante']);
            $descripcion = utf8_decode($_POST['descripcion_restaurante']);
            $calificacion_servicio = $_POST['cal_servicio_restaurant'];
            $calificacion_comida = $_POST['cal_comida_restaurant'];
            $calificacion_ambiente = $_POST['cal_ambiente_restaurant'];
            $ideal_para = utf8_decode($_POST['ideal_restaurante']);
            $marco_recomienda = utf8_decode($_POST['recomienda_restaurante']);
            $precio_promedio = $_POST['promedio_restaurante'];
            $promocion = utf8_decode($_POST['promocion_restaurante']);

            if (isset($_POST['nespresso_restaurante'])) {
                $nespresso = $_POST['nespresso_restaurante'];
            } else {
                $nespresso = 0;
            }

            if (isset($_POST['higiene_restaurante'])) {
                $higiene = $_POST['higiene_restaurante'];
            } else {
                $higiene = 0;
            }

            $direccion = utf8_decode($_POST['direccion_restaurante']);
            $telefono = $_POST['telefonos_restaurante'];
            $web = $_POST['web_restaurante'];
            $latitud = $_POST['latitud_restaurante'];
            $longitud = $_POST['longitud_restaurante'];
            
            $created_at = date("Y-m-d H:i:s");
            $updated_at = date("Y-m-d H:i:s");

            if (!empty($_FILES["foto_restaurante"])) {
                $myFile = $_FILES["foto_restaurante"];

                if ($myFile["error"] !== UPLOAD_ERR_OK) {
                    echo "<p>An error occurred.</p>";
                    exit;
                }

                // verify the file is a GIF, JPEG, or PNG
                $fileType = exif_imagetype($_FILES["foto_restaurante"]["tmp_name"]);
                $allowed = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);
                if (!in_array($fileType, $allowed)) {
                    echo 'file type is not permitted';
                } else {
                    // ensure a safe filename
                    $imagen_data = pathinfo($myFile["name"]);
                    $name = RandomString() . '_' . preg_replace ("/([^A-Za-z0-9\+_\-,]+)/", "_", limpiar($nombre)) . '.' . $imagen_data['extension'];

                    $foto = $name;

                    // don't overwrite an existing file
                    $i = 0;
                    $parts = pathinfo($name);
                    while (file_exists('img/' . $name)) {
                        $i++;
                        $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
                    }

                    // preserve file from temporary directory
                    $success = move_uploaded_file($myFile["tmp_name"],
                        'img/' . $name);
                    if (!$success) { 
                        echo "<p>Unable to save file.</p>";
                        exit;
                    }
                }

            }

            $guardar_restaurante->execute();
            $restaurante_id = $conn->lastInsertId();
            $guardar_direccion->execute();
        }

        $zonas_sql = $conn->prepare("SELECT * FROM zonas;");
        $zonas_sql->execute();

        $zonas = $zonas_sql->fetchAll();

        $planes_sql = $conn->prepare("SELECT * FROM planes;");
        $planes_sql->execute();

        $planes = $planes_sql->fetchAll();

        $cocinas_sql = $conn->prepare("SELECT * FROM cocinas;");
        $cocinas_sql->execute();

        $cocinas = $cocinas_sql->fetchAll();

    }

    function RandomString() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 6; $i++) {
            $randstring .= $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }

    function limpiar($String){
        $String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
        $String = str_replace(array('Á','À','Â','Ã','Ä'),"A",$String);
        $String = str_replace(array('Í','Ì','Î','Ï'),"I",$String);
        $String = str_replace(array('í','ì','î','ï'),"i",$String);
        $String = str_replace(array('é','è','ê','ë'),"e",$String);
        $String = str_replace(array('É','È','Ê','Ë'),"E",$String);
        $String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
        $String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"O",$String);
        $String = str_replace(array('ú','ù','û','ü'),"u",$String);
        $String = str_replace(array('Ú','Ù','Û','Ü'),"U",$String);
        $String = str_replace(array('[','^','´','`','¨','~',']'),"",$String);
        $String = str_replace("ç","c",$String);
        $String = str_replace("Ç","C",$String);
        $String = str_replace("ñ","n",$String);
        $String = str_replace("Ñ","N",$String);
        $String = str_replace("Ý","Y",$String);
        $String = str_replace("ý","y",$String);
        return $String;
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>API Restaurantes</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <?php include_once 'nav.php'; ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Agregar Restaurante</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <?php if ($guardar_restaurante->rowCount() > 0 && $guardar_direccion->rowCount() > 0): ?>
                    <div class="alert alert-success text-center">
                        El restaurante <b><?php echo utf8_encode($nombre); ?></b> fue creado exitosamente.
                    </div>
                    <?php endif ?>
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                                <form action="" method="POST" autocomplete="off" role="form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Zona </label>
                                        <select name="zona_restaurante" id="" class="form-control" required>
                                        <?php foreach ($zonas as $zona): ?>
                                            <option value="<?php echo $zona['id'] ?>"><?php echo utf8_encode($zona['zona']) ?></option>
                                        <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Plan </label>
                                        <div class="planes_restaurante">
                                            <select name="plan_restaurante[]" id="" class="form-control" required>
                                            <?php foreach ($planes as $plan): ?>
                                                <option value="<?php echo $plan['id'] ?>"><?php echo utf8_encode($plan['plan']) ?></option>
                                            <?php endforeach ?>
                                            </select>
                                            <button class="add_field_button btn btn-primary"> <i class="fa fa-plus"></i> </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Cocina </label>
                                        <select name="cocina_restaurante" id="" class="form-control" required>
                                        <?php foreach ($cocinas as $cocina): ?>
                                            <option value="<?php echo $cocina['id'] ?>"><?php echo utf8_encode($cocina['cocina']) ?></option>
                                        <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Nombre </label>
                                        <input type="text" name="nombre_restaurante" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Descripción </label>
                                        <textarea name="descripcion_restaurante" class="form-control" cols="30" rows="10" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="nespresso_restaurante" value="1">
                                        <label> Nespresso </label>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="higiene_restaurante" value="1">
                                        <label> Higiene </label>
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Calificación Comida </label>
                                        <input type="text" name="cal_comida_restaurant" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Calificación Ambiente </label>
                                        <input type="text" name="cal_ambiente_restaurant" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Calificación Servicio </label>
                                        <input type="text" name="cal_servicio_restaurant" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Ideal Para (Separados por punto y coma ";") </label>
                                        <textarea name="ideal_restaurante" class="form-control" cols="30" rows="10" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Marco Recomienda (Separados por punto y coma ";") </label>
                                        <textarea name="recomienda_restaurante" class="form-control" cols="30" rows="10" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Dirección </label>
                                        <textarea name="direccion_restaurante" class="form-control" cols="30" rows="10" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Latitud </label>
                                        <input type="text" name="latitud_restaurante" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Longitud </label>
                                        <input type="text" name="longitud_restaurante" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Teléfonos (Separados por ",") </label>
                                        <textarea name="telefonos_restaurante" class="form-control" cols="30" rows="10" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Página Web </label>
                                        <input type="text" name="web_restaurante" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Precio promedio por persona </label>
                                        <input type="text" name="promedio_restaurante" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label> Promoción </label>
                                        <textarea name="promocion_restaurante" class="form-control" cols="30" rows="10"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Foto </label>
                                        <input type="file" class="form-comtrol" name="foto_restaurante" required>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block" name="crear">Crear Restaurante</button>
                                </form>              
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>

    <script>
        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var wrapper         = $(".planes_restaurante"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID
           
            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(wrapper).append('<div><select name="plan_restaurante[]" id="" class="form-control" required><?php foreach ($planes as $plan): ?><option value="<?php echo $plan['id'] ?>"><?php echo utf8_encode($plan['plan']) ?></option><?php endforeach ?></select><button class="remove_field btn btn-danger"> <i class="fa fa-times"></i> </button>'); //add input box
                }
            });
           
            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent('div').remove(); x--;
            })
        });
    </script>

</body>

</html>
