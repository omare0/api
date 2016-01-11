<?php

    session_start();

    date_default_timezone_set('America/Mexico_City');

    if (!isset($_SESSION['usuario_usuario'])) {
        header("Location: login");
    } else {

        include_once 'config.php';

        $editar_plan = $conn->prepare("UPDATE planes SET plan = :plan, icon = :icon, updated_at = :updated_at WHERE id = :id;");
        $editar_plan->bindParam(":plan", $nombre_plan);
        $editar_plan->bindParam(":icon", $icon_plan);
        $editar_plan->bindParam(":updated_at", $updated_at);
        $editar_plan->bindValue(":id", $_GET['id_plan']);

        if (isset($_POST['editar'])) {

            $nombre_plan = $_POST['nombre_plan'];
            $icon_plan = $_POST['icon_plan'];
            $updated_at = date("Y-m-d H:i:s");

            $editar_plan->execute();
            
        }

        $plan_info = $conn->prepare("SELECT * FROM planes WHERE id = :id;");
        $plan_info->bindParam(":id", $_GET['id_plan']);
        $plan_info->execute();

        $plan = $plan_info->fetchObject();

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
                    <h1 class="page-header">Editar Plan</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <?php if ($editar_plan->rowCount() > 0): ?>
                    <div class="alert alert-success text-center">
                        El Plan <b><?php echo $nombre_plan; ?></b> fue editado exitosamente.
                    </div>
                    <?php endif ?>
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                                <form action="" method="POST" autocomplete="off" role="form">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Nombre Plan </label>
                                        <input class="form-control" type="text" name="nombre_plan" value="<?php echo $plan->plan ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Icon Plan </label>
                                        <input class="form-control" type="text" name="icon_plan" value="<?php echo $plan->icon ?>" required />
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block" name="editar">Editar Plan</button>
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
