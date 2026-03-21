
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rendición de Caja Chica</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Rendición de Caja Chica</li>
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
                                data-target="#modalAgregarRendicionCajaChica">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Rendición de Caja Chica </button>
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

<div class="modal fade" id="modalAgregarRendicionCajaChica">
    <div class="modal-dialog modal-lg"> <div class="modal-content">

            <form role="form" method="post">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Registrar Nuevo Gasto / Ingreso</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Fecha Documento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" name="nuevaFecha" required>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tipo de Movimiento</label>
                                <select class="form-control" name="nuevoTipoMov" required>
                                    <option value="EGRESO">EGRESO (Gasto)</option>
                                    <option value="INGRESO">INGRESO (Aporte/Reembolso)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Nombre o Razón Social</label>
                                <input type="text" class="form-control" name="nuevaRazonSocial" placeholder="Ej. Grifo Primax S.A." required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Tipo Doc.</label>
                                <select class="form-control" name="nuevoTipoDoc">
                                    <option value="1">Factura (1)</option>
                                    <option value="2">Boleta (2)</option>
                                    <option value="3">Recibo (3)</option>
                                    <option value="4">Ticket (4)</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Nro. Documento</label>
                                <input type="text" class="form-control" name="nuevoNroDoc" placeholder="001-000123">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Monto (S/)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>S/</b></span>
                                    </div>
                                    <input type="number" step="0.01" min="0" class="form-control" name="nuevoMonto" placeholder="0.00" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Concepto / Descripción</label>
                            <textarea class="form-control" name="nuevoConcepto" rows="2" placeholder="Describa el gasto..."></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado">Guardar Movimiento</button>
                </div>

                <?php
                    // Aquí llamarás a tu controlador de Rendición
                    // $crearRendicion = new ControladorRendicion();
                    // $crearRendicion -> ctrCrearRendicion();
                ?>

            </form>
        </div>
    </div>
</div>


<!--=====================================
MODAL AGREGAR RENDICIÓN DE CAJA CHICA
======================================-->
<div class="modal fade" id="modalAgregarRendicionCajaChica11">
    <div class="modal-dialog">
        <div class="modal-content">

            <form role="form" method="post">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Agregar Rendición de Caja Chica</h4>
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