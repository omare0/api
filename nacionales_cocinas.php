<?php

    session_start();

    if (!isset($_SESSION['usuario_usuario'])) {

        header("Location: login");

    } else {

        include_once 'config.php';

        if (isset($_GET['eliminar'])) {
            
            $eliminar = $conn->prepare("DELETE FROM cocinas WHERE id = :id;");
            $eliminar->bindParam(":id", $_GET['eliminar']);
            $eliminar->execute();

            $elimina_mensaje = 1;

            header("Location: nacionales_cocinas");
        }

        $nacionales = $conn->prepare("SELECT * FROM cocinas;");
        $nacionales->execute();

        $restaurantes_nacionales = $nacionales->fetchAll();

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
    <link href=" bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href=" bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href=" bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href=" bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href=" dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href=" bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                    <h1 class="page-header">Cocinas Nacionales</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="agregar_cocina" class="btn btn-primary">Agregar Cocina <i class="fa fa-plus fa-fw"></i></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th class="center">Nombre</th>
                                            <th class="center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($restaurantes_nacionales as $restaurante_nacional): ?>
                                        <tr class="even gradeC">
                                            <td class="center"><?php echo $restaurante_nacional['id'] ?></td>
                                            <td class="center"><?php echo utf8_encode($restaurante_nacional['cocina']) ?></td>
                                            <td class="center">
                                                <a href="editar_cocina/<?php echo $restaurante_nacional['id'] ?>/" class="btn btn-warning"><i class="fa fa-pencil fa-tw"></i> Editar</a>
                                                <a href="nacionales_cocinas?eliminar=<?php echo $restaurante_nacional['id'] ?>" class="btn btn-danger"><i class="fa fa-times fa-tw"></i> Eliminar</a>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src=" bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src=" bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src=" bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src=" bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src=" bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src=" dist/js/sb-admin-2.js"></script>

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
