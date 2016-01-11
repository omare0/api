<?php

    session_start();

    date_default_timezone_set('America/Mexico_City');

    if (!isset($_SESSION['usuario_usuario'])) {
        header("Location: login");
    } else {

        include_once 'config.php';

        $editar_zona = $conn->prepare("UPDATE zonas SET zona = :zona, updated_at = :updated_at WHERE id = :id;");
        $editar_zona->bindParam(":zona", $nombre_zona);
        $editar_zona->bindParam(":updated_at", $updated_at);
        $editar_zona->bindValue(":id", $_GET['id_zona']);

        if (isset($_POST['editar'])) {

            $nombre_zona = $_POST['nombre_zona'];
            $updated_at = date("Y-m-d H:i:s");

            $editar_zona->execute();
            
        }

        $seleccionar_restaurantes = $conn->prepare("SELECT * FROM restaurantes JOIN direcciones ON restaurantes.id = direcciones.restaurante_id JOIN cocinas ON restaurantes.cocina_id = cocinas.id WHERE restaurantes.id = :id_restaurante");
        $seleccionar_restaurantes->bindParam(":id_restaurante", $_GET['id_restaurante']);
        $seleccionar_restaurantes->execute();

        $restaurante = $seleccionar_restaurantes->fetchObject();

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
    <link href="http://api.omare.com.mx/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="http://api.omare.com.mx/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="http://api.omare.com.mx/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="http://api.omare.com.mx/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="http://api.omare.com.mx/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="http://api.omare.com.mx/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                    <h1 class="page-header">Editar Restaurante</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <?php if ($editar_zona->rowCount() > 0): ?>
                    <div class="alert alert-success text-center">
                        La zona <b><?php echo $nombre_zona; ?></b> fue editada exitosamente.
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
    <script src="http://api.omare.com.mx/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="http://api.omare.com.mx/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="http://api.omare.com.mx/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="http://api.omare.com.mx/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="http://api.omare.com.mx/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="http://api.omare.com.mx/dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>

</body>

</html>
