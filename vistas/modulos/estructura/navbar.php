        <!-- Navbar -->       
        <nav class="main-header navbar navbar-expand navbar-danger navbar-dark">
            
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">

                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-cog"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                            <?php 
                            if ($_SESSION["usu_foto"] != "") {
                                echo '<img src="'.$_SESSION["usu_foto"].'" class="img-size-50 mr-3 img-circle">';
                            } else{
                                echo '<img src="vistas/img/usuarios/default/anonymous.png" class="img-size-50 mr-3 img-circle">';
                            }
                            ?>
                                
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        <?php echo $_SESSION["usu_nombre"] ;?>
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm"> <?php echo $_SESSION["usu_perfil"] ;?> </p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 
                                    <?php
                                        $tiempo_conectado = time() - $_SESSION['tiempo_ingreso']; // Tiempo en segundos
                                        // Convertir a horas, minutos y segundos
                                        $horas = floor($tiempo_conectado / 3600);
                                        $minutos = floor(($tiempo_conectado % 3600) / 60);
                                        $segundos = $tiempo_conectado % 60; 
                                        echo "Tiempo conectado: " . $horas . ":" . $minutos . ":" . $segundos ;
                                    ?>
                                    </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
            
                        <div class="dropdown-divider"></div>
                        <a href="salir" class="dropdown-item dropdown-footer">Cerrar sesión</a>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
