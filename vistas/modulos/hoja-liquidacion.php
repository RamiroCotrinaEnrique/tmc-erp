
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hoja de Liquidación</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Hoja de Liquidación</li>
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
                                data-target="#modalAgregarHojaLiquidacion">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Hoja de Liquidación </button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped tablas">

                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th> 
                                        <th>Área</th>
                                        <th>Ajustes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                            $item = null;
                                            $valor = null;
                                            $areas = ControladorAreas::ctrMostrarAreas($item, $valor);
                                            
                                            foreach ($areas as $key => $value) {
                                                echo '
                                                <tr>
                                                <td>'.($key+1).'</td>                                               
                                                <td>'.$value["are_nombre"].'</td>                                                
                                                <td>
                                                <div class="btn-group">                          
                                                    <button class="btn btn-warning btnEditarArea" idArea="'.$value["are_id"].'" data-toggle="modal" data-target="#modalEditarArea"> <i class="fa fa-pencil"></i>  </button>
                                                    <button class="btn btn-danger btnEliminarArea" idArea="'.$value["are_id"].'"> <i class="fa fa-trash-o" aria-hidden="true"></i>   </button>';
                                                echo'
                                                </div>  
                                                </td>
                                            </tr>
                                                ';

                                            }
                                            ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width:10px">#</th> 
                                        <th>Área</th>
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

            <?php if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){ ?>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card card-danger card-outline collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-trash mr-1"></i> Papelera de Áreas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaPapeleraAreas" class="table table-bordered table-striped tablas">
                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Área</th>
                                        <th>Fecha eliminación</th>
                                        <th>Restaurar</th>
                                        <?php if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){ ?>
                                        <th>Depurar</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $areasEliminadas = ControladorAreas::ctrMostrarAreasEliminadas();
                                    if($areasEliminadas && count($areasEliminadas) > 0){
                                        foreach($areasEliminadas as $key => $value){
                                            echo '<tr>';
                                            echo '<td>'.($key+1).'</td>';
                                            echo '<td>'.$value["are_nombre"].'</td>';
                                            echo '<td>'.$value["are_fecha_delete"].'</td>';
                                            echo '<td>
                                                <button class="btn btn-success btn-xs btnRestaurarArea"
                                                    idArea="'.$value["are_id"].'"
                                                    nombreArea="'.htmlspecialchars($value["are_nombre"], ENT_QUOTES).'">
                                                    <i class="fa fa-undo"></i> Restaurar
                                                </button>
                                            </td>';
                                            if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){
                                                echo '<td>
                                                    <button class="btn btn-danger btn-xs btnDepurarArea"
                                                        idArea="'.$value["are_id"].'"
                                                        nombreArea="'.htmlspecialchars($value["are_nombre"], ENT_QUOTES).'">
                                                        <i class="fa fa-times"></i> Depurar
                                                    </button>
                                                </td>';
                                            }
                                            echo '</tr>';
                                        }
                                    }else{
                                        $colspanPapelera = (isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador') ? 5 : 4;
                                        echo '<tr><td colspan="'.$colspanPapelera.'" class="text-center text-muted">No hay áreas en la papelera</td></tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Área</th>
                                        <th>Fecha eliminación</th>
                                        <th>Restaurar</th>
                                        <?php if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){ ?>
                                        <th>Depurar</th>
                                        <?php } ?>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<!--=====================================
MODAL AGREGAR HOJA DE LIQUIDACIÓN
======================================-->

<div class="modal fade" id="modalAgregarHojaLiquidacion">
    <div class="modal-dialog modal-xl"> <div class="modal-content">

            <form role="form" method="post">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Registrar Hoja de Liquidación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>Número de Registro</label>
                                <input type="text" class="form-control" id="inputNumeroRegistro" name="inputNumeroRegistro" readonly required>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Fecha de Salida <span class="text-danger">(*)</span> </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" id="inputFechaSalida" name="nuevaFechaSalida" required>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Fecha de Llegada <span class="text-danger">(*)</span> </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" id="inputFechaLlegada" name="nuevaFechaLlegada" required>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Tracto</label>
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
                            <div class="form-group col-md-2">
                                <label>Tolva</label>
                                <select class="form-control select2" id="inputTolva" name="inputTolva" required>
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

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Operación</label>
                                <select class="form-control select2" id="inputOperacion" name="inputOperacion" required>
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

                            <div class="form-group col-md-3">
                                <label>Monto recibido </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputMontoRecibido" name="inputMontoRecibido" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Empleado</label>
                                <select class="form-control select2" id="inputEmpleado" name="inputEmpleado" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $item = null;
                                    $valor = null;                                      
                                    $empleado = ControladorEmpleados::ctrMostrarEmpleados($item, $valor); 
                                    //var_dump($categoria);
                                    foreach ($empleado as $key => $value) {
                                        echo '<option value="'.$value["emple_id"].'">'.$value["emple_numero_documento"]." - ".$value["emple_apellido_paterno"]." ".$value["emple_apellido_materno"]." ".$value["emple_nombres"].'</option>';
                                    }  
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>G.R REMISIÓN</label> 
                            </div>

                            <div class="form-group col-md-2">
                                <label>G.R R</label>
                                <input type="text" class="form-control" id="inputGRRProducto" name="inputGRRProducto" placeholder="G.R R" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Producto</label>
                                <input type="text" class="form-control" id="inputProducto" name="inputProducto" placeholder="Producto" required>
                            </div>

                            <div class="form-group col-md-2">
                                <label>G.R R</label>
                                <input type="text" class="form-control" id="inputGRRServicioAdicional" name="inputGRRServicioAdicional" placeholder="G.R R" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Ser. Adicional</label>
                                <input type="text" class="form-control" id="inputSerAdicional" name="inputSerAdicional" placeholder="Ser. Adicional" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>G.R TRANSPORTISTA</label>                                 
                                <input type="text" class="form-control" id="inputGRTransportista" name="inputGRTransportista" placeholder="G.R TRANSPORTISTA" required>
                            </div>
                        </div>

                        <div class="row">
                                                    
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>GASTOS</label> 
                            </div>
                            <div class="form-group col-md-2">
                                <label>Peaje </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputPeaje" name="inputPeaje" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Boletas varias </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputBoletasVarias" name="inputBoletasVarias" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Boletas de consumo </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputBoletasConsumo" name="inputBoletasConsumo" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Planilla de movilidad </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputPlanillaMovilidad" name="inputPlanillaMovilidad" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Facturas varios </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputFacturasVarios" name="inputFacturasVarios" placeholder="0.00" required>
                                </div>
                            </div> 
                        </div>

                        <div class="row"> 
                            <div class="form-group col-md-2">
                                <label>Reintegro </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputReintegro" name="inputReintegro" placeholder="0.00" required readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Vuelto </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputVuelto" name="inputVuelto" placeholder="0.00" required readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Suma Total </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputSumaTotal" name="inputSumaTotal" placeholder="0.00" required readonly>
                                </div>
                            </div> 
                            <div class="form-group col-md-6">
                                <label>Observaciones</label>
                            <textarea class="form-control" id="inputObservaciones" name="inputObservaciones" rows="1" placeholder="Observaciones..."></textarea>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>DATOS DE ABASTECIMIENTO</label> 
                            </div>

                            <div class="form-group col-md-2">
                                <label>KM Salida</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputKMSalida" name="inputKMSalida" placeholder="0.00" required> 
                            </div> 
                            <div class="form-group col-md-2">
                                <label>KM Llegada</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputKMLlegada" name="inputKMLlegada" placeholder="0.00" required> 
                            </div> 
                            <div class="form-group col-md-2">
                                <label>C.V Grifo</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputCVGrifo" name="inputCVGrifo" placeholder="0.00" required> 
                            </div> 
                            <div class="form-group col-md-2">
                                <label>C.V EQ</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputCVEQ" name="inputCVEQ" placeholder="0.00" required> 
                            </div> 
                            <div class="form-group col-md-2">
                                <label>Total KM</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputTotalKM" name="inputTotalKM" placeholder="0.00" required> 
                            </div> 
                            <div class="form-group col-md-2">
                                <label>Variación</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputVariacion" name="inputVariacion" placeholder="0.00" required> 
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado">Guardar Movimiento</button>
                </div>

                <?php
                    // Aquí llamarás a tu controlador de Rendición
                    
                ?>

            </form>
        </div>
    </div>
</div>

<!-- /.modal -->


<!--=====================================
MODAL EDITAR CENTRO COSTO
======================================-->
<div class="modal fade" id="modalEditarArea">
    <div class="modal-dialog">
        <div class="modal-content">

            <form role="form" method="post">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Editar Área</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" class="form-control" name="inputEditId" id="inputEditId">                     

                    <div class="form-group col-md-12">
                        <div class="form-group">
                            <label for="inputEditNombre">Área</label>
                            <input type="text" class="form-control" id="inputEditNombre" name="inputEditNombre" >
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
            $editarArea = new ControladorAreas();
            $editarArea -> ctrEditarArea();
        ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php

  $eliminarArea = new ControladorAreas();
  $eliminarArea -> ctrEliminarArea();

?>