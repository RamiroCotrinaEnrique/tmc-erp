
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Cargos</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Tablero Administrar Cargos</li>
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
                                data-target="#modalAgregarCargo">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Cargos </button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped tablas">

                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th> 
                                        <th>Cargo</th>
                                        <th>Ajustes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                            $item = null;
                                            $valor = null;
                                            $areas = ControladorCargos::ctrMostrarCargos($item, $valor);
                                            
                                            foreach ($areas as $key => $value) {
                                                echo '
                                                <tr>
                                                <td>'.($key+1).'</td>                                               
                                                <td>'.$value["car_nombre"].'</td>                                                
                                                <td>
                                                <div class="btn-group">                          
                                                    <button class="btn btn-warning btnEditarCargo" idCargo="'.$value["car_id"].'" data-toggle="modal" data-target="#modalEditarCargo"> <i class="fa fa-pencil"></i>  </button>
                                                    <button class="btn btn-danger btnEliminarCargo" idCargo="'.$value["car_id"].'"> <i class="fa fa-trash-o" aria-hidden="true"></i>   </button>';
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
                                        <th>Cargo</th>
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
                            <h3 class="card-title"><i class="fa fa-trash mr-1"></i> Papelera de Cargos</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaPapeleraCargos" class="table table-bordered table-striped tablas">
                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Cargo</th>
                                        <th>Fecha eliminación</th>
                                        <th>Restaurar</th>
                                        <?php if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){ ?>
                                        <th>Depurar</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cargosEliminados = ControladorCargos::ctrMostrarCargosEliminados();
                                    if($cargosEliminados && count($cargosEliminados) > 0){
                                        foreach($cargosEliminados as $key => $value){
                                            echo '<tr>';
                                            echo '<td>'.($key+1).'</td>';
                                            echo '<td>'.$value["car_nombre"].'</td>';
                                            echo '<td>'.$value["car_fecha_delete"].'</td>';
                                            echo '<td>
                                                <button class="btn btn-success btn-xs btnRestaurarCargo"
                                                    idCargo="'.$value["car_id"].'"
                                                    nombreCargo="'.htmlspecialchars($value["car_nombre"], ENT_QUOTES).'">
                                                    <i class="fa fa-undo"></i> Restaurar
                                                </button>
                                            </td>';
                                            if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){
                                                echo '<td>
                                                    <button class="btn btn-danger btn-xs btnDepurarCargo"
                                                        idCargo="'.$value["car_id"].'"
                                                        nombreCargo="'.htmlspecialchars($value["car_nombre"], ENT_QUOTES).'">
                                                        <i class="fa fa-times"></i> Depurar
                                                    </button>
                                                </td>';
                                            }
                                            echo '</tr>';
                                        }
                                    }else{
                                        $colspanPapelera = (isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador') ? 5 : 4;
                                        echo '<tr><td colspan="'.$colspanPapelera.'" class="text-center text-muted">No hay cargos en la papelera</td></tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Cargo</th>
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
MODAL AGREGAR CENTRO COSTO
======================================-->
<div class="modal fade" id="modalAgregarCargo">
    <div class="modal-dialog">
        <div class="modal-content">

            <form role="form" method="post">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Agregar Cargo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row"> 

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputNombre">Cargo</label>
                                <input type="text" class="form-control" id="inputNombre" name="inputNombre"
                                    placeholder="Ingrese cargo">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
            $crearCargo = new ControladorCargos();
            $crearCargo -> ctrCrearCargo();
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
<div class="modal fade" id="modalEditarCargo">
    <div class="modal-dialog">
        <div class="modal-content">

            <form role="form" method="post" id="formEditarCargo">

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
                    $editarCargo = new ControladorCargos();
                    $editarCargo -> ctrEditarCargo();
                ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php
    $eliminarCargo = new ControladorCargos();
    $eliminarCargo -> ctrEliminarCargo();
?>