<?php
$resumenesCaja = ControladorResumenCaja::ctrMostrarResumenCaja(null, null);
 ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Resumen de Caja</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Resumen de Caja</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <button class="btn color-fondo-personalizado" data-toggle="modal" data-target="#modalAgregarResumenCaja">
                                <i class="fa fa-plus" aria-hidden="true"></i> Registrar Cierre de Caja
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped tablas">
                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Fecha</th>
                                        <th>DNI</th>
                                        <th>Responsable</th>
                                        <th>Saldo Inicial</th>
                                        <th>Ingresos</th>
                                        <th>Egresos</th>
                                        <th>Saldo Final</th>
                                        <th>Items</th>
                                        <th>Observación</th>
                                        <th>Ajustes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($resumenesCaja) {
                                        foreach ($resumenesCaja as $key => $value) {
                                            echo '<tr>';
                                            echo '<td>' . ($key + 1) . '</td>';
                                            echo '<td>' . htmlspecialchars($value['resc_fecha'], ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td>' . htmlspecialchars($value['resc_dni'], ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td>' . htmlspecialchars($value['resc_responsable'], ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td>S/ ' . number_format((float) $value['resc_saldo_inicial'], 2) . '</td>';
                                            echo '<td>S/ ' . number_format((float) $value['resc_total_ingresos'], 2) . '</td>';
                                            echo '<td>S/ ' . number_format((float) $value['resc_total_egresos'], 2) . '</td>';
                                            echo '<td><strong>S/ ' . number_format((float) $value['resc_saldo_final'], 2) . '</strong></td>';
                                            echo '<td>' . (int) $value['resc_total_items'] . '</td>';
                                            echo '<td>' . htmlspecialchars((string) $value['resc_observacion'], ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td>
                                                <div class="btn-group">
                                                    <button class="btn btn-primary btnImprimirResumenCaja" idResumenCaja="' . (int) $value['resc_id'] . '">
                                                        <i class="fa fa-print"></i>
                                                    </button>
                                                    <button class="btn btn-success btnExportarResumenCajaExcel" idResumenCaja="' . (int) $value['resc_id'] . '">
                                                        <i class="fa fa-file-excel-o"></i>
                                                    </button>
                                                    <button class="btn btn-info btnVerResumenCaja" idResumenCaja="' . (int) $value['resc_id'] . '" data-toggle="modal" data-target="#modalVerResumenCaja">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-warning btnEditarResumenCaja" idResumenCaja="' . (int) $value['resc_id'] . '" data-toggle="modal" data-target="#modalEditarResumenCaja">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-danger btnEliminarResumenCaja" idResumenCaja="' . (int) $value['resc_id'] . '" fechaResumenCaja="' . htmlspecialchars($value['resc_fecha'], ENT_QUOTES, 'UTF-8') . '">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </td>';
                                            echo '</tr>';
                                        }
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Fecha</th>
                                        <th>DNI</th>
                                        <th>Responsable</th>
                                        <th>Saldo Inicial</th>
                                        <th>Ingresos</th>
                                        <th>Egresos</th>
                                        <th>Saldo Final</th>
                                        <th>Items</th>
                                        <th>Observación</th>
                                        <th>Ajustes</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){ ?>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card card-danger card-outline collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-trash mr-1"></i> Papelera de Cierres de Caja</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaPapeleraResumenCaja" class="table table-bordered table-striped tablas">
                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Fecha</th>
                                        <th>DNI</th>
                                        <th>Responsable</th>
                                        <th>Saldo Final</th>
                                        <th>Fecha eliminación</th>
                                        <th>Restaurar</th>
                                        <th>Depurar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $resumenesEliminados = ControladorResumenCaja::ctrMostrarResumenesCajaEliminados();
                                    if($resumenesEliminados && count($resumenesEliminados) > 0){
                                        foreach($resumenesEliminados as $key => $value){
                                            echo '<tr>';
                                            echo '<td>' . ($key + 1) . '</td>';
                                            echo '<td>' . htmlspecialchars((string) $value['resc_fecha'], ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td>' . htmlspecialchars((string) $value['resc_dni'], ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td>' . htmlspecialchars((string) $value['resc_responsable'], ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td>S/ ' . number_format((float) $value['resc_saldo_final'], 2) . '</td>';
                                            echo '<td>' . htmlspecialchars((string) $value['resc_fecha_delete'], ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td>
                                                <button class="btn btn-success btn-xs btnRestaurarResumenCaja"
                                                    idResumenCaja="' . (int) $value['resc_id'] . '"
                                                    fechaResumenCaja="' . htmlspecialchars((string) $value['resc_fecha'], ENT_QUOTES, 'UTF-8') . '">
                                                    <i class="fa fa-undo"></i> Restaurar
                                                </button>
                                            </td>';
                                            echo '<td>
                                                <button class="btn btn-danger btn-xs btnDepurarResumenCaja"
                                                    idResumenCaja="' . (int) $value['resc_id'] . '"
                                                    fechaResumenCaja="' . htmlspecialchars((string) $value['resc_fecha'], ENT_QUOTES, 'UTF-8') . '">
                                                    <i class="fa fa-times"></i> Depurar
                                                </button>
                                            </td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="8" class="text-center text-muted">No hay cierres en la papelera</td></tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Fecha</th>
                                        <th>DNI</th>
                                        <th>Responsable</th>
                                        <th>Saldo Final</th>
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

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card card-secondary card-outline collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-history mr-1"></i> Auditoria de Resumen de Caja</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaAuditoriaResumenCaja" class="table table-bordered table-striped tablas">
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
                                    $auditoriasResumen = ControladorResumenCaja::ctrMostrarAuditoriaResumenCaja(300);
                                    if ($auditoriasResumen && count($auditoriasResumen) > 0) {
                                        foreach ($auditoriasResumen as $key => $value) {
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
                                            echo '<td>' . htmlspecialchars((string) $value['aud_fecha_evento'], ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td><span class="badge badge-info">' . htmlspecialchars((string) $value['aud_accion'], ENT_QUOTES, 'UTF-8') . '</span></td>';
                                            echo '<td>' . htmlspecialchars((string) $value['aud_entidad_id'], ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td>' . htmlspecialchars($usuarioTexto, ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td>' . htmlspecialchars((string) ($value['aud_ip_origen'] ?? ''), ENT_QUOTES, 'UTF-8') . '</td>';
                                            echo '<td>' . htmlspecialchars($detalleTexto, ENT_QUOTES, 'UTF-8') . '</td>';
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
    </section>
</div>

<div class="modal fade" id="modalAgregarResumenCaja">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form role="form" method="post" id="formAgregarResumenCaja">
                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Registrar Cierre de Caja</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>Año</label>
                                <input type="number" class="form-control" id="inputAnioResumen" name="nuevoAnioResumen" min="2020" max="2100" value="<?php echo date('Y'); ?>" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Mes</label>
                                <select class="form-control select2" name="nuevoMesResumen" id="selectMesNuevo" required>
                                    <option value="">Seleccione...</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Día</label>
                                <input type="number" class="form-control" id="inputDiaNuevo" name="nuevoDia" min="1" max="31" required>
                                <div class="invalid-feedback" id="feedbackDiaNuevo"></div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>DNI</label>
                                <input type="text" class="form-control" id="inputDniResumenCaja" name="nuevoDNI" placeholder="Ej. 12345678" maxlength="20" required>
                                <small id="helpDniResumenCaja" class="form-text text-muted" style="display:none;"></small>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Apellidos y Nombres</label>
                                <input type="text" class="form-control" id="inputResponsableResumenCaja" name="nuevaApellidosNombres" placeholder="Ej. Juan Pérez" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Saldo de Fondo Fijo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputSaldoFondoFijo" name="inputSaldoFondoFijo" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Total de Ingresos</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputTotalIngresos" name="inputTotalIngresos" placeholder="0.00" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Total de Gastos</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputTotalGastos" name="inputTotalGastos" placeholder="0.00" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Nuevo Saldo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" id="inputNuevoSaldo" name="inputNuevoSaldo" placeholder="0.00" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 mb-0">
                                <label>Detalle del Cierre</label>
                            </div>
                            <div class="form-group col-md-12 pb-0 mb-2">
                                <div id="alertaEstadoCierre" class="alert alert-warning mb-0" style="display:none;"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ÍTEM</th>
                                                <th>FECHA</th>
                                                <th>TIPO DOC</th>
                                                <th>NRO DOC</th>
                                                <th>RAZON SOCIAL</th>
                                                <th>CONCEPTO</th>
                                                <th>INGRESO</th>
                                                <th>EGRESO</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detalleCaja"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Observaciones</label>
                                <textarea class="form-control" name="nuevaObservacion" rows="2" placeholder="Ingrese sus observaciones"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" id="btnGuardarCierreCaja" class="btn color-fondo-personalizado">Guardar Cierre</button>
                </div>

                <?php
                $crearResumenCaja = new ControladorResumenCaja();
                $crearResumenCaja->ctrCrearResumenCaja();
                ?>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarResumenCaja">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Editar Cierre de Caja</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="inputEditResumenCajaId" name="inputEditResumenCajaId">

                    <div class="form-group">
                        <label for="inputEditFechaResumenCaja">Fecha del cierre</label>
                        <input type="text" class="form-control" id="inputEditFechaResumenCaja" readonly>
                    </div>

                    <div class="form-group">
                        <label for="inputEditDniResumenCaja">DNI</label>
                        <input type="text" class="form-control" id="inputEditDniResumenCaja" name="inputEditDniResumenCaja" required>
                    </div>

                    <div class="form-group">
                        <label for="inputEditResponsableResumenCaja">Responsable</label>
                        <input type="text" class="form-control" id="inputEditResponsableResumenCaja" name="inputEditResponsableResumenCaja" required>
                    </div>

                    <div class="form-group mb-0">
                        <label for="inputEditObservacionResumenCaja">Observación</label>
                        <textarea class="form-control" id="inputEditObservacionResumenCaja" name="inputEditObservacionResumenCaja" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado">Guardar cambios</button>
                </div>

                <?php
                $editarResumenCaja = new ControladorResumenCaja();
                $editarResumenCaja->ctrEditarResumenCaja();
                ?>
            </form>
        </div>
    </div>
</div>

<?php
$eliminarResumenCaja = new ControladorResumenCaja();
$eliminarResumenCaja->ctrEliminarResumenCaja();
?>

<div class="modal fade" id="modalVerResumenCaja">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header color-fondo-personalizado">
                <h4 class="modal-title">Detalle del Cierre de Caja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Fecha:</strong> <span id="verResumenFecha">-</span></div>
                    <div class="col-md-2"><strong>DNI:</strong> <span id="verResumenDni">-</span></div>
                    <div class="col-md-4"><strong>Responsable:</strong> <span id="verResumenResponsable">-</span></div>
                    <div class="col-md-3"><strong>Items:</strong> <span id="verResumenItems">0</span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Saldo Inicial:</strong> <span id="verResumenSaldoInicial">S/ 0.00</span></div>
                    <div class="col-md-3"><strong>Ingresos:</strong> <span id="verResumenIngresos">S/ 0.00</span></div>
                    <div class="col-md-3"><strong>Egresos:</strong> <span id="verResumenEgresos">S/ 0.00</span></div>
                    <div class="col-md-3"><strong>Saldo Final:</strong> <span id="verResumenSaldoFinal">S/ 0.00</span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12"><strong>Observación:</strong> <span id="verResumenObservacion">-</span></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ÍTEM</th>
                                <th>FECHA</th>
                                <th>TIPO DOC</th>
                                <th>NRO DOC</th>
                                <th>RAZON SOCIAL</th>
                                <th>CONCEPTO</th>
                                <th>INGRESO</th>
                                <th>EGRESO</th>
                            </tr>
                        </thead>
                        <tbody id="detalleResumenGuardado"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


