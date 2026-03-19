
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
                                                    <button class="btn btn-warning btnEditarCentroCosto" idCentroCosto="'.$value["cenco_id"].'" data-toggle="modal" data-target="#modalEditarCentroCosto"> <i class="fa fa-pencil"></i>  </button>';
                                                if($_SESSION["usu_perfil"] == "Administrador"){ 
                                                        echo '
                                                    <button class="btn btn-danger btnEliminarrCentroCosto" idCentroCosto="'.$value["cenco_id"].'"> <i class="fa fa-trash-o" aria-hidden="true"></i>   </button>';
                                            }
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