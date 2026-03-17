<?php

$item = null;
$valoe = null;

$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

$arrayVendedores = array();
$arraylistaVendedores = array();
$sumaTotalVendedores = array();

foreach ($ventas as $key => $valueVentas) {

    foreach ($usuarios as $key => $valueUsuarios) {

        if($valueUsuarios["usu_id"] == $valueVentas["ven_id_vendedor"]){
            #Capturamos los vendedores en un array
            array_push($arrayVendedores, $valueUsuarios["usu_nombre"]);
            #Capturamos las nombres y los valores netos en un mismo array
            $arraylistaVendedores = array($valueUsuarios["usu_nombre"] => $valueVentas["ven_neto"]);
            #Sumamos los netos de cada vendedor
            foreach ($arraylistaVendedores as $key => $value) {
                $sumaTotalVendedores[$key] += $value;
            }
        }
    }
}

#Evitamos repetir nombre
$noRepetirNombres = array_unique($arrayVendedores);

//var_dump($noRepetirNombres);
//var_dump($sumaTotalVendedores);

?>


<!-- BAR CHART -->
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Vendedores</h3>

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
            <canvas id="barChart"
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
    var areaChartCanvas = $('#barChart').get(0).getContext('2d')

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
            label: 'Total de Ventas',
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
                    echo $sumaTotalVendedores[$value] . ','; 
                }; 
            ?>                
            ]
        }]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
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