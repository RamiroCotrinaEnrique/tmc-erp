<?php

$item = null;
$valoe = null;

$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

$arrayClientes = array();
$arraylistaClientes = array();
$sumaTotalClientes = array();

foreach ($ventas as $key => $valueVentas) {

    foreach ($clientes as $key => $valueClientes) {

        if($valueClientes["cli_id"] == $valueVentas["ven_id_cliente"]){
            #Capturamos los Clientes en un array
            array_push($arrayClientes, $valueClientes["cli_nombre"]);
            #Capturamos las nombres y los valores netos en un mismo array
            $arraylistaClientes = array($valueClientes["cli_nombre"] => $valueVentas["ven_neto"]);
            #Sumamos los netos de cada vendedor
            foreach ($arraylistaClientes as $key => $value) {
                $sumaTotalClientes[$key] += $value;
            }
        }
    }
}

#Evitamos repetir nombre
$noRepetirNombres = array_unique($arrayClientes);

//var_dump($noRepetirNombres);
//var_dump($sumaTotalClientes);

?>


<!-- BAR CHART -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Clientes</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="barChart2"
                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<script>
$(function() {

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#barChart2').get(0).getContext('2d')

    var areaChartData = {
        labels: [
            <?php
                foreach ($noRepetirNombres as $value) { 
                   // var_dump($value);
                    echo '"' . $value. '",'; 
                };
            ?>
        ],
        datasets: [{
            label: 'Total de Compras',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [
                <?php
                foreach ($noRepetirNombres as $value) { 
                    echo $sumaTotalClientes[$value] . ','; 
                }; 
            ?>                
            ]
        }]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart2').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)

    // Aquí solo mantenemos el primer conjunto de datos
    barChartData.datasets = [barChartData.datasets[0]];

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    }

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    })
})
</script>