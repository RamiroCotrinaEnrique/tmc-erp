

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Empresas</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Tablero Administrar Empresas</li>
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
                                data-target="#modalAgregarEmpresas">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Empresas </button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped tablas">

                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>RUC</th>
                                        <th>Razón Social</th>
                                        <th>Nombre Comercial</th>
                                        <th>Domicilio</th>
                                        <th>Contacto</th>
                                        <th>Correo</th> 
                                        <th>Ajustes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                            $item = null;
                                            $valor = null;
                                            $empresas = ControladorEmpresas::ctrMostrarEmpresas($item, $valor);
                                            
                                            foreach ($empresas as $key => $value) {
                                                echo '
                                                <tr>
                                                <td>'.($key+1).'</td>
                                                <td>'.$value["empre_ruc"].'</td>                                                
                                                <td>'.$value["empre_razon_social"].'</td>                                                
                                                <td>'.$value["empre_nombre_comercial"].'</td>                                                
                                                <td>'.$value["empre_domicilio_legal"].'</td>                                                
                                                <td>'.$value["empre_numero_contacto"].'</td>                                                
                                                <td>'.$value["empre_email_contacto"].'</td>                                                
                                                <td>
                                                <div class="btn-group">                          
                                                    <button class="btn btn-warning btnEditarEmpresa" idEmpresa="'.$value["empre_id"].'" data-toggle="modal" data-target="#modalEditarEmpresa"> <i class="fa fa-pencil"></i>  </button>
                                                    <button class="btn btn-danger btnEliminarEmpresa" idEmpresa="'.$value["empre_id"].'"> <i class="fa fa-trash-o" aria-hidden="true"></i>   </button>';
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
                                        <th>RUC</th>
                                        <th>Razón Social</th>
                                        <th>Nombre Comercial</th>
                                        <th>Domicilio</th>
                                        <th>Contacto</th>
                                        <th>Correo</th> 
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
                            <h3 class="card-title"><i class="fa fa-trash mr-1"></i> Papelera de Empresas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaPapeleraEmpresas" class="table table-bordered table-striped tablas">
                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>RUC</th>
                                        <th>Razón Social</th>
                                        <th>Nombre Comercial</th>
                                        <th>Domicilio</th>
                                        <th>Contacto</th>
                                        <th>Correo</th>
                                        <th>Fecha eliminación</th>
                                        <th>Restaurar</th>
                                        <?php if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){ ?>
                                        <th>Depurar</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $empresasEliminadas = ControladorEmpresas::ctrMostrarEmpresasEliminadas();
                                    if($empresasEliminadas && count($empresasEliminadas) > 0){
                                        foreach($empresasEliminadas as $key => $value){
                                            echo '<tr>';
                                            echo '<td>'.($key+1).'</td>';
                                            echo '<td>'.$value["empre_ruc"].'</td>';
                                            echo '<td>'.$value["empre_razon_social"].'</td>';
                                            echo '<td>'.$value["empre_nombre_comercial"].'</td>';
                                            echo '<td>'.$value["empre_domicilio_legal"].'</td>';
                                            echo '<td>'.$value["empre_numero_contacto"].'</td>';
                                            echo '<td>'.$value["empre_email_contacto"].'</td>';
                                            echo '<td>'.$value["empre_fecha_delete"].'</td>';
                                            echo '<td>
                                                <button class="btn btn-success btn-xs btnRestaurarEmpresa"
                                                    idEmpresa="'.$value["empre_id"].'"
                                                    nombreEmpresa="'.htmlspecialchars($value["empre_razon_social"], ENT_QUOTES).'">
                                                    <i class="fa fa-undo"></i> Restaurar
                                                </button>
                                            </td>';
                                            if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){
                                                echo '<td>
                                                    <button class="btn btn-danger btn-xs btnDepurarEmpresa"
                                                        idEmpresa="'.$value["empre_id"].'"
                                                        nombreEmpresa="'.htmlspecialchars($value["empre_razon_social"], ENT_QUOTES).'">
                                                        <i class="fa fa-times"></i> Depurar
                                                    </button>
                                                </td>';
                                            }
                                            echo '</tr>';
                                        }
                                    }else{
                                        $colspanPapelera = (isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador') ? 10 : 9;
                                        echo '<tr><td colspan="'.$colspanPapelera.'" class="text-center text-muted">No hay empresas en la papelera</td></tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>RUC</th>
                                        <th>Razón Social</th>
                                        <th>Nombre Comercial</th>
                                        <th>Domicilio</th>
                                        <th>Contacto</th>
                                        <th>Correo</th>
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
MODAL AGREGAR EMPRESAS
======================================-->
<div class="modal fade" id="modalAgregarEmpresas">
    <div class="modal-dialog">
        <div class="modal-content">

            <form role="form" method="post">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Agregar Empresas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputRuc">RUC </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inputRuc" name="inputRuc"
                                        placeholder="Ingrese RUC" required maxlength="11">
                                    <div class="input-group-append" id="loadingRuc" style="display: none;">
                                        <span class="input-group-text">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </span>
                                    </div>
                                </div>   
                                <span class="text-muted" style="font-size: 0.8em;"> Ingrese 11 dígitos. Se llenarán los otros campos automáticamente.</span>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputRazonSocial">Razón Social</label>
                                <input type="text" class="form-control" id="inputRazonSocial" name="inputRazonSocial"
                                    placeholder="Ingrese Razón Social" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputNombreComercial">Nombre Comercial</label>
                                <input type="text" class="form-control" id="inputNombreComercial" name="inputNombreComercial"
                                    placeholder="Ingrese Nombre Comercial" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputDomicilioLegal">Domicilio Legal</label>
                                <input type="text" class="form-control" id="inputDomicilioLegal" name="inputDomicilioLegal"
                                    placeholder="Ingrese Domicilio Legal" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputNumeroContacto">Número Contacto</label>
                                <input type="text" class="form-control" id="inputNumeroContacto" name="inputNumeroContacto"
                                    placeholder="Ingrese Número Contacto">
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" id="inputEmail" name="inputEmail"
                                    placeholder="Ingrese Email">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
            $crearEmpresa = new ControladorEmpresas();
            $crearEmpresa -> ctrCrearEmpresa();
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
<div class="modal fade" id="modalEditarEmpresa">
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
                                <label for="inputEditRuc">RUC <span class="text-muted" style="font-size: 0.8em;">(se consultará automáticamente)</span></label>
                                <input type="text" class="form-control" id="inputEditRuc" name="inputEditRuc"
                                    placeholder="Ingrese RUC" required maxlength="11">
                                <small class="form-text text-muted">Ingrese 11 dígitos para cargar datos automáticamente.</small>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputEditRazonSocial">Razón Social</label>
                                <input type="text" class="form-control" id="inputEditRazonSocial" name="inputEditRazonSocial"
                                    placeholder="Ingrese Razón Social" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputEditNombreComercial">Nombre Comercial</label>
                                <input type="text" class="form-control" id="inputEditNombreComercial" name="inputEditNombreComercial"
                                    placeholder="Ingrese Nombre Comercial" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputEditDomicilioLegal">Domicilio Legal</label>
                                <input type="text" class="form-control" id="inputEditDomicilioLegal" name="inputEditDomicilioLegal"
                                    placeholder="Ingrese Domicilio Legal" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputEditNumeroContacto">Número Contacto</label>
                                <input type="text" class="form-control" id="inputEditNumeroContacto" name="inputEditNumeroContacto"
                                    placeholder="Ingrese Número Contacto">
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="inputEditEmail">Email</label>
                                <input type="email" class="form-control" id="inputEditEmail" name="inputEditEmail"
                                    placeholder="Ingrese Email">
                            </div>
                        </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
            $editarEmpresa = new ControladorEmpresas();
            $editarEmpresa -> ctrEditarEmpresa();
        ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php

  $eliminarEmpresa = new ControladorEmpresas();
  $eliminarEmpresa -> ctrEliminarEmpresa();

?>