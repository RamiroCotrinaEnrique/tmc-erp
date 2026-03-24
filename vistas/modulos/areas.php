
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Áreas</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Tablero Administrar Áreas</li>
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
                                data-target="#modalAgregarAreas">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Áreas </button>
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

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card card-secondary card-outline collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-history mr-1"></i> Auditoria de Áreas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaAuditoriaAreas" class="table table-bordered table-striped tablas">
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
                                    $auditoriasAreas = ControladorAreas::ctrMostrarAuditoriaAreas(300);
                                    if ($auditoriasAreas && count($auditoriasAreas) > 0) {
                                        foreach ($auditoriasAreas as $key => $value) {
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
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<!--=====================================
MODAL AGREGAR CENTRO COSTO
======================================-->
<div class="modal fade" id="modalAgregarAreas">
    <div class="modal-dialog">
        <div class="modal-content">

            <form role="form" method="post">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Agregar Área</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row"> 

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputNombre">Área</label>
                                <input type="text" class="form-control" id="inputNombre" name="inputNombre"
                                    placeholder="Ingrese Área">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
            $crearArea = new ControladorAreas();
            $crearArea -> ctrCrearArea();
            ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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