
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> OPT</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Tablero Administrar OPT</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <button class="btn color-fondo-personalizado" data-toggle="modal"
                                data-target="#modalAgregarOpts">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar OPT </button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped tablas"> 

                                <thead>
                                    <tr style="text-align: center">
                                        <th style="width:10px">#</th>
                                        <th>Operación</th>
                                        <th>Placa</th>
                                        <th>Cliente</th>
                                        <th>Lugar</th>
                                        <th>Fecha</th>
                                        <th>Opservado</th> 
                                        <th>Evidencia 1</th> 
                                        <th>Evidencia 2</th> 
                                        <th>Ajustes</th>
                                    </tr>
                                </thead>
                                <tbody> 

                                    <?php 
                                            $item = null;
                                            $valor = null;
                                            $opts = ControladorOpts::ctrMostrarOpts($item, $valor);
                                                                                
                                            foreach ($opts as $key => $value) {
                                                $itemCentroCosto = "cenco_codigo";
			                                    $valorCentroCosto = $value["opt_cenco_codigo"]; 
			                                    $centro = ControladorCentroCostos::ctrMostrarCentroCostos($itemCentroCosto, $valorCentroCosto); 

                                                $itemVehiculo = "vehic_id";
			                                    $valorVehiculo = $value["opt_vehiculo_id"]; 
			                                    $vehiculo = ControladorVehiculos::ctrMostrarVehiculos($itemVehiculo, $valorVehiculo); 
                                                
                                                echo '
                                                <tr style="text-align: center">
                                                <td>'.($key+1).'</td>
                                                <td>'.$centro["cenco_codigo"].' - '.$centro["cenco_nombre"].'</td>                                                
                                                <td>'.$vehiculo["vehic_placa"].'</td>                                                
                                                <td>'.$value["opt_cliente"].'</td>                                                
                                                <td>'.$value["opt_lugar"].'</td>                                                
                                                <td>'.$value["opt_fecha"].'</td>                                                
                                                <td>'.$value["opt_observado"].'</td>';
                                                if ($value["opt_evidencia1"] != "" || $value["opt_evidencia2"] != "") {
                                                    echo '<td><img src="' . $value["opt_evidencia1"] . '" class="img-thumbnail verImagenModal" width="40px" data-toggle="modal" data-target="#modalImagen" data-src="' . $value["opt_evidencia1"] . '"></td>';

                                                    echo '<td><img src="' . $value["opt_evidencia2"] . '" class="img-thumbnail verImagenModal" width="40px" data-toggle="modal" data-target="#modalImagen" data-src="' . $value["opt_evidencia2"] . '"></td>'; 
                
                                                    } else {
                                                        echo '<td><img src="vistas/img/sig/opt/default/no-image.png" class="img-thumbnail verImagenModal" width="40px" data-toggle="modal" data-target="#modalImagen" data-src="vistas/img/sig/opt/default/no-image.png"></td>';

                                                        echo '<td><img src="vistas/img/sig/opt/default/no-image.png" class="img-thumbnail verImagenModal" width="40px" data-toggle="modal" data-target="#modalImagen" data-src="vistas/img/sig/opt/default/no-image.png"></td>';
                                                    }
                                                echo'                                               
                                                <td>
                                                <div class="btn-group">  
                                                    <button class="btn btn-primary btnImprimirOpt" codigoOpt="'.$value["opt_id"].'" > <i class="fa fa-print"></i> </button>                        
                                                    <button class="btn btn-warning btnEditarOpt" idOpt="'.$value["opt_id"].'" data-toggle="modal" data-target="#modalEditarOpt"> <i class="fa fa-pencil"></i> </button>';
                                                if($_SESSION["usu_perfil"] == "Administrador"){ 
                                                        echo '
                                                    <button class="btn btn-danger btnEliminarOpt" idOpt="'.$value["opt_id"].'"> <i class="fa fa-trash-o" aria-hidden="true"></i> </button>';
                                            }
                                                echo'
                                                </div>  
                                                </td>
                                            </tr>  ';

                                            }
                                            ?>
                                </tbody>
                                <tfoot>
                                    <tr style="text-align: center">
                                        <th style="width:10px">#</th>
                                        <th>Operación</th>
                                        <th>Placa</th>
                                        <th>Cliente</th>
                                        <th>Lugar</th>
                                        <th>Fecha</th>
                                        <th>Opservado</th> 
                                        <th>Evidencia 1</th> 
                                        <th>Evidencia 2</th> 
                                        <th>Ajustes</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<!-- Modal de imagen -->
<div class="modal fade" id="modalImagen" tabindex="-1" role="dialog" aria-labelledby="modalImagenLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <img src="" id="imagenModal" class="img-fluid" alt="Evidencia" style="max-height: 90vh;">
      </div>
    </div>
  </div>
</div>


