
<?php

$item = null;
$valor = null; 

$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
$totalUsuarios = count($usuarios);

$empresas = ControladorEmpresas::ctrMostrarEmpresas($item, $valor);
$totalEmpresas = count($empresas);

$empleados = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);
$totalEmpleados = count($empleados);

$areas = ControladorAreas::ctrMostrarAreas($item, $valor);
$totalAreas = count($areas);

$cargos = ControladorCargos::ctrMostrarCargos($item, $valor);
$totalCargos = count($cargos);

$centroCostos = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor);
$totalCentroCostos = count($centroCostos);




?>


<!-- Small boxes (Stat box) -->
<div class="row">

<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
        <div class="inner">
            <h3><?php echo number_format($totalUsuarios); ?></h3>
            <p>Usuarios</p>
        </div>
        <div class="icon">
            <i class="ion-person-stalker"></i>
        </div>
        <a href="usuarios" class="small-box-footer"> Más información <i
                class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->

<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
        <div class="inner">
            <h3><?php echo number_format($totalEmpresas); ?></h3>
            <p>Empresas</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="empresas" class="small-box-footer"> Más información <i
                class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->

<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
        <div class="inner">
            <h3><?php echo number_format($totalEmpleados); ?></h3>
            <p>Empleados</p>
        </div>
        <div class="icon">
            <i class="ion-person-stalker"></i>
        </div>
        <a href="empleados" class="small-box-footer"> Más información <i
                class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->

<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
        <div class="inner">
            <h3><?php echo number_format($totalAreas); ?></h3>
            <p>Áreas</p>
        </div>
        <div class="icon">
            <i class="ion-clipboard"></i>
        </div>
        <a href="areas" class="small-box-footer"> Más información <i
                class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->

<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
        <div class="inner">
            <h3><?php echo number_format($totalCargos); ?></h3>
            <p>Cargos</p>
        </div>
        <div class="icon">
            <i class="ion-clipboard"></i>
        </div>
        <a href="cargos" class="small-box-footer"> Más información <i
                class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->


<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
        <div class="inner">
            <h3><?php echo number_format($totalCentroCostos); ?></h3>
            <p>Centros de Costo</p>
        </div>
        <div class="icon">
            <i class="ion ion-clipboard"></i>
        </div>
        <a href="centro-costos" class="small-box-footer"> Más información <i
                class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->

<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
        <div class="inner">
            <h3><?php echo number_format($totalEmpleados); ?></h3>
            <p>Empleados</p>
        </div>
        <div class="icon">
            <i class="ion-person-stalker"></i>
        </div>
        <a href="empleados" class="small-box-footer"> Más información <i
                class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>

<!-- ./col -->

</div>