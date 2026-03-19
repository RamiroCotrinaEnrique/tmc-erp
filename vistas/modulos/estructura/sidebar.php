<?php
require_once __DIR__ . '/../../../config/accesos.php';

$rutaActual = isset($_GET['ruta']) && $_GET['ruta'] !== '' ? $_GET['ruta'] : 'inicio';
$perfilActual = isset($_SESSION['usu_perfil']) ? $_SESSION['usu_perfil'] : '';
$sidebarNavClass = function ($rutaMenu) use ($rutaActual) {
    return $rutaActual === $rutaMenu ? 'nav-link active color-fondo-personalizado' : 'nav-link';
};
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="inicio" class="brand-link">
        <img src="vistas/img/plantilla/icono-blanco.png" alt="Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">
            TMC
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php 
                if ($_SESSION["usu_foto"] != "") {
                    echo '<img src="'.$_SESSION["usu_foto"].'" class="img-circle elevation-2">';
                } else{
                    echo '<img src="vistas/img/usuarios/default/anonymous.png" class="img-circle elevation-2">';
                }
            ?>


            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $_SESSION["usu_nombre"] ;?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <?php 

                if (tmcUsuarioPuedeAccederModulo($perfilActual, 'inicio')) { ?>

                <li class="nav-item">
                    <a href="inicio" class="<?php echo $sidebarNavClass('inicio'); ?>">
                        <i class="fa fa-home nav-icon"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                <?php } ?>

                <?php
                $tieneGestionSig = tmcUsuarioPuedeAccederModulo($perfilActual, 'sig-opt');
                if ($tieneGestionSig) {
                ?>
                <li class="nav-header">GESTIÓN SIG </li>
                <li class="nav-item">
                    <a href="sig-opt" class="<?php echo $sidebarNavClass('sig-opt'); ?>">
                        <i class="fa fa-th nav-icon"></i>
                        <p>OPT</p>
                    </a>
                </li>
                <?php } ?>

                <?php
                $tieneGestionMaster =
                    tmcUsuarioPuedeAccederModulo($perfilActual, 'usuarios') ||
                    tmcUsuarioPuedeAccederModulo($perfilActual, 'empresas') ||
                    tmcUsuarioPuedeAccederModulo($perfilActual, 'centro-costo');

                if ($tieneGestionMaster) {
                ?>
                <li class="nav-header">GESTIÓN MASTER</li>

                <?php if (tmcUsuarioPuedeAccederModulo($perfilActual, 'usuarios')) { ?>
                <li class="nav-item">
                    <a href="usuarios" class="<?php echo $sidebarNavClass('usuarios'); ?>">
                        <i class="fa fa-users nav-icon"></i>
                        <p>Usuarios</p>
                    </a>
                </li>
                <?php } ?>

                <?php if (tmcUsuarioPuedeAccederModulo($perfilActual, 'empresas')) { ?>
                <li class="nav-item">
                    <a href="empresas" class="<?php echo $sidebarNavClass('empresas'); ?>">
                        <i class="fa fa-building nav-icon"></i>
                        <p>Empresas</p>
                    </a>
                </li>
                <?php } ?>

                <?php if (tmcUsuarioPuedeAccederModulo($perfilActual, 'centro-costo')) { ?>
                <li class="nav-item">
                    <a href="centro-costo" class="<?php echo $sidebarNavClass('centro-costo'); ?>">
                        <i class="fa fa-building nav-icon"></i>
                        <p>Centro Costo</p>
                    </a>
                </li>
                <?php } ?>
                <?php } ?>

                <?php
                $tieneGestionHumana =
                    tmcUsuarioPuedeAccederModulo($perfilActual, 'areas') ||
                    tmcUsuarioPuedeAccederModulo($perfilActual, 'cargos') ||
                    tmcUsuarioPuedeAccederModulo($perfilActual, 'empleados');

                if ($tieneGestionHumana) {
                ?>
                <li class="nav-header">GESTIÓN HUMANA </li>

                <?php if (tmcUsuarioPuedeAccederModulo($perfilActual, 'areas')) { ?>
                <li class="nav-item">
                    <a href="areas" class="<?php echo $sidebarNavClass('areas'); ?>">
                        <i class="fa fa-th nav-icon"></i>
                        <p>Áreas</p>
                    </a>
                </li>
                <?php } ?>

                <?php if (tmcUsuarioPuedeAccederModulo($perfilActual, 'cargos')) { ?>
                <li class="nav-item">
                    <a href="cargos" class="<?php echo $sidebarNavClass('cargos'); ?>">
                        <i class="fa fa-th nav-icon"></i>
                        <p>Cargos</p>
                    </a>
                </li>
                <?php } ?>

                <?php if (tmcUsuarioPuedeAccederModulo($perfilActual, 'empleados')) { ?>
                <li class="nav-item">
                    <a href="empleados" class="<?php echo $sidebarNavClass('empleados'); ?>">
                        <i class="fa fa-users nav-icon"></i>
                        <p>Empleados</p>
                    </a>
                </li>
                <?php } ?>
                <?php } ?>

                <?php if (tmcUsuarioPuedeAccederModulo($perfilActual, 'movimiento-caja')) { ?>
                <li class="nav-header">GESTIÓN TESORERÍA</li>
                <li class="nav-item">
                    <a href="movimiento-caja" class="<?php echo $sidebarNavClass('movimiento-caja'); ?>">
                        <i class="fa fa-users nav-icon"></i>
                        <p>Movimientos Caja</p>
                    </a>
                </li>
                <?php } ?>

                <?php if (tmcUsuarioPuedeAccederModulo($perfilActual, 'vehiculos')) { ?>
                <li class="nav-header">GESTIÓN MATENIMIENTO </li>
                <li class="nav-item">
                    <a href="vehiculos" class="<?php echo $sidebarNavClass('vehiculos'); ?>">
                        <i class="fa fa-users nav-icon"></i>
                        <p>Vehículos</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="orden-servicio" class="<?php echo $sidebarNavClass('orden-servicio'); ?>">
                        <i class="fa fa-users nav-icon"></i>
                        <p>Orden de Servicio</p>
                    </a>
                </li>

                <?php } ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- MENU  
<li class="nav-item">
                    <a href="inicio" class="nav-link active">
                        <i class="fa fa-home nav-icon"></i>
                        <p>Inicio</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="usuarios" class="nav-link">
                        <i class="fa fa-user nav-icon"></i>
                        <p>Usuarios</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="proveedores" class="nav-link">
                        <i class="fa fa-th nav-icon"></i>
                        <p>Proveedores</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="categorias" class="nav-link">
                        <i class="fa fa-th nav-icon"></i>
                        <p>Categorías</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="productos" class="nav-link">
                        <i class="fa fa-th nav-icon"></i>
                        <p>Productos</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="clientes" class="nav-link">
                        <i class="fa fa-users nav-icon"></i>
                        <p>Clientes</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Ventas
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="ventas" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Administrar ventas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="crear-venta" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Crear venta</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reportes" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reporte de ventas</p>
                            </a>
                        </li>
                    </ul>
                </li>

                -->