<!--=====================================
MODAL AGREGAR EMPRESAS
======================================-->
<div class="modal fade" id="modalAgregarOpts">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Agregar OPT</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputOperacion">Operación</label> 
                                <select class="form-control select2" id="inputOperacion" name="inputOperacion" required onchange="mostrarTablaParaGuardar()">
                                    <option value="">Seleccione..</option>
                                    <?php 
                                    $item = null;
                                    $valor = null;                                      
                                    $operacion = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor); 
                                    foreach ($operacion as $key => $value) {
                                        echo '<option value="tabla'.$value["cenco_codigo"].'">'.$value["cenco_codigo"].' '.$value["cenco_nombre"].'</option>';
                                    }

                                    ?>
                                </select>                                  
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label for="inputPlaca">Placa</label> 
                                <select class="form-control select2" id="inputPlaca" name="inputPlaca" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $item = null;
                                    $valor = null;                                      
                                    $vehiculo = ControladorVehiculos::ctrMostrarVehiculos($item, $valor); 
                                    //var_dump($categoria);
                                    foreach ($vehiculo as $key => $value) {
                                        echo '<option value="'.$value["vehic_id"].'">'.$value["vehic_placa"].'</option>';
                                    }  
                                    ?>
                                </select> 
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label for="inputFecha">Fecha</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" id="inputFecha" name="inputFecha" placeholder="Ingrese Fecha" required class="form-control datetimepicker-input" data-target="#reservationdate">
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputCliente">Cliente</label>
                                <input type="text" class="form-control" id="inputCliente" name="inputCliente"
                                    placeholder="Ingrese Cliente" required>
                            </div>
                        </div>                                            

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputLugar">Lugar</label>
                                <input type="text" class="form-control" id="inputLugar" name="inputLugar"
                                    placeholder="Ingrese Lugar">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputObservado">Observado</label>
                                <input type="text" class="form-control" id="inputObservado" name="inputObservado"
                                    placeholder="Ingrese Observado">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputObservador"> Observador (Reportante)</label> 
                                <select class="form-control" id="inputObservador" name="inputObservador">
                                    <option value="">Seleccione...</option>
                                    <option value="Supervisor SST">Supervisor SST</option>
                                    <option value="Prevencionista SST">Prevencionista SST</option>
                                    <option value="Coordinador SIG-SSOMA">Coordinador SIG-SSOMA</option>
                                    <option value="Gerente SIG-SSOMA">Gerente SIG-SSOMA</option>
                                    <option value="Analista SIG-SSOMA">Analista SIG-SSOMA</option>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputDescripcionObservacion">Descripción de la Observación</label> 
                                <textarea class="form-control" rows="4" id="inputDescripcionObservacion" name="inputDescripcionObservacion"
                                placeholder="Ingrese Descripción de la Observación<"></textarea>
                            </div>
                        </div>                        
                    
                        <div class="form-group col-md-1"></div>

                        <div class="form-group col-md-10">                       

                                        <!-- OK ENTRADA 500 TSE LIMA Y PROVINCIAS - SOLGAS -->

                                        <table class="table guardarTable" id="tabla500" style="display: none;"> 
                                            <thead>
                                                <tr>
                                                    <th >#500</th>
                                                    <th > Buenas prácticas de seguridad encontradas </th>
                                                    <th >SI</th>
                                                    <th >NO</th>
                                                    <th >N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INTALACION, ingresa a la instalacion y
                                                            estaciona bien la unidad siguiendo las intalaciones del
                                                            encargado o de los auxiliares, orientado a una salida libre
                                                            y segura.
                                                        </p>
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_txtPregunta1" value="SI">
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_txtPregunta1" value="NO"> 
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_txtPregunta1" value="N/A"> 
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor apaga la unidad y verifica que la unidad esté
                                                            en una posición correcta sin obstaculizar el trasito.
                                                        </p>
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_txtPregunta2" value="NO"> 
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_txtPregunta2" value="N/A"> 
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza los tres puntos de apoyo para descender
                                                            de la unidad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor y/o auxiliares coloca los tacos tipo cuña de
                                                            madera para evitar desplazamientos involuntarios.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza correctamente su EPP (casco, zapatos,
                                                            guantes, anteojos de seguridad, chaleco reflectivo).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Los auxiliares utiliza correctamente su EPP (casco, zapatos,
                                                            guantes, anteojos de seguridad, chaleco reflectivo).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor traza el perimetro de seguridad con los conos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al momento de la carga y descarga de los balones cumple lo
                                                            establecido en el procedimiento de Carga y Descarga de
                                                            Cilindros.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El auxiliar descarga los cilindros de uno en uno.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El auxiliar No golpea los cilindros entre si.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se utiliza el jebe para la descarga de los cilindros de 45
                                                            Kg.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>

                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al finalizar colocan corectamente los implementos de
                                                            sujeción ( eslingas, correas).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta12" value="SI"> </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>

                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada
                                                            cuidando los mismos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor realiza una inspección alrededor de la unidad y
                                                            del lugar, desde el area de descarga hasta la salida.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta14"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor sube a la unidad utilizando los tres puntos de
                                                            apoyo, y se pone el cinturon de seguridad para iniciar el
                                                            recorrido.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta15" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_txtPregunta15" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_txtPregunta15"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="500_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- OK ENTRADA  501 CANJE LIMA Y PROVINCIAS - SOLGAS -->

                                        <table class="table guardarTable" id="tabla501" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#501</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INTALACION, ingresa a la instalacion y
                                                            estaciona bien la unidad siguiendo las intalaciones del
                                                            encargado o de los auxiliares, orientado a una salida libre
                                                            y segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor apaga la unidad y verifica que la unidad esté
                                                            en una posición correcta sin obstaculizar el trasito.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza los tres puntos de apoyo para descender
                                                            de la unidad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor y/o auxiliares coloca los tacos tipo cuña de
                                                            madera para evitar desplazamientos involuntarios.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza correctamente su EPP (casco, zapatos,
                                                            guantes, anteojos de seguridad, chaleco reflectivo).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Los auxiliares utiliza correctamente su EPP (casco, zapatos,
                                                            guantes, anteojos de seguridad, chaleco reflectivo).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor traza el perimetro de seguridad con los conos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al momento de la carga y descarga de los balones cumple lo
                                                            establecido en el procedimiento de Carga y Descarga de
                                                            Cilindros.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El auxiliar carga los cilindros de uno en uno.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El auxiliar No golpea los cilindros entre si.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al finalizar colocan corectamente los implementos de
                                                            sujeción ( eslingas, correas).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada
                                                            cuidando los mismos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta12" value="SI"> </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor realiza una inspección alrededor de la unidad y
                                                            del lugar, desde el area de descarga hasta la salida.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor sube a la unidad utilizando los tres puntos de
                                                            apoyo, y se pone el cinturon de seguridad para iniciar el
                                                            recorrido.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_txtPregunta14"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="501_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- OK ENTRADA  504 TSG LIMA Y PROVINCIAS - REPSOL -->

                                        <table class="table guardarTable" id="tabla504" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#504</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y
                                                            estaciona el camión cisterna siguiendo las indicaciones del
                                                            encargado de la descarga, orientado hacia una salida libre y
                                                            segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor deja el motor en ralentí, acciona el freno de
                                                            mano/neumático.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor utiliza los 3 puntos de apoyo para descender
                                                            del camión.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca las cuñas de madera para evitar
                                                            deslizamientos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza sus EPP (casco, zapatos, guantes,
                                                            anteojos de seguridad y chaleco reflectivo) para realizar la
                                                            descarga.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor aísla el perímetro de la cisterna con conos de
                                                            seguridad y un letrero con la frase “Peligro No Fumar”.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor se mantiene dentro del radio de seguridad
                                                            alrededor del punto de transferencia de GLP (7.6m. o 25
                                                            pies).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            ANTES DE LA DESCARGA El Conductor baja los dos extintores de
                                                            PQS de 20 lbs y los deja a una distancia prudencial.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica con el responsable de la descarga la
                                                            cantidad a descargar de acuerdo al nivel del tanque.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor conecta el cable de puesta a tierra
                                                            asegurándose del buen contacto eléctrico del mismo, para lo
                                                            cual la pinza habrá de fijarse en un borne metálico situado
                                                            en el chasis del vehículo, donde no existe restos de grasas,
                                                            pintura ni óxido.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica la presión en el tanque de la estación
                                                            y la comparará con la presión de la cisterna.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca el contometro en cero.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta12" value="SI"> </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Si el conductor observa una diferencia de presión de ±40
                                                            lbs/plg² entre los tanques, el conductor comunica el hecho
                                                            al supervisor de distribución, para recibir instrucciones
                                                            antes de la inyección de GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor anota las condiciones iniciales del tanque de
                                                            la estación en la hoja de ruta (presión, volumen y
                                                            temperatura) así como las demás indicaciones del documento.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta14"
                                                            value="N/A">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Alrededor del punto de transferencia (7.6m. o 25 pies) se
                                                            apaga todo equipo de comunicación, así como circuitos
                                                            eléctricos que no sirvan para los fines de descarga (radios,
                                                            celulares, etc).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta15" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta15" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta15"
                                                            value="N/A"> </td>
                                                </tr>


                                                <tr>
                                                    <th scope="row">16</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Ninguna persona permanece en la cabina del camión durante la
                                                            descarga de GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta16" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta16" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta16"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">17</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            EN LA DESCARGA El conductor abre la válvula del extremo de
                                                            la manguera tanto líquido como vapor (de ser necesario) que
                                                            se ajustan al tanque de la estación y luego acciona las
                                                            válvulas de descargo de la cisterna.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta17" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta17" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta17"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">18</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor encorcha la toma de fuerza de la caja del
                                                            camión cisterna a la bomba de GLP y regula su velocidad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta18" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta18" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta18"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">19</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor observa el indicador de nivel (% de volumen)
                                                            del tanque de la estación para evitar un sobrellenado del
                                                            mismo.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta19" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta19" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta19"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">20</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            No se debe de superar el 85% del volumen total del tanque de
                                                            la estación.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta20" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta20" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta20"
                                                            value="N/A"> </td>
                                                </tr>


                                                <tr>
                                                    <th scope="row">21</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor verifica frecuentemente los instrumentos de
                                                            control y de seguridad de la cisterna y del tanque de la
                                                            estación.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta21" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta21" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta21"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">22</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            AL FINALIZAR El conductor desciende de la unidad usando los
                                                            tres puntos de apoyo y luego recoge el ticket de despacho
                                                            del asiento del copiloto.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta22" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta22" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta22"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">23</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada,
                                                            dejando libre la zona para la salida del camión.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta23" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta23" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta23"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">24</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor realiza una inspección alrededor del camión y
                                                            del lugar, especialmente desde el área de descarga del
                                                            camión hasta la salida.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta24" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta24" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta24"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">25</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Conductor sube al camión utilizando los tres puntos de
                                                            apoyo, se coloca el cinturón de seguridad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta25" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_txtPregunta25" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_txtPregunta25"
                                                            value="N/A"> </td>
                                                </tr>


                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="504_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- OK ENTRADA  506 - TTP LIMA - CEMEX -->

                                        <table class="table guardarTable" id="tabla506" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#506</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INTALACION, ingresa a la instalacion y
                                                            estaciona bien la unidad siguiendo las indicaciones del
                                                            encargado o de los auxiliares, orientado a una salida libre
                                                            y segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor apaga la unidad y verifica que la unidad
                                                            esté en una posición correcta sin obstaculizar el transito.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            3-El conductor utiliza los tres puntos de apoyo para
                                                            descender de la unidad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            4- El conductor coloca los tacos tipo cuña de madera para
                                                            evitar desplazamientos involuntarios.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza correctamente su EPP (casco,
                                                            zapatos, guantes, anteojos de seguridad, chaleco
                                                            reflectivo).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Los auxiliares utilizan correctamente su EPP (casco,
                                                            zapatos, guantes, anteojos de seguridad, chaleco
                                                            reflectivo).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor traza el perimetro de seguridad con los
                                                            conos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor y los auxiliares toman en cuenta las
                                                            indicaciones del supervisor de seguridad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al momento de la carga y descarga de las bolsas de
                                                            cemento, toman sus precauciones para no ocasionar lesiones.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al finalizar colocan correctamente los implementos de
                                                            sujeción ( eslingas, correas).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada
                                                            cuidando los mismos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor realiza una inspección alrededor de la
                                                            unidad y del lugar, desde el area de descarga hasta la
                                                            salida.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta12" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor sube a la unidad utilizando los tres puntos
                                                            de apoyo, y se pone el cinturon de seguridad para iniciar el
                                                            recorrido.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="506_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>

                                        <!-- ENTRADA  507 TSG LIMA Y PROVINCIAS - SOLGAS -->

                                        <table class="table guardarTable" id="tabla507" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#507</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y
                                                            estaciona el camión cisterna siguiendo las
                                                            indicaciones del encargado de la descarga, orientado hacia
                                                            una salida libre y segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor deja el motor en ralentí, acciona el freno de
                                                            mano/neumático.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor utiliza los 3 puntos de apoyo para descender
                                                            del camión.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Auxiliar coloca las cuñas de madera para evitar
                                                            deslizamientos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza sus EPP (casco, zapatos, guantes,
                                                            anteojos de seguridad y chaleco reflectivo)
                                                            para realizar la descarga.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor aísla el perímetro de la cisterna con conos de
                                                            seguridad y un letrero con la frase
                                                            “Peligro No Fumar”.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor se mantiene dentro del radio de seguridad
                                                            alrededor del punto de transferencia de GLP
                                                            (7.6m. o 25 pies).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            ANTES DE LA DESCARGA El Conductor baja los dos extintores de
                                                            PQS de 20 lbs y los deja a una
                                                            distancia prudencial.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica con el responsable de la descarga la
                                                            cantidad a descargar de acuerdo al nivel
                                                            del tanque.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor conecta el cable de puesta a tierra
                                                            asegurándose del buen contacto eléctrico del mismo,
                                                            para lo cual la pinza habrá de fijarse en un borne metálico
                                                            situado en el chasis del vehículo, donde
                                                            no existe restos de grasas, pintura ni óxido.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica la presión en el tanque de la estación
                                                            y la comparará con la presión de la
                                                            cisterna.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca el contometros en cero.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta12" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Si el conductor observa una diferencia de presión de ±40
                                                            lbs/plg² entre los tanques, el conductor
                                                            comunica el hecho al supervisor de distribución, para
                                                            recibir instrucciones antes de la inyección de
                                                            GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor anota las condiciones iniciales del tanque de
                                                            la estación en la hoja de ruta (presión,
                                                            volumen y temperatura) así como las demás indicaciones del
                                                            documento.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta14"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Alrededor del punto de transferencia (7.6m. o 25 pies) se
                                                            apaga todo equipo de comunicación, así
                                                            como circuitos eléctricos que no sirvan para los fines de
                                                            descarga (radios, celulares, etc).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta15" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta15" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta15"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">16</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Ninguna persona permanece en la cabina del camión durante la
                                                            descarga de GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta16" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta16" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta16"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">17</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            EN LA DESCARGA El conductor abre la válvula del extremo de
                                                            la manguera tanto líquido como vapor (de
                                                            ser necesario) que se ajustan al tanque de la estación y
                                                            luego acciona las válvulas de descargo de
                                                            la cisterna.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta17" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta17" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta17"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">18</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor encorcha la toma de fuerza de la caja del
                                                            camión cisterna a la bomba de GLP y regula su
                                                            velocidad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta18" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta18" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta18"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">19</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor observa el indicador de nivel (% de volumen)
                                                            del tanque de la estación para evitar un
                                                            sobrellenado del mismo.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta19" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta19" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta19"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">20</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            No se almacena GLP a más del 85% del volumen total del
                                                            tanque de la estación.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta20" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta20" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta20"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">21</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor verifica frecuentemente los instrumentos de
                                                            control y de seguridad de la cisterna y del
                                                            tanque de la estación.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta21" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta21" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta21"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">22</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            AL FINALIZAR El conductor desciende de la unidad usando los
                                                            tres puntos de apoyo y luego recoge el
                                                            ticket de despacho del asiento del copiloto.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta22" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta22" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta22"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">23</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada,
                                                            dejando libre la zona para la salida del
                                                            camión.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta23" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta23" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta23"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">24</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor realiza una inspección alrededor del camión y
                                                            del lugar, especialmente desde el área de
                                                            descarga del camión hasta la salida.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta24" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta24" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta24"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">25</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Conductor sube al camión utilizando los tres puntos de
                                                            apoyo, se coloca el cinturón de seguridad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta25" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_txtPregunta25" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_txtPregunta25"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="507_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- ENTRADA  508 PACKAGE LIMA - LINDE -->

                                        <table class="table guardarTable" id="tabla508" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#508</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INTALACION, ingresa a la instalacion y
                                                            estaciona bien la unidad siguiendo las
                                                            intalaciones del encargado o de los auxiliares, orientado a
                                                            una salida libre y segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor apaga la unidad y verifica que la unidad esté
                                                            en una posición correcta sin obstaculizar
                                                            el trasito.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza los tres puntos de apoyo para descender
                                                            de la unidad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca los tacos tipo cuña de madera para
                                                            evitar desplazamientos involuntarios.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza correctamente su EPP (casco, zapatos,
                                                            guantes, anteojos de seguridad, chaleco
                                                            reflectivo).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Los auxiliares utilizan correctamente su EPP (casco,
                                                            zapatos, guantes, anteojos de seguridad,
                                                            chaleco reflectivo).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor traza el perimetro de seguridad con los conos.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor y los auxiliares toman en cuenta las
                                                            indicaciones del supervisor de seguridad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al momento de la carga y descarga colocan la cantidad de
                                                            cilindros recomendados por el fabricante o
                                                            la empresa, toman sus precauciones para no ocasionar
                                                            lesiones.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al finalizar colocan corectamente los implementos de
                                                            sujeción ( eslingas, correas).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada
                                                            cuidando los mismos.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor realiza una inspección alrededor de la unidad y
                                                            del lugar, desde el area de descarga
                                                            hasta la salida.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta12" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor sube a la unidad utilizando los tres puntos de
                                                            apoyo, y se pone el cinturon de
                                                            seguridad para iniciar el recorrido.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="508_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- ENTRADA  509 TSG LIMA Y PROVINCIAS - LIMA GAS  -->

                                        <table class="table guardarTable" id="tabla509" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#509</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y
                                                            estaciona el camión cisterna siguiendo las
                                                            indicaciones del encargado de la descarga, orientado hacia
                                                            una salida libre y segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor deja el motor en ralentí, acciona el freno de
                                                            mano/neumático.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor utiliza los 3 puntos de apoyo para descender
                                                            del camión.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca las cuñas de madera para evitar
                                                            deslizamientos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza sus EPP (casco, zapatos, guantes,
                                                            anteojos de seguridad y chaleco reflectivo)
                                                            para realizar la descarga.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor aísla el perímetro de la cisterna con conos de
                                                            seguridad y un letrero con la frase
                                                            “Peligro No Fumar”.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor se mantiene dentro del radio de seguridad
                                                            alrededor del punto de transferencia de GLP
                                                            (7.6m. o 25 pies).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            ANTES DE LA DESCARGA El Conductor baja los dos extintores de
                                                            PQS de 20 lbs y los deja a una
                                                            distancia prudencial.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica con el responsable de la descarga la
                                                            cantidad a descargar de acuerdo al nivel
                                                            del tanque.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor conecta el cable de puesta a tierra
                                                            asegurándose del buen contacto eléctrico del mismo,
                                                            para lo cual la pinza habrá de fijarse en un borne metálico
                                                            situado en el chasis del vehículo, donde
                                                            no existe restos de grasas, pintura ni óxido.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica la presión en el tanque de la estación
                                                            y la comparará con la presión de la
                                                            cisterna.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca el contometro en cero.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta12" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Si el conductor observa una diferencia de presión de ±40
                                                            lbs/plg² entre los tanques, el conductor
                                                            comunica el hecho al supervisor de distribución, para
                                                            recibir instrucciones antes de la inyección de
                                                            GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor anota las condiciones iniciales del tanque de
                                                            la estación en la hoja de ruta (presión,
                                                            volumen y temperatura) así como las demás indicaciones del
                                                            documento.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta14"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Alrededor del punto de transferencia (7.6m. o 25 pies) se
                                                            apaga todo equipo de comunicación, así
                                                            como circuitos eléctricos que no sirvan para los fines de
                                                            descarga (radios, celulares, etc).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta15" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta15" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta15"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">16</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Ninguna persona permanece en la cabina del camión durante la
                                                            descarga de GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta16" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta16" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta16"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">17</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            EN LA DESCARGA El conductor abre la válvula del extremo de
                                                            la manguera tanto líquido como vapor (de
                                                            ser necesario) que se ajustan al tanque de la estación y
                                                            luego acciona las válvulas de descargo de
                                                            la cisterna.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta17" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta17" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta17"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">18</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor encorcha la toma de fuerza de la caja del
                                                            camión cisterna a la bomba de GLP y regula su
                                                            velocidad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta18" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta18" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta18"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">19</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor observa el indicador de nivel (% de volumen)
                                                            del tanque de la estación para evitar un
                                                            sobrellenado del mismo.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta19" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta19" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta19"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">20</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            No se debe de superar el 85% del volumen total del tanque de
                                                            la estación.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta20" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta20" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta20"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">21</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor verifica frecuentemente los instrumentos de
                                                            control y de seguridad de la cisterna y del
                                                            tanque de la estación.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta21" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta21" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta21"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">22</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            AL FINALIZAR El conductor desciende de la unidad usando los
                                                            tres puntos de apoyo y luego recoge el
                                                            ticket de despacho del asiento del copiloto.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta22" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta22" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta22"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">23</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada,
                                                            dejando libre la zona para la salida del
                                                            camión.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta23" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta23" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta23"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">24</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor realiza una inspección alrededor del camión y
                                                            del lugar, especialmente desde el área de
                                                            descarga del camión hasta la salida.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta24" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta24" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta24"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">25</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Conductor sube al camión utilizando los tres puntos de
                                                            apoyo, se coloca el cinturón de seguridad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta25" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_txtPregunta25" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_txtPregunta25"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="509_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- ENTRADA  511 TSG LIMA - PRIMAX  -->

                                        <table class="table guardarTable" id="tabla511" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#511</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y
                                                            estaciona el camión cisterna siguiendo las
                                                            indicaciones del encargado de la descarga, orientado hacia
                                                            una salida libre y segura.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor deja el motor en ralentí, acciona el freno de
                                                            mano/neumático.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor utiliza los 3 puntos de apoyo para descender
                                                            del camión.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca las cuñas de madera para evitar
                                                            deslizamientos.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza sus EPP (casco, zapatos, guantes,
                                                            anteojos de seguridad y chaleco reflectivo)
                                                            para realizar la descarga.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor aísla el perímetro de la cisterna con conos de
                                                            seguridad y un letrero con la frase
                                                            “Peligro No Fumar”.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor se mantiene dentro del radio de seguridad
                                                            alrededor del punto de transferencia de GLP
                                                            (7.6m. o 25 pies).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            ANTES DE LA DESCARGA El Conductor baja los dos extintores de
                                                            PQS de 20 lbs y los deja a una
                                                            distancia prudencial.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica con el responsable de la descarga la
                                                            cantidad a descargar de acuerdo al nivel
                                                            del tanque.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor conecta el cable de puesta a tierra
                                                            asegurándose del buen contacto eléctrico del mismo,
                                                            para lo cual la pinza habrá de fijarse en un borne metálico
                                                            situado en el chasis del vehículo, donde
                                                            no existe restos de grasas, pintura ni óxido.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica la presión en el tanque de la estación
                                                            y la comparará con la presión de la
                                                            cisterna.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca el contometro en cero.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta12" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Si el conductor observa una diferencia de presión de ±40
                                                            lbs/plg² entre los tanques, el conductor
                                                            comunica el hecho al supervisor de distribución, para
                                                            recibir instrucciones antes de la inyección de
                                                            GLP.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor anota las condiciones iniciales del tanque de
                                                            la estación en la hoja de ruta (presión,
                                                            volumen y temperatura) así como las demás indicaciones del
                                                            documento.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta14"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Alrededor del punto de transferencia (7.6m. o 25 pies) se
                                                            apaga todo equipo de comunicación, así
                                                            como circuitos eléctricos que no sirvan para los fines de
                                                            descarga (radios, celulares, etc).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta15" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta15" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta15"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">16</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Ninguna persona permanece en la cabina del camión durante la
                                                            descarga de GLP.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta16" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta16" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta16"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">17</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            EN LA DESCARGA El conductor abre la válvula del extremo de
                                                            la manguera tanto líquido como vapor (de
                                                            ser necesario) que se ajustan al tanque de la estación y
                                                            luego acciona las válvulas de descargo de
                                                            la cisterna.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta17" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta17" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta17"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">18</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor encorcha la toma de fuerza de la caja del
                                                            camión cisterna a la bomba de GLP y regula su
                                                            velocidad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta18" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta18" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta18"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">19</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor observa el indicador de nivel (% de volumen)
                                                            del tanque de la estación para evitar un
                                                            sobrellenado del mismo.
                                                        </p>

                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta19" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta19" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta19"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">20</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            No se debe de superar el 85% del volumen total del tanque de
                                                            la estación.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta20" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta20" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta20"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">21</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor verifica frecuentemente los instrumentos de
                                                            control y de seguridad de la cisterna y del
                                                            tanque de la estación.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta21" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta21" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta21"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">22</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            AL FINALIZAR El conductor desciende de la unidad usando los
                                                            tres puntos de apoyo y luego recoge el
                                                            ticket de despacho del asiento del copiloto.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta22" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta22" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta22"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">23</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada,
                                                            dejando libre la zona para la salida del
                                                            camión.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta23" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta23" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta23"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">24</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor realiza una inspección alrededor del camión y
                                                            del lugar, especialmente desde el área de
                                                            descarga del camión hasta la salida.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta24" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta24" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta24"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">25</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Conductor sube al camión utilizando los tres puntos de
                                                            apoyo, se coloca el cinturón de seguridad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta25" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_txtPregunta25" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_txtPregunta25"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="511_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                        </div> 

                        <div class="form-group col-md-1"></div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputBuenasPracticas">Buenas Practicas</label> 
                                <textarea class="form-control" id="inputBuenasPracticas" name="inputBuenasPracticas"
                                placeholder="Ingrese Buenas Practicas"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputDescripcionAdicional">Descripción Adicional</label> 
                                <textarea class="form-control" id="inputDescripcionAdicional" name="inputDescripcionAdicional"
                                placeholder="Ingrese Descripción Adicional"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputTipoHallazgo"> Tipo de Hallazgo</label> 
                                <select class="form-control" id="inputTipoHallazgo" name="inputTipoHallazgo">
                                    <option value="">Seleccione...</option>
                                    <option value="Auditoría">Auditoría</option>
                                    <option value="Incidente">Incidente</option>
                                    <option value="Accidentes">Accidentes</option>
                                    <option value="Reporte Cliente">Reporte Cliente</option>
                                    <option value="Opt">Opt</option>
                                    <option value="Acto Sub Estándar">Acto Sub Estándar</option>
                                    <option value="Condición Sub Estándar">Condición Sub Estándar</option>
                                    <option value="N.A.">N.A.</option>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputRelacionado">Relacionado con</label> 
                                <select class="form-control" id="inputRelacionado" name="inputRelacionado">
                                    <option value="">Seleccione...</option>
                                    <option value="Seguridad">Seguridad</option>
                                    <option value="Medio Ambiente">Medio Ambiente</option>
                                    <option value="Calidad">Calidad</option> 
                                </select>    
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputCorreccion">Corrección</label> 
                                <textarea class="form-control" id="inputCorreccion" name="inputCorreccion"
                                placeholder="Ingrese Corrección"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEvidencia1">Evidencia 1 (Foto) </label> 
                                    <input type="file" class="nuevaFoto1" name="nuevaFoto1">
                                    <p class="help-block">Peso máximo de la foto 4MB</p>
                                    <img src="vistas/img/sig/opt/default/no-image.png" class="img-thumbnail previsualizar1" width="200px">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEvidencia2">Evidencia 2 (Foto) </label> 
                                    <input type="file" class="nuevaFoto2" name="nuevaFoto2">
                                    <p class="help-block">Peso máximo de la foto 4MB</p>
                                    <img src="vistas/img/sig/opt/default/no-image.png" class="img-thumbnail previsualizar2" width="200px">
                            </div>
                        </div>

                        <input type="hidden" name="inputUser" id="inputUser" value="<?php echo $_SESSION["usu_id"]; ?>">

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
            $crearOpt = new ControladorOpts();
            $crearOpt -> ctrCrearOpts();
            ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!--=====================================
