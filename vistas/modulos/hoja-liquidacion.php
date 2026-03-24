<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hoja de Liquidacion</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Hoja de Liquidacion</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <button class="btn color-fondo-personalizado" data-toggle="modal" data-target="#modalAgregarHojaLiquidacion">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Hoja de Liquidacion
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped tablas">
                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Registro</th>
                                        <th>Fecha Salida</th>
                                        <th>Fecha Llegada</th>
                                        <th>Tracto</th>
                                        <th>Tolva</th>
                                        <th>Operacion</th>
                                        <th>Monto</th>
                                        <th>Empleado</th>
                                        <th>Ajustes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $hojas = ControladorHojaLiquidacion::ctrMostrarHojasLiquidacion($item, $valor);

                                    foreach ($hojas as $key => $value) {
                                        $tracto = ControladorVehiculos::ctrMostrarVehiculos('vehic_id', $value['hoja_vehic_tracto_id']);
                                        $tolva = ControladorVehiculos::ctrMostrarVehiculos('vehic_id', $value['hoja_vehic_tolva_id']);
                                        $empleado = ControladorEmpleados::ctrMostrarEmpleados('emple_id', $value['hoja_empleado_id']);

                                        $nombreEmpleado = 'N/A';
                                        if ($empleado) {
                                            $nombreEmpleado = trim(($empleado['emple_apellido_paterno'] ?? '') . ' ' . ($empleado['emple_apellido_materno'] ?? '') . ' ' . ($empleado['emple_nombres'] ?? ''));
                                            if ($nombreEmpleado === '') {
                                                $nombreEmpleado = $empleado['emple_numero_documento'] ?? 'N/A';
                                            }
                                        }

                                        echo '<tr>';
                                        echo '<td>' . ($key + 1) . '</td>';
                                        echo '<td>' . $value['hoja_numero_registro'] . '</td>';
                                        echo '<td>' . $value['hoja_fecha_salida'] . '</td>';
                                        echo '<td>' . $value['hoja_fecha_llegada'] . '</td>';
                                        echo '<td>' . ($tracto['vehic_placa'] ?? 'N/A') . '</td>';
                                        echo '<td>' . ($tolva['vehic_placa'] ?? 'N/A') . '</td>';
                                        echo '<td>' . $value['hoja_operacion'] . '</td>';
                                        echo '<td>S/ ' . number_format((float) $value['hoja_monto_recibido'], 2) . '</td>';
                                        echo '<td>' . $nombreEmpleado . '</td>';
                                        echo '<td>
                                            <div class="btn-group">
                                                <button class="btn btn-primary btnImprimirHojaLiquidacion" idHojaLiquidacion="' . $value['hoja_id'] . '"><i class="fa fa-print"></i></button>
                                                <button class="btn btn-warning btnEditarHojaLiquidacion" idHojaLiquidacion="' . $value['hoja_id'] . '" data-toggle="modal" data-target="#modalEditarHojaLiquidacion"><i class="fa fa-pencil"></i></button>
                                                <button class="btn btn-danger btnEliminarHojaLiquidacion" idHojaLiquidacion="' . $value['hoja_id'] . '"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </div>
                                        </td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Registro</th>
                                        <th>Fecha Salida</th>
                                        <th>Fecha Llegada</th>
                                        <th>Tracto</th>
                                        <th>Tolva</th>
                                        <th>Operacion</th>
                                        <th>Monto</th>
                                        <th>Empleado</th>
                                        <th>Ajustes</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador') { ?>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card card-danger card-outline collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-trash mr-1"></i> Papelera de Hojas de Liquidacion</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaPapeleraHojaLiquidacion" class="table table-bordered table-striped tablas">
                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Registro</th>
                                        <th>Tracto</th>
                                        <th>Tolva</th>
                                        <th>Fecha eliminacion</th>
                                        <th>Restaurar</th>
                                        <th>Depurar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $hojasEliminadas = ControladorHojaLiquidacion::ctrMostrarHojasLiquidacionEliminadas();
                                    if ($hojasEliminadas && count($hojasEliminadas) > 0) {
                                        foreach ($hojasEliminadas as $key => $value) {
                                            $tracto = ControladorVehiculos::ctrMostrarVehiculos('vehic_id', $value['hoja_vehic_tracto_id']);
                                            $tolva = ControladorVehiculos::ctrMostrarVehiculos('vehic_id', $value['hoja_vehic_tolva_id']);
                                            $nombreRegistro = $value['hoja_numero_registro'];
                                            echo '<tr>';
                                            echo '<td>' . ($key + 1) . '</td>';
                                            echo '<td>' . $value['hoja_numero_registro'] . '</td>';
                                            echo '<td>' . ($tracto['vehic_placa'] ?? 'N/A') . '</td>';
                                            echo '<td>' . ($tolva['vehic_placa'] ?? 'N/A') . '</td>';
                                            echo '<td>' . $value['hoja_fecha_delete'] . '</td>';
                                            echo '<td>
                                                <button class="btn btn-success btn-xs btnRestaurarHojaLiquidacion" idHojaLiquidacion="' . $value['hoja_id'] . '" nombreRegistro="' . htmlspecialchars($nombreRegistro, ENT_QUOTES) . '">
                                                    <i class="fa fa-undo"></i> Restaurar
                                                </button>
                                            </td>';
                                            echo '<td>
                                                <button class="btn btn-danger btn-xs btnDepurarHojaLiquidacion" idHojaLiquidacion="' . $value['hoja_id'] . '" nombreRegistro="' . htmlspecialchars($nombreRegistro, ENT_QUOTES) . '">
                                                    <i class="fa fa-times"></i> Depurar
                                                </button>
                                            </td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="7" class="text-center text-muted">No hay registros en la papelera</td></tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Registro</th>
                                        <th>Tracto</th>
                                        <th>Tolva</th>
                                        <th>Fecha eliminacion</th>
                                        <th>Restaurar</th>
                                        <th>Depurar</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if (isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador') { ?>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card card-secondary card-outline collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-history mr-1"></i> Auditoria de Hoja de Liquidacion</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaAuditoriaHojaLiquidacion" class="table table-bordered table-striped tablas">
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
                                    $auditoriasHoja = ControladorHojaLiquidacion::ctrMostrarAuditoriaHojaLiquidacion(300);
                                    if ($auditoriasHoja && count($auditoriasHoja) > 0) {
                                        foreach ($auditoriasHoja as $key => $value) {
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
                                    } else {
                                        echo '<tr><td colspan="7" class="text-center text-muted">No hay eventos de auditoria para mostrar</td></tr>';
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
            <?php } ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgregarHojaLiquidacion">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Registrar Hoja de Liquidacion</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <?php
                        $item = null;
                        $valor = null;
                        $vehiculos = ControladorVehiculos::ctrMostrarVehiculos($item, $valor);
                        $vehiculosTracto = array();
                        $vehiculosTolva = array();
                        foreach ($vehiculos as $vehiculoItem) {
                            $tipoVehiculo = strtoupper(trim($vehiculoItem['vehic_tipo'] ?? ''));
                            if ($tipoVehiculo === 'TRACTO') {
                                $vehiculosTracto[] = $vehiculoItem;
                            } elseif ($tipoVehiculo === 'TOLVA') {
                                $vehiculosTolva[] = $vehiculoItem;
                            }
                        }
                        ?>

                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>Numero de Registro</label>
                                <input type="text" class="form-control" id="inputNumeroRegistro" name="inputNumeroRegistro" value="<?php echo ControladorHojaLiquidacion::ctrObtenerSiguienteNumeroRegistro(); ?>" readonly>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Fecha de Salida <span class="text-danger">(*)</span></label>
                                <input type="date" class="form-control" id="inputFechaSalida" name="nuevaFechaSalida" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Fecha de Llegada <span class="text-danger">(*)</span></label>
                                <input type="date" class="form-control" id="inputFechaLlegada" name="nuevaFechaLlegada" required>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Tracto <span class="text-danger">(*)</span> </label>
                                <select class="form-control select2" id="inputPlaca" name="inputPlaca" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    foreach ($vehiculosTracto as $value) {
                                        echo '<option value="' . $value['vehic_id'] . '">' . $value['vehic_placa'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Tolva <span class="text-danger">(*)</span> </label>
                                <select class="form-control select2" id="inputTolva" name="inputTolva" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    foreach ($vehiculosTolva as $value) {
                                        echo '<option value="' . $value['vehic_id'] . '">' . $value['vehic_placa'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Operacion <span class="text-danger">(*)</span></label>
                                <select class="form-control select2" id="inputOperacion" name="inputOperacion" required>
                                    <option value="">Seleccione..</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $operacion = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor);
                                    foreach ($operacion as $key => $value) {
                                        echo '<option value="tabla' . $value['cenco_codigo'] . '">' . $value['cenco_codigo'] . ' ' . $value['cenco_nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Monto recibido <span class="text-danger">(*)</span></label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputMontoRecibido" name="inputMontoRecibido" placeholder="0.00" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Empleado <span class="text-danger">(*)</span></label>
                                <select class="form-control select2" id="inputEmpleado" name="inputEmpleado" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $empleado = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);
                                    foreach ($empleado as $key => $value) {
                                        echo '<option value="' . $value['emple_id'] . '">' . $value['emple_numero_documento'] . ' - ' . $value['emple_apellido_paterno'] . ' ' . $value['emple_apellido_materno'] . ' ' . $value['emple_nombres'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>G.R R</label>
                                <input type="text" class="form-control" id="inputGRRProducto" name="inputGRRProducto">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Producto</label>
                                <input type="text" class="form-control" id="inputProducto" name="inputProducto" >
                            </div>
                            <div class="form-group col-md-2">
                                <label>G.R R</label>
                                <input type="text" class="form-control" id="inputGRRServicioAdicional" name="inputGRRServicioAdicional" >
                            </div>
                            <div class="form-group col-md-2">
                                <label>Ser. Adicional</label>
                                <input type="text" class="form-control" id="inputSerAdicional" name="inputSerAdicional" >
                            </div>
                            <div class="form-group col-md-4">
                                <label>G.R TRANSPORTISTA</label>
                                <input type="text" class="form-control" id="inputGRTransportista" name="inputGRTransportista" >
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Peaje <span class="text-danger">(*)</span></label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputPeaje" name="inputPeaje" placeholder="0.00" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Boletas varias <span class="text-danger">(*)</span></label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputBoletasVarias" name="inputBoletasVarias" placeholder="0.00" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Boletas de consumo <span class="text-danger">(*)</span></label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputBoletasConsumo" name="inputBoletasConsumo" placeholder="0.00" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Planilla de movilidad <span class="text-danger">(*)</span></label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputPlanillaMovilidad" name="inputPlanillaMovilidad" placeholder="0.00" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Facturas varios <span class="text-danger">(*)</span></label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputFacturasVarios" name="inputFacturasVarios" placeholder="0.00" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Carga y descarga ladrillo <span class="text-danger">(*)</span></label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputCargaDescargaLadrillo" name="inputCargaDescargaLadrillo" placeholder="0.00" required>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>Reintegro</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputReintegro" name="inputReintegro" placeholder="0.00" required readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Vuelto</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputVuelto" name="inputVuelto" placeholder="0.00" required readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Suma Total</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputSumaTotal" name="inputSumaTotal" placeholder="0.00" required readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Observaciones</label>
                                <textarea class="form-control" id="inputObservaciones" name="inputObservaciones" rows="1" placeholder="Observaciones..."></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>KM Salida</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputKMSalida" name="inputKMSalida" placeholder="0.00" >
                            </div>
                            <div class="form-group col-md-2">
                                <label>KM Llegada</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputKMLlegada" name="inputKMLlegada" placeholder="0.00" >
                            </div>
                            <div class="form-group col-md-2">
                                <label>C.V Grifo</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputCVGrifo" name="inputCVGrifo" placeholder="0.00" >
                            </div>
                            <div class="form-group col-md-2">
                                <label>C.V EQ</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputCVEQ" name="inputCVEQ" placeholder="0.00" >
                            </div>
                            <div class="form-group col-md-2">
                                <label>Total KM</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputTotalKM" name="inputTotalKM" placeholder="0.00" >
                            </div>
                            <div class="form-group col-md-2">
                                <label>Variacion</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputVariacion" name="inputVariacion" placeholder="0.00" >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado">Guardar Movimiento</button>
                </div>

                <?php
                $crearHojaLiquidacion = new ControladorHojaLiquidacion();
                $crearHojaLiquidacion->ctrCrearHojaLiquidacion();
                ?>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarHojaLiquidacion">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Editar Hoja de Liquidacion</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" class="form-control" id="inputEditId" name="inputEditId">

                        <?php
                        $item = null;
                        $valor = null;
                        $vehiculosEdit = ControladorVehiculos::ctrMostrarVehiculos($item, $valor);
                        $vehiculosTractoEdit = array();
                        $vehiculosTolvaEdit = array();
                        foreach ($vehiculosEdit as $vehiculoItem) {
                            $tipoVehiculo = strtoupper(trim($vehiculoItem['vehic_tipo'] ?? ''));
                            if ($tipoVehiculo === 'TRACTO') {
                                $vehiculosTractoEdit[] = $vehiculoItem;
                            } elseif ($tipoVehiculo === 'TOLVA') {
                                $vehiculosTolvaEdit[] = $vehiculoItem;
                            }
                        }
                        ?>

                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>Numero de Registro</label>
                                <input type="text" class="form-control" id="inputEditNumeroRegistro" name="inputEditNumeroRegistro" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Fecha de Salida <span class="text-danger">(*)</span></label>
                                <input type="date" class="form-control" id="inputEditFechaSalida" name="inputEditFechaSalida" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Fecha de Llegada <span class="text-danger">(*)</span></label>
                                <input type="date" class="form-control" id="inputEditFechaLlegada" name="inputEditFechaLlegada" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Tracto <span class="text-danger">(*)</span> </label>
                                <select class="form-control select2" id="inputEditPlaca" name="inputEditPlaca" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    foreach ($vehiculosTractoEdit as $value) {
                                        echo '<option value="' . $value['vehic_id'] . '">' . $value['vehic_placa'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Tolva <span class="text-danger">(*)</span> </label>
                                <select class="form-control select2" id="inputEditTolva" name="inputEditTolva" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    foreach ($vehiculosTolvaEdit as $value) {
                                        echo '<option value="' . $value['vehic_id'] . '">' . $value['vehic_placa'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Operacion <span class="text-danger">(*)</span></label>
                                <select class="form-control select2" id="inputEditOperacion" name="inputEditOperacion" required>
                                    <option value="">Seleccione..</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $operacion = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor);
                                    foreach ($operacion as $key => $value) {
                                        echo '<option value="tabla' . $value['cenco_codigo'] . '">' . $value['cenco_codigo'] . ' ' . $value['cenco_nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Monto recibido <span class="text-danger">(*)</span></label>
                                <input type="number" step="0.01" min="0" class="form-control" id="inputEditMontoRecibido" name="inputEditMontoRecibido" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Empleado <span class="text-danger">(*)</span></label>
                                <select class="form-control select2" id="inputEditEmpleado" name="inputEditEmpleado" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $empleado = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);
                                    foreach ($empleado as $key => $value) {
                                        echo '<option value="' . $value['emple_id'] . '">' . $value['emple_numero_documento'] . ' - ' . $value['emple_apellido_paterno'] . ' ' . $value['emple_apellido_materno'] . ' ' . $value['emple_nombres'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2"><label>G.R R</label><input type="text" class="form-control" id="inputEditGRRProducto" name="inputEditGRRProducto"></div>
                            <div class="form-group col-md-2"><label>Producto</label><input type="text" class="form-control" id="inputEditProducto" name="inputEditProducto"></div>
                            <div class="form-group col-md-2"><label>G.R R</label><input type="text" class="form-control" id="inputEditGRRServicioAdicional" name="inputEditGRRServicioAdicional"></div>
                            <div class="form-group col-md-2"><label>Ser. Adicional</label><input type="text" class="form-control" id="inputEditSerAdicional" name="inputEditSerAdicional"></div>
                            <div class="form-group col-md-4"><label>G.R TRANSPORTISTA</label><input type="text" class="form-control" id="inputEditGRTransportista" name="inputEditGRTransportista"></div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4"><label>Peaje <span class="text-danger">(*)</span></label><input type="number" step="0.01" min="0" class="form-control" id="inputEditPeaje" name="inputEditPeaje" required></div>
                            <div class="form-group col-md-4"><label>Boletas varias <span class="text-danger">(*)</span></label><input type="number" step="0.01" min="0" class="form-control" id="inputEditBoletasVarias" name="inputEditBoletasVarias" required></div>
                            <div class="form-group col-md-4"><label>Boletas de consumo <span class="text-danger">(*)</span></label><input type="number" step="0.01" min="0" class="form-control" id="inputEditBoletasConsumo" name="inputEditBoletasConsumo" required></div>
                            <div class="form-group col-md-4"><label>Planilla de movilidad <span class="text-danger">(*)</span></label><input type="number" step="0.01" min="0" class="form-control" id="inputEditPlanillaMovilidad" name="inputEditPlanillaMovilidad" required></div>
                            <div class="form-group col-md-4"><label>Facturas varios <span class="text-danger">(*)</span></label><input type="number" step="0.01" min="0" class="form-control" id="inputEditFacturasVarios" name="inputEditFacturasVarios" required></div>
                            <div class="form-group col-md-4"><label>Carga y descarga ladrillo <span class="text-danger">(*)</span></label><input type="number" step="0.01" min="0" class="form-control" id="inputEditCargaDescargaLadrillo" name="inputEditCargaDescargaLadrillo" required></div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2"><label>Reintegro</label><input type="number" step="0.01" min="0" class="form-control" id="inputEditReintegro" name="inputEditReintegro" required readonly></div>
                            <div class="form-group col-md-2"><label>Vuelto</label><input type="number" step="0.01" min="0" class="form-control" id="inputEditVuelto" name="inputEditVuelto" required readonly></div>
                            <div class="form-group col-md-2"><label>Suma Total</label><input type="number" step="0.01" min="0" class="form-control" id="inputEditSumaTotal" name="inputEditSumaTotal" required readonly></div>
                            <div class="form-group col-md-6"><label>Observaciones</label><textarea class="form-control" id="inputEditObservaciones" name="inputEditObservaciones" rows="1"></textarea></div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2"><label>KM Salida</label><input type="number" step="0.01" min="0" class="form-control" id="inputEditKMSalida" name="inputEditKMSalida"></div>
                            <div class="form-group col-md-2"><label>KM Llegada</label><input type="number" step="0.01" min="0" class="form-control" id="inputEditKMLlegada" name="inputEditKMLlegada"></div>
                            <div class="form-group col-md-2"><label>C.V Grifo</label><input type="number" step="0.01" min="0" class="form-control" id="inputEditCVGrifo" name="inputEditCVGrifo"></div>
                            <div class="form-group col-md-2"><label>C.V EQ</label><input type="number" step="0.01" min="0" class="form-control" id="inputEditCVEQ" name="inputEditCVEQ"></div>
                            <div class="form-group col-md-2"><label>Total KM</label><input type="number" step="0.01" min="0" class="form-control" id="inputEditTotalKM" name="inputEditTotalKM"></div>
                            <div class="form-group col-md-2"><label>Variacion</label><input type="number" step="0.01" min="0" class="form-control" id="inputEditVariacion" name="inputEditVariacion"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado">Guardar Cambios</button>
                </div>

                <?php
                $editarHojaLiquidacion = new ControladorHojaLiquidacion();
                $editarHojaLiquidacion->ctrEditarHojaLiquidacion();
                ?>
            </form>
        </div>
    </div>
</div>

<?php
$eliminarHojaLiquidacion = new ControladorHojaLiquidacion();
$eliminarHojaLiquidacion->ctrEliminarHojaLiquidacion();
?>
