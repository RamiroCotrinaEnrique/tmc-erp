<?php

$item = null;
$valor = null;
$orden = "pro_ventas";

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

//var_dump($productos);

$colores = array("red","green","yellow","aqua","purple","blue","cyan","magenta","orange","gold");

$totalVentas = ControladorProductos::ctrMostrarSumaVentas();

//var_dump($totalVentas);


?>


<div class="card">
    <div class="card-header">
        <h3 class="card-title">Productos más vendidos</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
                <ul class="chart-legend clearfix">
                    <?php

                    for($i = 0; $i < 10; $i++){

                    echo ' <li><i class="far fa-circle text-'.$colores[$i].'"></i> '.$productos[$i]["pro_descripcion"].'</li>';

                    }     

                ?>

                </ul>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer p-0">
        <ul class="nav nav-pills flex-column">

            <?php

            for($i = 0; $i <5; $i++){

                echo '<li class="nav-item">
                    
                    <a href="#" class="nav-link">

                    <img src="'.$productos[$i]["pro_imagen"].'" class="img-thumbnail" width="60px" style="margin-right:10px"> 
                    '.$productos[$i]["pro_descripcion"].'

                    <span class="float-right text-'.$colores[$i].'">   
                    '.ceil($productos[$i]["pro_ventas"]*100/$totalVentas["total"]).'%
                    </span>
                        
                    </a>

                    </li>';
            }

        ?>

        </ul>
    </div>
    <!-- /.footer -->
</div>
<!-- /.card -->

<script>
//-------------
// - PIE CHART -
//-------------
// Get context with jQuery - using jQuery's .get() method.
var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
var pieData = {
    labels: [
        <?php
            for ($i = 0; $i < 10; $i++) {
                echo '"' . $productos[$i]["pro_descripcion"] . '"';
                if ($i < 9) echo ', '; // Agregar coma excepto en el último elemento
            }
            ?>
    ],
    datasets: [{
        data: [
            <?php
                for ($i = 0; $i < 10; $i++) {
                    //echo ceil($productos[$i]["pro_ventas"] * 100 / $totalVentas["total"]).'%';
                    echo '"' . $productos[$i]["pro_ventas"] . '"';

                    if ($i < 9) echo ', '; // Agregar coma excepto en el último elemento
                }
                ?>
        ],
        backgroundColor: [
            <?php
                for ($i = 0; $i < 10; $i++) {
                    echo '"' . $colores[$i] . '"';
                    if ($i < 9) echo ', '; // Agregar coma excepto en el último elemento
                }
                ?>
        ]
    }]
}
var pieOptions = {
    legend: {
        display: false
    }
}
// Create pie or douhnut chart
// You can switch between pie and douhnut using the method below.
// eslint-disable-next-line no-unused-vars
var pieChart = new Chart(pieChartCanvas, {
    type: 'doughnut',
    data: pieData,
    options: pieOptions
})

//-----------------
// - END PIE CHART -
//-----------------
</script>