MODAL EDITAR EMPRESAS
======================================-->
<div class="modal fade" id="modalEditarOpt">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Actualizar OPT</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row">

                    <input type="hidden" id="inputEditarIdOpt" name="inputEditarIdOpt">

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEditarOperacion">Operación</label> 
                                <select class="form-control select2" id="inputEditarOperacion" name="inputEditarOperacion" required onchange="mostrarEditarTabla()">
                                    <option value="">Actualizar operación..</option>
                                    <?php 
                                    $item = null;
                                    $valor = null;                                      
                                    $operacion = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor); 
                                    foreach ($operacion as $key => $value) {
                                        echo '<option value="tablaEdit'.$value["cenco_codigo"].'">'.$value["cenco_codigo"].' '.$value["cenco_nombre"].'</option>';
                                    }
                                    ?>
                                </select>                                  
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label for="inputEditarPlaca">Placa</label> 
                                <select class="form-control select2" id="inputEditarPlaca" name="inputEditarPlaca" required>
                                    <option value="">Actualizar placa...</option>
                                    <?php
                                    $item = null;
                                    $valor = null;                                      
                                    $vehiculo = ControladorVehiculos::ctrMostrarVehiculos($item, $valor); 
                                    //var_dump($categoria);
                                    foreach ($vehiculo as $key => $value) {
                                        echo '<option value="'.$value["vehic_id"].'">'.$value["vehic_placa"].'</option>';
                                    }  
                                    ?>
                                </select> 
                            </div>
                        </div>

                    
                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label for="inputEditarFecha">Fecha</label>
                                <div class="input-group date" id="reservationdateEditar" data-target-input="nearest">
                                    <input type="text" id="inputEditarFecha" name="inputEditarFecha" placeholder="Ingrese Fecha" required class="form-control datetimepicker-input" data-target="#reservationdateEditar">
                                    <div class="input-group-append" data-target="#reservationdateEditar" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEditarCliente">Cliente</label>
                                <input type="text" class="form-control" id="inputEditarCliente" name="inputEditarCliente"
                                    placeholder="Ingrese Cliente" required>
                            </div>
                        </div>                                            

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEditarLugar">Lugar</label>
                                <input type="text" class="form-control" id="inputEditarLugar" name="inputEditarLugar"
                                    placeholder="Ingrese Lugar">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEditarObservado">Observado</label>
                                <input type="text" class="form-control" id="inputEditarObservado" name="inputEditarObservado"
                                    placeholder="Ingrese Observado">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEditarObservador"> Observador (Reportante)</label> 
                                <select class="form-control" id="inputEditarObservador" name="inputEditarObservador">
                                    <option value="">Seleccione...</option>
                                    <option value="Supervisor SST">Supervisor SST</option>
                                    <option value="Prevencionista SST">Prevencionista SST</option>
                                    <option value="Coordinador SIG-SSOMA">Coordinador SIG-SSOMA</option>
                                    <option value="Gerente SIG-SSOMA">Gerente SIG-SSOMA</option>
                                    <option value="Analista SIG-SSOMA">Analista SIG-SSOMA</option>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputEditarDescripcionObservacion">Descripción de la Observación</label> 
                                <textarea class="form-control" rows="4" id="inputEditarDescripcionObservacion" name="inputEditarDescripcionObservacion" placeholder="Ingrese Descripción de la Observación<"></textarea>
                            </div>
                        </div>                        
                    
                        <div class="form-group col-md-1"></div> 

                        <div class="form-group col-md-10">                       

                                        <!-- OK ENTRADA 500 TSE LIMA Y PROVINCIAS - SOLGAS -->

                                        <table class="table editarTable" id="tablaEdit500" style="display: none;"> 
                                            <thead>
                                                <tr>
                                                    <th >#500</th>
                                                    <th > Buenas prácticas de seguridad encontradas </th>
                                                    <th >SI</th>
                                                    <th >NO</th>
                                                    <th >N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INTALACION, ingresa a la instalacion y
                                                            estaciona bien la unidad siguiendo las intalaciones del
                                                            encargado o de los auxiliares, orientado a una salida libre
                                                            y segura.
                                                        </p>
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_edit_txtPregunta1" value="SI">
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_edit_txtPregunta1" value="NO"> 
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_edit_txtPregunta1" value="N/A"> 
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor apaga la unidad y verifica que la unidad esté
                                                            en una posición correcta sin obstaculizar el trasito.
                                                        </p>
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_edit_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_edit_txtPregunta2" value="NO"> 
                                                    </td>
                                                    <td> 
                                                        <input class="form-input" type="radio" name="500_edit_txtPregunta2" value="N/A"> 
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza los tres puntos de apoyo para descender
                                                            de la unidad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor y/o auxiliares coloca los tacos tipo cuña de
                                                            madera para evitar desplazamientos involuntarios.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza correctamente su EPP (casco, zapatos,
                                                            guantes, anteojos de seguridad, chaleco reflectivo).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Los auxiliares utiliza correctamente su EPP (casco, zapatos,
                                                            guantes, anteojos de seguridad, chaleco reflectivo).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor traza el perimetro de seguridad con los conos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al momento de la carga y descarga de los balones cumple lo
                                                            establecido en el procedimiento de Carga y Descarga de
                                                            Cilindros.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El auxiliar descarga los cilindros de uno en uno.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            11- El auxiliar No golpea los cilindros entre si.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se utiliza el jebe para la descarga de los cilindros de 45
                                                            Kg.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>

                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al finalizar colocan corectamente los implementos de
                                                            sujeción ( eslingas, correas).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta12" value="SI"> </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>

                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada
                                                            cuidando los mismos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor realiza una inspección alrededor de la unidad y
                                                            del lugar, desde el area de descarga hasta la salida.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta14"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor sube a la unidad utilizando los tres puntos de
                                                            apoyo, y se pone el cinturon de seguridad para iniciar el
                                                            recorrido.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta15" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="500_edit_txtPregunta15" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="500_edit_txtPregunta15"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="500_edit_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- OK ENTRADA  501 CANJE LIMA Y PROVINCIAS - SOLGAS -->

                                        <table class="table editarTable" id="tablaEdit501" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#501</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INTALACION, ingresa a la instalacion y
                                                            estaciona bien la unidad siguiendo las intalaciones del
                                                            encargado o de los auxiliares, orientado a una salida libre
                                                            y segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor apaga la unidad y verifica que la unidad esté
                                                            en una posición correcta sin obstaculizar el trasito.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza los tres puntos de apoyo para descender
                                                            de la unidad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor y/o auxiliares coloca los tacos tipo cuña de
                                                            madera para evitar desplazamientos involuntarios.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza correctamente su EPP (casco, zapatos,
                                                            guantes, anteojos de seguridad, chaleco reflectivo).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Los auxiliares utiliza correctamente su EPP (casco, zapatos,
                                                            guantes, anteojos de seguridad, chaleco reflectivo).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor traza el perimetro de seguridad con los conos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al momento de la carga y descarga de los balones cumple lo
                                                            establecido en el procedimiento de Carga y Descarga de
                                                            Cilindros.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El auxiliar carga los cilindros de uno en uno.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El auxiliar No golpea los cilindros entre si.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al finalizar colocan corectamente los implementos de
                                                            sujeción ( eslingas, correas).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada
                                                            cuidando los mismos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta12" value="SI"> </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor realiza una inspección alrededor de la unidad y
                                                            del lugar, desde el area de descarga hasta la salida.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor sube a la unidad utilizando los tres puntos de
                                                            apoyo, y se pone el cinturon de seguridad para iniciar el
                                                            recorrido.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="501_edit_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="501_edit_txtPregunta14"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="501_edit_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- OK ENTRADA  504 TSG LIMA Y PROVINCIAS - REPSOL -->

                                        <table class="table editarTable" id="tablaEdit504" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#504</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y
                                                            estaciona el camión cisterna siguiendo las indicaciones del
                                                            encargado de la descarga, orientado hacia una salida libre y
                                                            segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor deja el motor en ralentí, acciona el freno de
                                                            mano/neumático.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor utiliza los 3 puntos de apoyo para descender
                                                            del camión.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca las cuñas de madera para evitar
                                                            deslizamientos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza sus EPP (casco, zapatos, guantes,
                                                            anteojos de seguridad y chaleco reflectivo) para realizar la
                                                            descarga.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor aísla el perímetro de la cisterna con conos de
                                                            seguridad y un letrero con la frase “Peligro No Fumar”.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor se mantiene dentro del radio de seguridad
                                                            alrededor del punto de transferencia de GLP (7.6m. o 25
                                                            pies).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            ANTES DE LA DESCARGA El Conductor baja los dos extintores de
                                                            PQS de 20 lbs y los deja a una distancia prudencial.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica con el responsable de la descarga la
                                                            cantidad a descargar de acuerdo al nivel del tanque.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor conecta el cable de puesta a tierra
                                                            asegurándose del buen contacto eléctrico del mismo, para lo
                                                            cual la pinza habrá de fijarse en un borne metálico situado
                                                            en el chasis del vehículo, donde no existe restos de grasas,
                                                            pintura ni óxido.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica la presión en el tanque de la estación
                                                            y la comparará con la presión de la cisterna.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>
                                                <tr>

                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca el contometro en cero.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta12" value="SI"> </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Si el conductor observa una diferencia de presión de ±40
                                                            lbs/plg² entre los tanques, el conductor comunica el hecho
                                                            al supervisor de distribución, para recibir instrucciones
                                                            antes de la inyección de GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor anota las condiciones iniciales del tanque de
                                                            la estación en la hoja de ruta (presión, volumen y
                                                            temperatura) así como las demás indicaciones del documento.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta14"
                                                            value="N/A">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Alrededor del punto de transferencia (7.6m. o 25 pies) se
                                                            apaga todo equipo de comunicación, así como circuitos
                                                            eléctricos que no sirvan para los fines de descarga (radios,
                                                            celulares, etc).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta15" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta15" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta15"
                                                            value="N/A"> </td>
                                                </tr>


                                                <tr>
                                                    <th scope="row">16</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Ninguna persona permanece en la cabina del camión durante la
                                                            descarga de GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta16" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta16" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta16"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">17</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            EN LA DESCARGA El conductor abre la válvula del extremo de
                                                            la manguera tanto líquido como vapor (de ser necesario) que
                                                            se ajustan al tanque de la estación y luego acciona las
                                                            válvulas de descargo de la cisterna.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta17" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta17" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta17"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">18</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor encorcha la toma de fuerza de la caja del
                                                            camión cisterna a la bomba de GLP y regula su velocidad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta18" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta18" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta18"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">19</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor observa el indicador de nivel (% de volumen)
                                                            del tanque de la estación para evitar un sobrellenado del
                                                            mismo.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta19" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta19" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta19"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">20</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            No se debe de superar el 85% del volumen total del tanque de
                                                            la estación.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta20" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta20" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta20"
                                                            value="N/A"> </td>
                                                </tr>


                                                <tr>
                                                    <th scope="row">21</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor verifica frecuentemente los instrumentos de
                                                            control y de seguridad de la cisterna y del tanque de la
                                                            estación.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta21" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta21" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta21"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">22</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            AL FINALIZAR El conductor desciende de la unidad usando los
                                                            tres puntos de apoyo y luego recoge el ticket de despacho
                                                            del asiento del copiloto.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta22" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta22" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta22"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">23</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada,
                                                            dejando libre la zona para la salida del camión.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta23" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta23" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta23"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">24</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor realiza una inspección alrededor del camión y
                                                            del lugar, especialmente desde el área de descarga del
                                                            camión hasta la salida.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta24" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta24" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta24"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">25</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Conductor sube al camión utilizando los tres puntos de
                                                            apoyo, se coloca el cinturón de seguridad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta25" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="504_edit_txtPregunta25" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="504_edit_txtPregunta25"
                                                            value="N/A"> </td>
                                                </tr>


                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="504_edit_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- OK ENTRADA  506 - TTP LIMA - CEMEX -->

                                        <table class="table editarTable" id="tablaEdit506" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#506</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INTALACION, ingresa a la instalacion y
                                                            estaciona bien la unidad siguiendo las indicaciones del
                                                            encargado o de los auxiliares, orientado a una salida libre
                                                            y segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor apaga la unidad y verifica que la unidad
                                                            esté en una posición correcta sin obstaculizar el transito.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            3-El conductor utiliza los tres puntos de apoyo para
                                                            descender de la unidad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            4- El conductor coloca los tacos tipo cuña de madera para
                                                            evitar desplazamientos involuntarios.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza correctamente su EPP (casco,
                                                            zapatos, guantes, anteojos de seguridad, chaleco
                                                            reflectivo).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Los auxiliares utilizan correctamente su EPP (casco,
                                                            zapatos, guantes, anteojos de seguridad, chaleco
                                                            reflectivo).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor traza el perimetro de seguridad con los
                                                            conos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor y los auxiliares toman en cuenta las
                                                            indicaciones del supervisor de seguridad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al momento de la carga y descarga de las bolsas de
                                                            cemento, toman sus precauciones para no ocasionar lesiones.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al finalizar colocan correctamente los implementos de
                                                            sujeción ( eslingas, correas).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada
                                                            cuidando los mismos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor realiza una inspección alrededor de la
                                                            unidad y del lugar, desde el area de descarga hasta la
                                                            salida.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta12" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor sube a la unidad utilizando los tres puntos
                                                            de apoyo, y se pone el cinturon de seguridad para iniciar el
                                                            recorrido.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="506_edit_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="506_edit_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="506_edit_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>

                                        <!-- ENTRADA  507 TSG LIMA Y PROVINCIAS - SOLGAS -->

                                        <table class="table editarTable" id="tablaEdit507" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#507</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y
                                                            estaciona el camión cisterna siguiendo las
                                                            indicaciones del encargado de la descarga, orientado hacia
                                                            una salida libre y segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor deja el motor en ralentí, acciona el freno de
                                                            mano/neumático.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor utiliza los 3 puntos de apoyo para descender
                                                            del camión.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Auxiliar coloca las cuñas de madera para evitar
                                                            deslizamientos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza sus EPP (casco, zapatos, guantes,
                                                            anteojos de seguridad y chaleco reflectivo)
                                                            para realizar la descarga.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor aísla el perímetro de la cisterna con conos de
                                                            seguridad y un letrero con la frase
                                                            “Peligro No Fumar”.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor se mantiene dentro del radio de seguridad
                                                            alrededor del punto de transferencia de GLP
                                                            (7.6m. o 25 pies).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            ANTES DE LA DESCARGA El Conductor baja los dos extintores de
                                                            PQS de 20 lbs y los deja a una
                                                            distancia prudencial.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica con el responsable de la descarga la
                                                            cantidad a descargar de acuerdo al nivel
                                                            del tanque.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor conecta el cable de puesta a tierra
                                                            asegurándose del buen contacto eléctrico del mismo,
                                                            para lo cual la pinza habrá de fijarse en un borne metálico
                                                            situado en el chasis del vehículo, donde
                                                            no existe restos de grasas, pintura ni óxido.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica la presión en el tanque de la estación
                                                            y la comparará con la presión de la
                                                            cisterna.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca el contometros en cero.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta12" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Si el conductor observa una diferencia de presión de ±40
                                                            lbs/plg² entre los tanques, el conductor
                                                            comunica el hecho al supervisor de distribución, para
                                                            recibir instrucciones antes de la inyección de
                                                            GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor anota las condiciones iniciales del tanque de
                                                            la estación en la hoja de ruta (presión,
                                                            volumen y temperatura) así como las demás indicaciones del
                                                            documento.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta14"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Alrededor del punto de transferencia (7.6m. o 25 pies) se
                                                            apaga todo equipo de comunicación, así
                                                            como circuitos eléctricos que no sirvan para los fines de
                                                            descarga (radios, celulares, etc).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta15" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta15" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta15"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">16</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Ninguna persona permanece en la cabina del camión durante la
                                                            descarga de GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta16" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta16" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta16"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">17</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            EN LA DESCARGA El conductor abre la válvula del extremo de
                                                            la manguera tanto líquido como vapor (de
                                                            ser necesario) que se ajustan al tanque de la estación y
                                                            luego acciona las válvulas de descargo de
                                                            la cisterna.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta17" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta17" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta17"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">18</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor encorcha la toma de fuerza de la caja del
                                                            camión cisterna a la bomba de GLP y regula su
                                                            velocidad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta18" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta18" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta18"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">19</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor observa el indicador de nivel (% de volumen)
                                                            del tanque de la estación para evitar un
                                                            sobrellenado del mismo.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta19" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta19" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta19"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">20</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            No se almacena GLP a más del 85% del volumen total del
                                                            tanque de la estación.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta20" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta20" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta20"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">21</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor verifica frecuentemente los instrumentos de
                                                            control y de seguridad de la cisterna y del
                                                            tanque de la estación.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta21" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta21" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta21"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">22</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            AL FINALIZAR El conductor desciende de la unidad usando los
                                                            tres puntos de apoyo y luego recoge el
                                                            ticket de despacho del asiento del copiloto.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta22" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta22" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta22"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">23</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada,
                                                            dejando libre la zona para la salida del
                                                            camión.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta23" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta23" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta23"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">24</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor realiza una inspección alrededor del camión y
                                                            del lugar, especialmente desde el área de
                                                            descarga del camión hasta la salida.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta24" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta24" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta24"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">25</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Conductor sube al camión utilizando los tres puntos de
                                                            apoyo, se coloca el cinturón de seguridad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta25" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="507_edit_txtPregunta25" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="507_edit_txtPregunta25"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="507_edit_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- ENTRADA  508 PACKAGE LIMA - LINDE -->

                                        <table class="table editarTable" id="tablaEdit508" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#508_edit</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INTALACION, ingresa a la instalacion y
                                                            estaciona bien la unidad siguiendo las
                                                            intalaciones del encargado o de los auxiliares, orientado a
                                                            una salida libre y segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor apaga la unidad y verifica que la unidad esté
                                                            en una posición correcta sin obstaculizar
                                                            el trasito.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza los tres puntos de apoyo para descender
                                                            de la unidad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca los tacos tipo cuña de madera para
                                                            evitar desplazamientos involuntarios.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza correctamente su EPP (casco, zapatos,
                                                            guantes, anteojos de seguridad, chaleco
                                                            reflectivo).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Los auxiliares utilizan correctamente su EPP (casco,
                                                            zapatos, guantes, anteojos de seguridad,
                                                            chaleco reflectivo).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor traza el perimetro de seguridad con los conos.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor y los auxiliares toman en cuenta las
                                                            indicaciones del supervisor de seguridad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al momento de la carga y descarga colocan la cantidad de
                                                            cilindros recomendados por el fabricante o
                                                            la empresa, toman sus precauciones para no ocasionar
                                                            lesiones.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Al finalizar colocan corectamente los implementos de
                                                            sujeción ( eslingas, correas).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada
                                                            cuidando los mismos.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor realiza una inspección alrededor de la unidad y
                                                            del lugar, desde el area de descarga
                                                            hasta la salida.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta12" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor sube a la unidad utilizando los tres puntos de
                                                            apoyo, y se pone el cinturon de
                                                            seguridad para iniciar el recorrido.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="508_edit_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="508_edit_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="508_edit_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- ENTRADA  509 TSG LIMA Y PROVINCIAS - LIMA GAS  -->

                                        <table class="table editarTable" id="tablaEdit509" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#509_edit</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y
                                                            estaciona el camión cisterna siguiendo las
                                                            indicaciones del encargado de la descarga, orientado hacia
                                                            una salida libre y segura.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor deja el motor en ralentí, acciona el freno de
                                                            mano/neumático.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor utiliza los 3 puntos de apoyo para descender
                                                            del camión.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca las cuñas de madera para evitar
                                                            deslizamientos.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza sus EPP (casco, zapatos, guantes,
                                                            anteojos de seguridad y chaleco reflectivo)
                                                            para realizar la descarga.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor aísla el perímetro de la cisterna con conos de
                                                            seguridad y un letrero con la frase
                                                            “Peligro No Fumar”.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor se mantiene dentro del radio de seguridad
                                                            alrededor del punto de transferencia de GLP
                                                            (7.6m. o 25 pies).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            ANTES DE LA DESCARGA El Conductor baja los dos extintores de
                                                            PQS de 20 lbs y los deja a una
                                                            distancia prudencial.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica con el responsable de la descarga la
                                                            cantidad a descargar de acuerdo al nivel
                                                            del tanque.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor conecta el cable de puesta a tierra
                                                            asegurándose del buen contacto eléctrico del mismo,
                                                            para lo cual la pinza habrá de fijarse en un borne metálico
                                                            situado en el chasis del vehículo, donde
                                                            no existe restos de grasas, pintura ni óxido.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica la presión en el tanque de la estación
                                                            y la comparará con la presión de la
                                                            cisterna.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca el contometro en cero.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta12" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Si el conductor observa una diferencia de presión de ±40
                                                            lbs/plg² entre los tanques, el conductor
                                                            comunica el hecho al supervisor de distribución, para
                                                            recibir instrucciones antes de la inyección de
                                                            GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor anota las condiciones iniciales del tanque de
                                                            la estación en la hoja de ruta (presión,
                                                            volumen y temperatura) así como las demás indicaciones del
                                                            documento.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta14"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Alrededor del punto de transferencia (7.6m. o 25 pies) se
                                                            apaga todo equipo de comunicación, así
                                                            como circuitos eléctricos que no sirvan para los fines de
                                                            descarga (radios, celulares, etc).
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta15" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta15" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta15"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">16</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Ninguna persona permanece en la cabina del camión durante la
                                                            descarga de GLP.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta16" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta16" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta16"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">17</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            EN LA DESCARGA El conductor abre la válvula del extremo de
                                                            la manguera tanto líquido como vapor (de
                                                            ser necesario) que se ajustan al tanque de la estación y
                                                            luego acciona las válvulas de descargo de
                                                            la cisterna.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta17" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta17" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta17"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">18</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor encorcha la toma de fuerza de la caja del
                                                            camión cisterna a la bomba de GLP y regula su
                                                            velocidad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta18" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta18" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta18"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">19</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor observa el indicador de nivel (% de volumen)
                                                            del tanque de la estación para evitar un
                                                            sobrellenado del mismo.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta19" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta19" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta19"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">20</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            No se debe de superar el 85% del volumen total del tanque de
                                                            la estación.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta20" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta20" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta20"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">21</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor verifica frecuentemente los instrumentos de
                                                            control y de seguridad de la cisterna y del
                                                            tanque de la estación.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta21" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta21" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta21"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">22</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            AL FINALIZAR El conductor desciende de la unidad usando los
                                                            tres puntos de apoyo y luego recoge el
                                                            ticket de despacho del asiento del copiloto.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta22" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta22" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta22"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">23</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada,
                                                            dejando libre la zona para la salida del
                                                            camión.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta23" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta23" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta23"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">24</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor realiza una inspección alrededor del camión y
                                                            del lugar, especialmente desde el área de
                                                            descarga del camión hasta la salida.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta24" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta24" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta24"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">25</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Conductor sube al camión utilizando los tres puntos de
                                                            apoyo, se coloca el cinturón de seguridad.
                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta25" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="509_edit_txtPregunta25" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="509_edit_txtPregunta25"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="509_edit_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <!-- ENTRADA  511 TSG LIMA - PRIMAX  -->

                                        <table class="table editarTable" id="tablaEdit511" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#511_edit</th>
                                                    <th scope="col"> Buenas prácticas de seguridad encontradas </th>
                                                    <th scope="col">SI</th>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">N/A</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y
                                                            estaciona el camión cisterna siguiendo las
                                                            indicaciones del encargado de la descarga, orientado hacia
                                                            una salida libre y segura.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta1"
                                                            value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta1"
                                                            value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta1"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor deja el motor en ralentí, acciona el freno de
                                                            mano/neumático.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta2" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta2" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta2"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor utiliza los 3 puntos de apoyo para descender
                                                            del camión.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta3" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta3" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta3"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca las cuñas de madera para evitar
                                                            deslizamientos.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta4" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta4" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta4"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor utiliza sus EPP (casco, zapatos, guantes,
                                                            anteojos de seguridad y chaleco reflectivo)
                                                            para realizar la descarga.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta5" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta5" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta5"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor aísla el perímetro de la cisterna con conos de
                                                            seguridad y un letrero con la frase
                                                            “Peligro No Fumar”.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta6" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta6" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta6"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">7</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor se mantiene dentro del radio de seguridad
                                                            alrededor del punto de transferencia de GLP
                                                            (7.6m. o 25 pies).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta7" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta7" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta7"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">8</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            ANTES DE LA DESCARGA El Conductor baja los dos extintores de
                                                            PQS de 20 lbs y los deja a una
                                                            distancia prudencial.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta8" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta8" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta8"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">9</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica con el responsable de la descarga la
                                                            cantidad a descargar de acuerdo al nivel
                                                            del tanque.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta9" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta9" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta9"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">10</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor conecta el cable de puesta a tierra
                                                            asegurándose del buen contacto eléctrico del mismo,
                                                            para lo cual la pinza habrá de fijarse en un borne metálico
                                                            situado en el chasis del vehículo, donde
                                                            no existe restos de grasas, pintura ni óxido.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta10" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta10" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta10"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">11</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor verifica la presión en el tanque de la estación
                                                            y la comparará con la presión de la
                                                            cisterna.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta11" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta11" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta11"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">12</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor coloca el contometro en cero.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta12" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta12" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta12"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">13</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Si el conductor observa una diferencia de presión de ±40
                                                            lbs/plg² entre los tanques, el conductor
                                                            comunica el hecho al supervisor de distribución, para
                                                            recibir instrucciones antes de la inyección de
                                                            GLP.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta13" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta13" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta13"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">14</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor anota las condiciones iniciales del tanque de
                                                            la estación en la hoja de ruta (presión,
                                                            volumen y temperatura) así como las demás indicaciones del
                                                            documento.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta14" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta14" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta14"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">15</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Alrededor del punto de transferencia (7.6m. o 25 pies) se
                                                            apaga todo equipo de comunicación, así
                                                            como circuitos eléctricos que no sirvan para los fines de
                                                            descarga (radios, celulares, etc).

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta15" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta15" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta15"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">16</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Ninguna persona permanece en la cabina del camión durante la
                                                            descarga de GLP.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta16" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta16" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta16"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">17</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            EN LA DESCARGA El conductor abre la válvula del extremo de
                                                            la manguera tanto líquido como vapor (de
                                                            ser necesario) que se ajustan al tanque de la estación y
                                                            luego acciona las válvulas de descargo de
                                                            la cisterna.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta17" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta17" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta17"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">18</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor encorcha la toma de fuerza de la caja del
                                                            camión cisterna a la bomba de GLP y regula su
                                                            velocidad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta18" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta18" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta18"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">19</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El conductor observa el indicador de nivel (% de volumen)
                                                            del tanque de la estación para evitar un
                                                            sobrellenado del mismo.
                                                        </p>

                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta19" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta19" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta19"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">20</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            No se debe de superar el 85% del volumen total del tanque de
                                                            la estación.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta20" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta20" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta20"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">21</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor verifica frecuentemente los instrumentos de
                                                            control y de seguridad de la cisterna y del
                                                            tanque de la estación.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta21" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta21" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta21"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">22</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            AL FINALIZAR El conductor desciende de la unidad usando los
                                                            tres puntos de apoyo y luego recoge el
                                                            ticket de despacho del asiento del copiloto.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta22" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta22" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta22"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">23</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Se recogen los elementos de seguridad en forma ordenada,
                                                            dejando libre la zona para la salida del
                                                            camión.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta23" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta23" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta23"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">24</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            El Conductor realiza una inspección alrededor del camión y
                                                            del lugar, especialmente desde el área de
                                                            descarga del camión hasta la salida.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta24" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta24" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta24"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">25</th>
                                                    <td>
                                                        <p style="text-align: justify;">
                                                            Conductor sube al camión utilizando los tres puntos de
                                                            apoyo, se coloca el cinturón de seguridad.

                                                        </p>
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta25" value="SI">
                                                    </td>
                                                    <td> <input class="form-input" type="radio"
                                                            name="511_edit_txtPregunta25" value="NO"> </td>
                                                    <td> <input class="form-input" type="radio" name="511_edit_txtPregunta25"
                                                            value="N/A"> </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"></th>
                                                    <td>
                                                        <p>Otro :</p>
                                                        <textarea class="form-control rounded-0" name="511_edit_txtOtros"
                                                            rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                        </div> 

                        <div class="form-group col-md-1"></div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputEditarBuenasPracticas">Buenas Practicas</label> 
                                <textarea class="form-control" id="inputEditarBuenasPracticas" name="inputEditarBuenasPracticas"
                                placeholder="Ingrese Buenas Practicas"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputEditarDescripcionAdicional">Descripción Adicional</label> 
                                <textarea class="form-control" id="inputEditarDescripcionAdicional" name="inputEditarDescripcionAdicional"
                                placeholder="Ingrese Descripción Adicional"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEditarTipoHallazgo"> Tipo de Hallazgo</label> 
                                <select class="form-control" id="inputEditarTipoHallazgo" name="inputEditarTipoHallazgo">
                                    <option value="">Seleccione...</option>
                                    <option value="Auditoría">Auditoría</option>
                                    <option value="Incidente">Incidente</option>
                                    <option value="Accidentes">Accidentes</option>
                                    <option value="Reporte Cliente">Reporte Cliente</option>
                                    <option value="Opt">Opt</option>
                                    <option value="Acto Sub Estándar">Acto Sub Estándar</option>
                                    <option value="Condición Sub Estándar">Condición Sub Estándar</option>
                                    <option value="N.A.">N.A.</option>
                                </select>    
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEditarRelacionado">Relacionado con</label> 
                                <select class="form-control" id="inputEditarRelacionado" name="inputEditarRelacionado">
                                    <option value="">Seleccione...</option>
                                    <option value="Seguridad">Seguridad</option>
                                    <option value="Medio Ambiente">Medio Ambiente</option>
                                    <option value="Calidad">Calidad</option> 
                                </select>    
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputEditarCorreccion">Corrección</label> 
                                <textarea class="form-control" id="inputEditarCorreccion" name="inputEditarCorreccion"
                                placeholder="Ingrese Corrección"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEditarEvidencia1">Evidencia 1 (Foto) </label> 
                                    <input type="file"  class="nuevaFoto1" id="editarFoto1" name="editarFoto1">
                                    <p class="help-block">Peso máximo de la foto 4MB</p>
                                    <img src="vistas/img/sig/opt/default/no-image.png" class="img-thumbnail previsualizar1" width="200px">
                                    <input type="hidden" name="fotoActual1" id="fotoActual1">
                            </div>
                        </div>


                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEditarEvidencia2">Evidencia 2 (Foto) </label> 
                                    <input type="file" class="nuevaFoto2" id="editarFoto2" name="editarFoto2">
                                    <p class="help-block">Peso máximo de la foto 4MB</p>
                                    <img src="vistas/img/sig/opt/default/no-image.png" class="img-thumbnail previsualizar2" width="200px">
                                    <input type="hidden" name="fotoActual2" id="fotoActual2">
                            </div>
                        </div>

                        <input type="hidden" name="inputEditarUser" id="inputEditarUser" value="<?php echo $_SESSION["usu_id"]; ?>">

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Actualizar</button>
                </div>

                <?php
                $actualizarOpt = new ControladorOpts();
                $actualizarOpt -> ctrEditarOpt();
                ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php

  $eliminarOpt = new ControladorOpts();
  $eliminarOpt -> ctrEliminarOpt();

?>