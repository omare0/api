<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://api.omare.com.mx/">API Restaurantes</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo $_SESSION['usuario_usuario']; ?> <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="login?logout=1"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php if ($_SESSION['usuario_tipo'] === 'Administrador'): ?>
                        <li>
                            <a href="http://api.omare.com.mx/"><i class="fa fa-home fa-fw"></i> Inicio</a>
                        </li>
                        <?php endif ?>
                        <li>
                            <a href="#"><i class="fa fa-cutlery fa-fw"></i> Restaurantes Nacionales<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://api.omare.com.mx/nacionales_zonas">Zonas</a>
                                </li>
                                <li>
                                    <a href="http://api.omare.com.mx/nacionales_planes">Planes</a>
                                </li>
                                <li>
                                    <a href="http://api.omare.com.mx/nacionales_cocinas">Cocinas</a>
                                </li>
                                <li>
                                    <a href="http://api.omare.com.mx/restaurantes_nacionales">Restaurantes</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-globe fa-fw"></i> Restaurantes Internacionales<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://api.omare.com.mx/internacionales_region">Regiones</a>
                                </li>
                                <li>
                                    <a href="http://api.omare.com.mx/internacionales_ciudades">Ciudades</a>
                                </li>
                                <li>
                                    <a href="http://api.omare.com.mx/restaurantes_internacionales">Restaurantes</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php if ($_SESSION['usuario_tipo'] === 'Administrador'): ?>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Usuarios<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://api.omare.com.mx/listar_usuarios">Administrar Usuarios</a>
                                </li>
                                <li>
                                    <a href="http://api.omare.com.mx/nuevo_usuario">Nuevo Usuario</a>
                                </li>
                                <!--<li>
                                    <a href="http://api.omare.com.mx/log_usuarios">Log Usuarios</a>
                                </li>-->
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php endif ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>