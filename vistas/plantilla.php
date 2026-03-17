<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Sistema ERP | Reparto </title>
    <link rel="icon" href="vistas/img/plantilla/icono-blanco.png">

    <!-- REQUIRED CSS -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="vistas/plugins/fontawesome-free/css/all.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="vistas/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="vistas/plugins/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="vistas/dist/css/adminlte.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="vistas/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="vistas/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="vistas/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="vistas/plugins/daterangepicker/daterangepicker.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="vistas/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="vistas/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="vistas/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="vistas/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="vistas/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="vistas/plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="vistas/plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="vistas/dist/css/adminlte.min.css">
     <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="vistas/plugins/iCheck/all.css">
     <!-- Daterange picker -->
     <link rel="stylesheet" href="vistas/plugins/bootstrap-daterangepicker/daterangepicker.css">
       <!-- Morris chart -->
     <link rel="stylesheet" href="vistas/plugins/morris.js/morris.css"> 
    <!-- JQVMap -->
    <link rel="stylesheet" href="vistas/plugins/jqvmap/jqvmap.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="vistas/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="vistas/plugins/summernote/summernote-bs4.min.css">


     <!-- ESTILOS PROPIOS -->
    <link rel="stylesheet" href="vistas/css/plantilla.css">
    <link rel="stylesheet" href="vistas/css/empleados.css">


   <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="vistas/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="vistas/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="vistas/dist/js/adminlte.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="vistas/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="vistas/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="vistas/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vistas/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="vistas/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vistas/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="vistas/plugins/jszip/jszip.min.js"></script>
    <script src="vistas/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="vistas/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="vistas/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="vistas/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="vistas/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- Select2 -->
    <script src="vistas/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="vistas/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="vistas/plugins/moment/moment.min.js"></script>
    <script src="vistas/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="vistas/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="vistas/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="vistas/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="vistas/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="vistas/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="vistas/plugins/dropzone/min/dropzone.min.js"></script>
    <!-- SweetAlert 2 -->
    <script src="vistas/plugins/sweetalert02/sweetalert2.all.js"></script>
      <!-- jQuery Number -->
    <script src="vistas/plugins/jquery-number/jquerynumber.min.js"></script>
      <!-- iCheck 1.0.1 -->
    <script src="vistas/plugins/icheck/icheck.min.js"></script>
    <!-- InputMask -->
    <script src="vistas/plugins/moment/moment.min.js"></script>
    <script src="vistas/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- daterangepicker http://www.daterangepicker.com/-->
    <script src="vistas/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- jquery-validation -->
    <script src="vistas/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="vistas/plugins/jquery-validation/additional-methods.min.js"></script>
    
    <!-- Morris.js charts http://morrisjs.github.io/morris.js/
    <script src="vistas/plugins/raphael/raphael.min.js"></script>
    <script src="vistas/plugins/morris.js/morris.min.js"></script>-->

    <!-- ChartJS -->
    <script src="vistas/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline 
    <script src="vistas/plugins/sparklines/sparkline.js"></script>
    -->

    <!-- JQVMap -->
    <script src="vistas/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="vistas/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="vistas/plugins/jquery-knob/jquery.knob.min.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="vistas/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>

    <!-- Summernote -->
    <script src="vistas/plugins/summernote/summernote-bs4.min.js"></script>

    <!-- overlayScrollbars -->
    <script src="vistas/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <!-- AdminLTE for demo purposes -->

    <!-- AdminLTE dashboard demo (This is only for demo purposes)  
    <script src="vistas/dist/js/pages/dashboard.js"></script>
    -->
    <!-- bs-custom-file-input -->
    <script src="vistas/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

</head>
<?php
if(!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] != "ok"){ 
    echo '<body class="hold-transition  sidebar-mini login-page">';
} else {
    echo '<body class="hold-transition  sidebar-mini">';
}
    //echo '<body class="hold-transition sidebar-mini login-page">'; PARA COLAPCE AGREGAR:  sidebar-collapse
    if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"){ 
       // echo '<body class="hold-transition sidebar-mini">';
    // <!-- * * Start wrapper -->
    echo '<div class="wrapper">'; 

    //<!-- Contenido Navbar  -->
    include 'modulos/estructura/navbar.php';  
    //<!-- /.Contenido Navbar  -->

    //<!-- Contenido Sidebar  -->
    include 'modulos/estructura/sidebar.php'; 
    //<!-- /.Contenido Sidebar  -->

    //<!-- Content Wrapper. Contains page content -->
    //CONTENIDO
        if(isset($_GET["ruta"])){
            if($_GET["ruta"] == "inicio" || 
                $_GET["ruta"] == "usuarios" ||
                $_GET["ruta"] == "centro-costo" ||
                $_GET["ruta"] == "empresas" ||
                $_GET["ruta"] == "vehiculos" ||
                $_GET["ruta"] == "sig-opt" ||  
                $_GET["ruta"] == "areas" ||  
                $_GET["ruta"] == "cargos" ||  
                $_GET["ruta"] == "empleados" || 
                $_GET["ruta"] == "movimiento-caja" || 
                $_GET["ruta"] == "salir"){          
            include "modulos/".$_GET["ruta"].".php";          
            }else{          
                include "modulos/404.php";          
                }          
            }else{          
                include "modulos/inicio.php";         
            }     
    //<!-- /.content-wrapper -->

    include 'modulos/estructura/footer.php'; 

    echo '</div>'; // <!-- ./wrapper -->
    }else{
        include "modulos/login.php";    
    }

    ?>

<script src="vistas/js/plantilla.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/centrocostos.js"></script>
<script src="vistas/js/empresas.js"></script>
<script src="vistas/js/vehiculos.js"></script>
<script src="vistas/js/opts.js"></script>
<script src="vistas/js/areas.js"></script>
<script src="vistas/js/cargos.js"></script>
<script src="vistas/js/empleados.js"></script>


</body>

</html>