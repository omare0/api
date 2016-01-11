<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    date_default_timezone_set('America/Mexico_City');

    if (!isset($_SESSION['usuario_usuario'])) {
        header("Location: login");
    } else {

        include_once 'config.php';

        $guardar_ciudad = $conn->prepare("INSERT INTO ciudades (region_id, nombre, created_at, updated_at) VALUES (:region_id, :ciudad, :created_at, :updated_at);");

        if (isset($_POST['crear'])) {
            $region_id = $_POST['region_ciudad'];
            $ciudad = $_POST['nombre_ciudad'];
            
            $guardar_ciudad->bindValue(":region_id", $region_id);
            $guardar_ciudad->bindParam(":ciudad", $ciudad);
            $guardar_ciudad->bindParam(":created_at", $created_at);
            $guardar_ciudad->bindParam(":updated_at", $updated_at);

            $created_at = date("Y-m-d H:i:s");
            $updated_at = date("Y-m-d H:i:s");

            $guardar_ciudad->execute();   
        }

        $regiones_sql = $conn->prepare("SELECT * FROM regiones;");
        $regiones_sql->execute();

        $regiones = $regiones_sql->fetchAll();

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
                    <h1 class="page-header">Agregar Ciudad</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <?php if ($guardar_ciudad->rowCount() > 0): ?>
                    <div class="alert alert-success text-center">
                        La ciudad <b><?php echo $ciudad; ?></b> fue creada exitosamente.
                    </div>
                    <?php endif ?>
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                                <form action="" method="POST" autocomplete="off" role="form">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Nombre Ciudad </label>
                                        <input class="form-control" type="text" name="nombre_ciudad" required />
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Región Ciudad </label>
                                        <select name="region_ciudad" id="" class="form-control" required>
                                        <?php foreach ($regiones as $region): ?>
                                            <option value="<?php echo $region['id'] ?>"><?php echo utf8_encode($region['region']) ?></option>
                                        <?php endforeach ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block" name="crear">Crear Ciudad</button>
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

</body>

</html>
