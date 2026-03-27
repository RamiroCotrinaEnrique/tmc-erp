
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Movimiento de Caja</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Tablero Administrar Movimiento de Caja</li>
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
                                data-target="#modalAgregarMovimientoCaja">
                                <i class="fa fa-plus" aria-hidden="true"></i> Nuevo Movimiento </button>
                        </div>
                        <div class="card-body">
                            <?php
                                $item = null;
                                $valor = null;
                                $movimientos = ControladorMovimientoCaja::ctrMostrarMovimientoCaja($item, $valor);
                                $movimientosPorSerie = array();

                                foreach ($movimientos as $movimiento) {
                                    $serieMovimiento = isset($movimiento['movi_serie']) ? trim($movimiento['movi_serie']) : 'SIN-SERIE';

                                    if (!isset($movimientosPorSerie[$serieMovimiento])) {
                                        $movimientosPorSerie[$serieMovimiento] = array();
                                    }

                                    $movimientosPorSerie[$serieMovimiento][] = $movimiento;
                                }

                                ksort($movimientosPorSerie);
                            ?>

                            <?php if (!empty($movimientosPorSerie)) { ?>
                                <ul class="nav nav-tabs mb-3" id="tabSeriesMovimientoCaja" role="tablist">
                                    <?php $indiceSerie = 0; ?>
                                    <?php foreach ($movimientosPorSerie as $serie => $listaSerie) { ?>
                                        <?php
                                            $serieSlug = preg_replace('/[^A-Za-z0-9\-_]/', '-', $serie);
                                            $tabId = 'serie-tab-' . $serieSlug;
                                            $panelId = 'serie-panel-' . $serieSlug;
                                        ?>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link <?php echo $indiceSerie === 0 ? 'active' : ''; ?>"
                                               id="<?php echo $tabId; ?>"
                                               data-toggle="tab"
                                               href="#<?php echo $panelId; ?>"
                                               role="tab"
                                               aria-controls="<?php echo $panelId; ?>"
                                               aria-selected="<?php echo $indiceSerie === 0 ? 'true' : 'false'; ?>">
                                                Serie <?php echo htmlspecialchars($serie); ?>
                                            </a>
                                        </li>
                                        <?php $indiceSerie++; ?>
                                    <?php } ?>
                                </ul>

                                <div class="tab-content" id="tabSeriesMovimientoCajaContenido">
                                    <?php $indiceSerie = 0; ?>
                                    <?php foreach ($movimientosPorSerie as $serie => $listaSerie) { ?>
                                        <?php
                                            $serieSlug = preg_replace('/[^A-Za-z0-9\-_]/', '-', $serie);
                                            $panelId = 'serie-panel-' . $serieSlug;
                                            $tablaId = 'tabla-movimientos-serie-' . $serieSlug;
                                        ?>
                                        <div class="tab-pane fade <?php echo $indiceSerie === 0 ? 'show active' : ''; ?>"
                                             id="<?php echo $panelId; ?>"
                                             role="tabpanel">
                                            <div class="table-responsive">
                                                <table id="<?php echo $tablaId; ?>" class="table table-bordered table-striped tablas tablaMovimientoSerie">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:10px">#</th>
                                                            <th>Tipo</th>
                                                            <th>Serie</th>
                                                            <th>Número</th>
                                                            <th>Moneda</th>
                                                            <th>Fecha</th>
                                                            <th>Empleado</th>
                                                            <th>Total</th>
                                                            <th>Ajustes</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($listaSerie as $key => $value) { ?>
                                                            <tr>
                                                                <td><?php echo $key + 1; ?></td>
                                                                <td><?php echo htmlspecialchars($value['movi_tipo']); ?></td>
                                                                <td><?php echo htmlspecialchars($value['movi_serie']); ?></td>
                                                                <td><?php echo htmlspecialchars($value['movi_numero']); ?></td>
                                                                <td><?php echo htmlspecialchars($value['movi_moneda']); ?></td>
                                                                <td><?php echo htmlspecialchars($value['movi_fecha']); ?></td>
                                                                <td><?php echo htmlspecialchars($value['movi_emple_id']); ?></td>
                                                                <td><?php echo htmlspecialchars($value['movi_total']); ?></td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-primary btnImprimirMovimientoCaja" idMovimientoCaja="<?php echo $value['movi_id']; ?>" > <i class="fa fa-print"></i> </button>  
                                                                        <button class="btn btn-warning btnEditarMovimientoCaja" idMovimientoCaja="<?php echo $value['movi_id']; ?>" data-toggle="modal" data-target="#modalEditarMovimientoCaja"> <i class="fa fa-pencil"></i> </button>
                                                                        <button class="btn btn-danger btnEliminarMovimientoCaja" idMovimientoCaja="<?php echo $value['movi_id']; ?>"> <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th style="width:10px">#</th>
                                                            <th>Tipo</th>
                                                            <th>Serie</th>
                                                            <th>Número</th>
                                                            <th>Moneda</th>
                                                            <th>Fecha</th>
                                                            <th>Empleado</th>
                                                            <th>Total</th>
                                                            <th>Ajustes</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <?php $indiceSerie++; ?>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-light border mb-0">
                                    No hay movimientos registrados para mostrar.
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->

            <?php if (isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador') { ?>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card card-danger card-outline collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-trash mr-1"></i> Papelera de Movimientos</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive"> 
                                <table id="tablaPapeleraMovimientos" class="table table-bordered table-striped tablas">
                                    <thead>
                                        <tr>
                                            <th style="width:10px">#</th>
                                            <th>Tipo</th>
                                            <th>Serie</th>
                                            <th>Número</th>
                                            <th>Moneda</th>
                                            <th>Fecha</th>
                                            <th>Empleado</th>
                                            <th>Total</th>
                                            <th>Fecha eliminación</th>
                                            <th>Restaurar</th>
                                            <th>Depurar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $movimientosEliminados = ControladorMovimientoCaja::ctrMostrarMovimientoCajaEliminados();
                                        if($movimientosEliminados && count($movimientosEliminados) > 0){
                                            foreach($movimientosEliminados as $key => $value){
                                                $nombreMovimiento = trim($value['movi_tipo'].' '.$value['movi_serie'].'-'.$value['movi_numero']);
                                                echo '<tr>';
                                                echo '<td>'.($key+1).'</td>';
                                                echo '<td>'.htmlspecialchars($value['movi_tipo']).'</td>';
                                                echo '<td>'.htmlspecialchars($value['movi_serie']).'</td>';
                                                echo '<td>'.htmlspecialchars($value['movi_numero']).'</td>';
                                                echo '<td>'.htmlspecialchars($value['movi_moneda']).'</td>';
                                                echo '<td>'.htmlspecialchars($value['movi_fecha']).'</td>';
                                                echo '<td>'.htmlspecialchars($value['movi_emple_id']).'</td>';
                                                echo '<td>'.htmlspecialchars($value['movi_total']).'</td>';
                                                echo '<td>'.htmlspecialchars($value['movi_fecha_delete']).'</td>';
                                                echo '<td>
                                                    <button class="btn btn-success btn-xs btnRestaurarMovimientoCaja" idMovimientoCaja="'.$value['movi_id'].'" nombreMovimiento="'.htmlspecialchars($nombreMovimiento, ENT_QUOTES).'">
                                                        <i class="fa fa-undo"></i> Restaurar
                                                    </button>
                                                </td>';
                                                echo '<td>
                                                    <button class="btn btn-danger btn-xs btnDepurarMovimientoCaja" idMovimientoCaja="'.$value['movi_id'].'" nombreMovimiento="'.htmlspecialchars($nombreMovimiento, ENT_QUOTES).'">
                                                        <i class="fa fa-times"></i> Depurar
                                                    </button>
                                                </td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="width:10px">#</th>
                                            <th>Tipo</th>
                                            <th>Serie</th>
                                            <th>Número</th>
                                            <th>Moneda</th>
                                            <th>Fecha</th>
                                            <th>Empleado</th>
                                            <th>Total</th>
                                            <th>Fecha eliminación</th>
                                            <th>Restaurar</th>
                                            <th>Depurar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card card-secondary card-outline collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-history mr-1"></i> Auditoria de Movimiento de Caja</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive"> 
                                <table id="tablaAuditoriaMovimientoCaja" class="table table-bordered table-striped tablas">
                                    <thead>
                                        <tr>
                                            <th style="width:10px">#</th>
                                            <th>Fecha</th>
                                            <th>Accion</th>
                                            <th>Registro</th>
                                            <th>Usuario</th>
                                            <th>IP</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $auditoriasMovimiento = ControladorMovimientoCaja::ctrMostrarAuditoriaMovimientoCaja(300);
                                        if ($auditoriasMovimiento && count($auditoriasMovimiento) > 0) {
                                            foreach ($auditoriasMovimiento as $key => $value) {
                                                $usuarioTexto = 'Sistema';
                                                if (!empty($value['usu_usuario'])) {
                                                    $usuarioTexto = $value['usu_usuario'];
                                                    if (!empty($value['usu_nombre'])) {
                                                        $usuarioTexto .= ' - ' . $value['usu_nombre'];
                                                    }
                                                } elseif (!empty($value['aud_usuario_id'])) {
                                                    $usuarioTexto = 'ID ' . $value['aud_usuario_id'];
                                                }

                                                $detalleTexto = '';
                                                if (!empty($value['aud_detalle_json'])) {
                                                    $detalle = json_decode($value['aud_detalle_json'], true);
                                                    if (json_last_error() === JSON_ERROR_NONE && is_array($detalle)) {
                                                        if (!empty($detalle['campos_cambiados']) && is_array($detalle['campos_cambiados'])) {
                                                            $detalleTexto = 'Campos: ' . implode(', ', array_keys($detalle['campos_cambiados']));
                                                        } elseif (!empty($detalle['despues'])) {
                                                            $detalleTexto = 'Se registro estado despues del evento';
                                                        } elseif (!empty($detalle['antes'])) {
                                                            $detalleTexto = 'Se registro estado previo del evento';
                                                        }
                                                    }

                                                    if ($detalleTexto === '') {
                                                        $detalleTexto = substr($value['aud_detalle_json'], 0, 220);
                                                    }
                                                }

                                                echo '<tr>';
                                                echo '<td>' . ($key + 1) . '</td>';
                                                echo '<td>' . htmlspecialchars((string) $value['aud_fecha_evento']) . '</td>';
                                                echo '<td><span class="badge badge-info">' . htmlspecialchars((string) $value['aud_accion']) . '</span></td>';
                                                echo '<td>' . htmlspecialchars((string) $value['aud_entidad_id']) . '</td>';
                                                echo '<td>' . htmlspecialchars($usuarioTexto) . '</td>';
                                                echo '<td>' . htmlspecialchars((string) ($value['aud_ip_origen'] ?? '')) . '</td>';
                                                echo '<td>' . htmlspecialchars($detalleTexto) . '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="width:10px">#</th>
                                            <th>Fecha</th>
                                            <th>Accion</th>
                                            <th>Registro</th>
                                            <th>Usuario</th>
                                            <th>IP</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </tfoot>
                                </table>                                
                            </div>
                            
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
MODAL AGREGAR MOVIMIENTO DE CAJA
======================================-->
<div class="modal fade" id="modalAgregarMovimientoCaja">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form role="form" method="post" id="formAgregarMovimientoCaja">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Nuevo Movimiento de Caja</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row">

                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label for="inputTipo">Tipo</label> 
                                <select class="form-control" id="inputTipo" name="inputTipo" required>
                                <option value="">Seleccione...</option>
                                <option value="INGRESO">INGRESO</option>
                                <option value="EGRESO">EGRESO</option>
                                </select>    
                            </div>
                        </div> 

                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label for="inputMoneda">Moneda</label> 
                                <select class="form-control" id="inputMoneda" name="inputMoneda" required>
                                <option value="">Seleccione...</option>
                                <option value="SOLES">SOLES</option>
                                <option value="DOLARES">DOLARES</option>
                                </select>    
                            </div>
                        </div> 

                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label for="inputSerie">Serie</label> 
                                <select class="form-control" id="inputSerie" name="inputSerie" required>
                                <option value="">Seleccione...</option>
                                </select>    
                            </div>
                        </div> 

                        

                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label for="inputFecha">Fecha <span class="text-danger">(*)</span> </label>
                                <div class="input-group date" id="fechaDatePicker"
                                            data-target-input="nearest">
                                    <input type="date" name="fecha" class="form-control" required>
                                </div>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputEmpleado">Empleado</label> 
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


                        <div class="form-group col-md-12">
                                <label>Detalle de Movimiento</label>                            
                        </div>
                        <div class="form-group col-md-12 text-right">
                            <button type="button" class="btn btn-success" id="btnAgregarDetalle">Agregar detalle</button>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <table id="example2" class="table table-bordered table-striped tablas">
                                    <thead>
                                        <tr>
                                            <th>Ítem</th>
                                            <th>Descripción</th>
                                            <th>Importe</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalleMovimiento">
                                        <!-- Aquí se agregarán los detalles dinámicamente -->

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="row justify-content-end">
                                <div class="col-md-4">
                                    <label for="totalDetalleReferencial" class="mb-1"><strong>Total</strong></label>
                                    <input type="text" id="totalDetalleReferencial" class="form-control" value="0.00" readonly>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
            $crearMovimiento = new ControladorMovimientoCaja();
            $crearMovimiento -> ctrCrearMovimientoCaja();
            ?>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!--=====================================
MODAL EDITAR MOVIMIENTO DE CAJA
======================================-->
<div class="modal fade" id="modalEditarMovimientoCaja">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">

            <form role="form" method="post" id="formEditarMovimientoCaja">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Actualizar Movimiento de Caja</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" class="form-control" name="inputEditId" id="inputEditId">

                    <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="inputEditTipo">Tipo</label>
                            <input type="text" class="form-control" id="inputEditTipo" name="inputEditTipo"
                                   readonly style="background-color:#e9ecef;cursor:not-allowed;"
                                   title="El tipo no se puede modificar una vez registrado el movimiento">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEditMoneda">Moneda</label>
                            <input type="text" class="form-control" id="inputEditMoneda" name="inputEditMoneda"
                                   readonly style="background-color:#e9ecef;cursor:not-allowed;"
                                   title="La moneda no se puede modificar una vez registrado el movimiento">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEditSerie">Serie</label>
                            <input type="text" class="form-control" id="inputEditSerie" name="inputEditSerie"
                                   readonly style="background-color:#e9ecef;cursor:not-allowed;"
                                   title="La serie no se puede modificar una vez registrado el movimiento">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEditNumero">Numero</label>
                            <input type="text" class="form-control" id="inputEditNumero" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEditFecha">Fecha</label>
                            <input type="date" class="form-control" id="inputEditFecha" name="inputEditFecha" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEditTotal">Total</label>
                            <input type="text" class="form-control" id="inputEditTotal" readonly>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputEditEmpleado">Empleado</label>
                            <select class="form-control select2" id="inputEditEmpleado" name="inputEditEmpleado" required>
                                <option value="">Seleccione...</option>
                                <?php
                                $item = null;
                                $valor = null;
                                $empleado = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);
                                foreach ($empleado as $key => $value) {
                                    echo '<option value="'.$value["emple_id"].'">'.$value["emple_numero_documento"]." - ".$value["emple_apellido_paterno"]." ".$value["emple_apellido_materno"]." ".$value["emple_nombres"].'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Detalle de Movimiento</label>
                        </div>

                        <div class="form-group col-md-12 text-right">
                            <button type="button" class="btn btn-success" id="btnAgregarDetalleEdit">Agregar detalle</button>
                        </div>

                        <div class="form-group col-md-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Descripcion</th>
                                        <th>Importe</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="detalleMovimientoEdit"></tbody>
                            </table>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
            $editarMovimiento = new ControladorMovimientoCaja();
            $editarMovimiento -> ctrEditarMovimientoCaja();
        ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php

    $eliminarMovimiento = new ControladorMovimientoCaja();
    $eliminarMovimiento -> ctrEliminarMovimientoCaja();

?>