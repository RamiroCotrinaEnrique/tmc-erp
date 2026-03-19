
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Centro Costo</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Tablero Administrar Centro Costo</li>
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
                                data-target="#modalAgregarCentroCosto">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Centro Costo </button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped tablas">

                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Código</th>
                                        <th>Centro Costo</th>
                                        <th>Ajustes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                            $item = null;
                                            $valor = null;
                                            $centros = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor);
                                            
                                            foreach ($centros as $key => $value) {
                                                echo '
                                                <tr>
                                                <td>'.($key+1).'</td>
                                                <td>'.$value["cenco_codigo"].'</td>                                                
                                                <td>'.$value["cenco_nombre"].'</td>                                                
                                                <td>
                                                <div class="btn-group">                          
                                                    <button class="btn btn-warning btnEditarCentroCosto" idCentroCosto="'.$value["cenco_id"].'" data-toggle="modal" data-target="#modalEditarCentroCosto"> <i class="fa fa-pencil"></i>  </button>
                                                    <button class="btn btn-danger btnEliminarCentroCosto" idCentroCosto="'.$value["cenco_id"].'"> <i class="fa fa-trash-o" aria-hidden="true"></i>   </button>
                                                ';                                            
                                                echo'
                                                </div>  
                                                </td>
                                            </tr> ';
                                            }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Código</th>
                                        <th>Centro Costo</th>
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
                            <h3 class="card-title"><i class="fa fa-trash mr-1"></i> Papelera de Centros de Costo</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaPapeleraCentroCosto" class="table table-bordered table-striped tablas">
                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Código</th>
                                        <th>Centro Costo</th>
                                        <th>Fecha eliminación</th>
                                        <th>Restaurar</th>
                                        <?php if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){ ?>
                                        <th>Depurar</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $centrosEliminados = ControladorCentroCostos::ctrMostrarCentroCostosEliminados();
                                    if($centrosEliminados && count($centrosEliminados) > 0){
                                        foreach($centrosEliminados as $key => $value){
                                            echo '<tr>';
                                            echo '<td>'.($key+1).'</td>';
                                            echo '<td>'.$value["cenco_codigo"].'</td>';
                                            echo '<td>'.$value["cenco_nombre"].'</td>';
                                            echo '<td>'.$value["cenco_fecha_delete"].'</td>';
                                            echo '<td>
                                                <button class="btn btn-success btn-xs btnRestaurarCentroCosto"
                                                    idCentroCosto="'.$value["cenco_id"].'"
                                                    nombreCentroCosto="'.htmlspecialchars($value["cenco_nombre"], ENT_QUOTES).'">
                                                    <i class="fa fa-undo"></i> Restaurar
                                                </button>
                                            </td>';
                                            if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){
                                                echo '<td>
                                                    <button class="btn btn-danger btn-xs btnDepurarCentroCosto"
                                                        idCentroCosto="'.$value["cenco_id"].'"
                                                        nombreCentroCosto="'.htmlspecialchars($value["cenco_nombre"], ENT_QUOTES).'">
                                                        <i class="fa fa-times"></i> Depurar
                                                    </button>
                                                </td>';
                                            }
                                            echo '</tr>';
                                        }
                                    }else{
                                        $colspanPapelera = (isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador') ? 6 : 5;
                                        echo '<tr><td colspan="'.$colspanPapelera.'" class="text-center text-muted">No hay centros de costo en la papelera</td></tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Código</th>
                                        <th>Centro Costo</th>
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
<div class="modal fade" id="modalAgregarCentroCosto">
    <div class="modal-dialog">
        <div class="modal-content">

            <form role="form" method="post">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Agregar Centro Costo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputCodigo">Código</label>
                                <input type="text" class="form-control" id="inputCodigo" name="inputCodigo"
                                    placeholder="Ingrese código">
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputNombre">Nombre</label>
                                <input type="text" class="form-control" id="inputNombre" name="inputNombre"
                                    placeholder="Ingrese Nombre">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
            $crearCentroCosto = new ControladorCentroCostos();
            $crearCentroCosto -> ctrCrearCentroCosto();
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
<div class="modal fade" id="modalEditarCentroCosto">
    <div class="modal-dialog">
        <div class="modal-content">

            <form role="form" method="post">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Editar Centro de Costo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" class="form-control" name="inputEditId" id="inputEditId">

                    <div class="form-group col-md-12">
                        <div class="form-group">
                            <label for="inputEditCodigo">Código</label>
                            <input type="text" class="form-control" id="inputEditCodigo" name="inputEditCodigo" >
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <div class="form-group">
                            <label for="inputEditNombre">Nombre</label>
                            <input type="text" class="form-control" id="inputEditNombre" name="inputEditNombre" >
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
            $editarCentro = new ControladorCentroCostos();
            $editarCentro -> ctrEditarCentroCosto();
        ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php

  $eliminarCentro = new ControladorCentroCostos();
  $eliminarCentro -> ctrEliminarCentroCosto();

?>