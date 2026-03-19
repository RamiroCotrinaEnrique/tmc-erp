<?php
require_once __DIR__ . '/../../config/accesos.php';

if(!tmcUsuarioPuedeAccederModulo($_SESSION["usu_perfil"], 'usuarios')){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}

// 'inicio' y 'salir' siempre están permitidos, no aparecen en los checkboxes.
$modulosSiemprePermitidos = tmcObtenerModulosSiemprePermitidos();
$modulosRegistrados = array_values(array_filter(tmcObtenerModulosRegistrados(), function ($modulo) use ($modulosSiemprePermitidos) {
    return !in_array($modulo, $modulosSiemprePermitidos, true);
}));
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Usuarios</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Tablero Administrar Usuarios</li>
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
                            <button class="btn color-fondo-personalizado" data-toggle="modal" data-target="#modalAgregarUsuario">
                            <i class="fa fa-plus" aria-hidden="true"></i>  Agregar Usuario </button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped tablas">
                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Perfil</th>
                                        <th>Foto</th>                                        
                                        <th>Estado</th>
                                        <th>Último login</th>
                                        <th>Fecha Creación</th>
                                        <th>Ajustes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                            $item = null;
                                            $valor = null;
                                            $Usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                                            
                                            foreach ($Usuarios as $key => $value) {
                                                echo '
                                                 <tr>
                                                    <td>'.($key+1).'</td>
                                                    <td>'.$value["usu_nombre"].'</td>
                                                    <td>'.$value["usu_usuario"].'</td>
                                                    <td>'.$value["usu_perfil"].'</td>';
                                                    
                                                    if ($value["usu_foto"] != "") {
                                                        echo '<td> <img src="'.$value["usu_foto"].'" class="img-thumbnail" width="40px"> </td>';
                                                    }else{
                                                        echo '<td> <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"> </td>';
                                                    }
                                                

                                                    if($value["usu_estado"] != 0){

                                                        echo '<td><button class="btn btn-success btn-xs btnActivar" idUsuario="'.$value["usu_id"].'" estadoUsuario="0">Activado</button></td>';
                                    
                                                      }else{
                                    
                                                        echo '<td><button class="btn btn-danger btn-xs btnActivar" idUsuario="'.$value["usu_id"].'" estadoUsuario="1">Desactivado</button></td>';
                                    
                                                      } 

                                                echo'                                                  

                                                    <td>'.$value["usu_ultimo_login"].'</td>
                                                    <td>'.$value["usu_fecha_create"].'</td>
                                                    <td>
                                                    <div class="btn-group">                          
                                                                <button class="btn btn-info btnPrivilegiosUsuario" idUsuario="'.$value["usu_id"].'" data-toggle="modal" data-target="#modalPrivilegiosUsuario"> <i class="fa fa-lock"></i>  </button>

                                                                <button class="btn btn-warning btnEditarUsuario" idUsuario="'.$value["usu_id"].'" data-toggle="modal" data-target="#modalEditarUsuario"> <i class="fa fa-pencil"></i>  </button>
                                                                
                                                                <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value["usu_id"].'" fotoUsuario="'.$value["usu_foto"].'" usuario="'.$value["usu_usuario"].'"><i class="fa fa-trash-o" aria-hidden="true"></i>   </button>

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
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Perfil</th>
                                        <th>Foto</th>                                        
                                        <th>Estado</th>
                                        <th>Último login</th>
                                        <th>Fecha Creación</th>
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

            <!-- PAPELERA DE USUARIOS -->
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card card-danger card-outline collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-trash mr-1"></i> Papelera de Usuarios</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaPapelera" class="table table-bordered table-striped tablas">
                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Perfil</th>
                                        <th>Foto</th>
                                        <th>Fecha eliminación</th>
                                        <th>Restaurar</th>
                                        <?php if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){ ?>
                                        <th>Depurar</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usuariosEliminados = ControladorUsuarios::ctrMostrarUsuariosEliminados();
                                    if($usuariosEliminados && count($usuariosEliminados) > 0){
                                        foreach($usuariosEliminados as $key => $value){
                                            echo '<tr>';
                                            echo '<td>'.($key+1).'</td>';
                                            echo '<td>'.$value["usu_nombre"].'</td>';
                                            echo '<td>'.$value["usu_usuario"].'</td>';
                                            echo '<td>'.$value["usu_perfil"].'</td>';
                                            if($value["usu_foto"] != ""){
                                                echo '<td><img src="'.$value["usu_foto"].'" class="img-thumbnail" width="40px"></td>';
                                            }else{
                                                echo '<td><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>';
                                            }
                                            echo '<td>'.$value["usu_fecha_delete"].'</td>';
                                            echo '<td>
                                                <button class="btn btn-success btn-xs btnRestaurarUsuario"
                                                    idUsuario="'.$value["usu_id"].'"
                                                    nombreUsuario="'.htmlspecialchars($value["usu_nombre"], ENT_QUOTES).'">
                                                    <i class="fa fa-undo"></i> Restaurar
                                                </button>
                                            </td>';
                                            if(isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador'){
                                                echo '<td>
                                                    <button class="btn btn-danger btn-xs btnDepurarUsuario"
                                                        idUsuario="'.$value["usu_id"].'"      
                                                        nombreUsuario="'.htmlspecialchars($value["usu_nombre"], ENT_QUOTES).'">
                                                        <i class="fa fa-times"></i> Depurar
                                                    </button>
                                                </td>';
                                            }
                                            echo '</tr>';
                                        }
                                    }else{
                                        $colspanPapelera = (isset($_SESSION['usu_perfil']) && $_SESSION['usu_perfil'] === 'Administrador') ? 8 : 7;
                                        echo '<tr><td colspan="'.$colspanPapelera.'" class="text-center text-muted">No hay usuarios en la papelera</td></tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Perfil</th>
                                        <th>Foto</th>
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
            <!-- /PAPELERA DE USUARIOS -->

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<!--=====================================
MODAL AGREGAR UsuarioS
======================================-->
<div class="modal fade" id="modalAgregarUsuario">
    <div class="modal-dialog">
        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

                <div class="modal-header">
                    <h4 class="modal-title">Agregar Usuarios</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> 
                                <i class="fa fa-id-card" aria-hidden="true"></i> 
                            </span>
                        </div>
                        <input type="text" class="form-control" name="nuevoNombre" placeholder="Ingrese Nombres"
                            required>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="nuevoUsuario" name="nuevoUsuario" placeholder="Ingrese Usuario"
                            required>
                    </div>

                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control" name="nuevoClave" placeholder="Ingrese Contraseña"
                            required>
                    </div>
                

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            </span>
                        </div>
                        <select class="form-control select2" name="nuevoPerfil" style="width: 90%;">
                            <option value="">Seleccione perfil...</option>
                            <option value="Administrador">Administrador</option>
                               <option value="Usuario">Usuario</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                    <div class="form-group">              
                        <div class="panel">SUBIR FOTO</div>
                            <input type="file" class="nuevaFoto" id="nuevaFoto" name="nuevaFoto">
                            <p class="help-block">Peso máximo de la foto 2 MB</p>
                            <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                        </div>
                    </div>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
            $crearUsuario = new ControladorUsuarios();
            $crearUsuario -> ctrCrearUsuario();
            ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!--=====================================
MODAL PRIVILEGIOS DE MODULOS
======================================-->
<div class="modal fade" id="modalPrivilegiosUsuario">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="formPrivilegiosUsuario" role="form" method="post">

                <div class="modal-header">
                    <h4 class="modal-title">Editar Privilegios de Módulos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="privilegiosUsuarioId" name="idUsuario" value="">

                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" id="privilegiosUsuarioNombre" readonly>
                    </div>

                    <div class="form-group mb-2">
                        <div class="icheck-primary d-inline mr-3">
                            <input type="checkbox" id="checkTodosModulos">
                            <label for="checkTodosModulos">Marcar todos</label>
                        </div>
                    </div>

                    <div class="row" id="contenedorChecksModulos">
                        <?php foreach ($modulosRegistrados as $modulo) { ?>
                        <div class="col-md-4 col-sm-6 mb-2">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" class="checkModuloUsuario" id="modulo-<?php echo $modulo; ?>" value="<?php echo $modulo; ?>" name="modulos[]">
                                <label for="modulo-<?php echo $modulo; ?>"><?php echo ucfirst(str_replace('-', ' ', $modulo)); ?></label>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado">Guardar privilegios</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<!--=====================================
MODAL EDITAR USUARIO
======================================-->
<div class="modal fade" id="modalEditarUsuario">
    <div class="modal-dialog">
        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

                <div class="modal-header">
                    <h4 class="modal-title">Editar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <input type="hidden" class="form-control" id="editarId" name="editarId" value="">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> 
                                <i class="fa fa-id-card" aria-hidden="true"></i> 
                            </span>
                        </div>
                        <input type="text" class="form-control" id="editarNombre" name="editarNombre" value="">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="editarUsuario" name="editarUsuario" value=""
                            readonly>
                    </div>

                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control" name="editarClave" placeholder="Ingrese Contraseña" >
                        <input type="hidden" name="claveActual"  id="claveActual" >
                    </div>
                
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            </span>
                        </div>
                        <select class="form-control select2" id="editarPerfil" name="editarPerfil" style="width: 90%;">
                            <option value="">Seleccione nuevo perfil</option>
                            <option value="Administrador">Administrador</option>
                               <option value="Usuario">Usuario</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                    <div class="form-group">              
                        <div class="panel">SUBIR FOTO</div>
                            <input type="file" class="nuevaFoto" id="editarFoto" name="editarFoto">
                            <p class="help-block">Peso máximo de la foto 2 MB</p>
                            <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                            <input type="hidden" name="fotoActual" id="fotoActual">
                        </div>
                    </div>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

            <?php
             $editarUsuario = new ControladorUsuarios();
             $editarUsuario -> ctrEditarUsuario();
            ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php

  $borrarUsuario = new ControladorUsuarios();
  $borrarUsuario -> ctrBorrarUsuario();

?>