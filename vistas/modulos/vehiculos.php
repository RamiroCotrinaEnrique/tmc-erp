<?php
if($_SESSION["usu_perfil"] == "Vendedor"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Vehículos</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Tablero Administrar Vehículos</li>
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
                                data-target="#modalAgregarVehiculos">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Vehículo </button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped tablas">

                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Operación</th>
                                        <th style="width:45px">Placa</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Año</th>
                                        <th>Clase</th> 
                                        <th>N° VIN</th> 
                                        <th>N° Motor</th> 
                                        <th>Jefe Operación</th> 
                                        <th>Estado</th> 
                                        <th>Propietario</th> 
                                        <th>Ajustes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                            $item = null;
                                            $valor = null;
                                            $vehiculos = ControladorVehiculos::ctrMostrarVehiculos($item, $valor);
                                            
                                            foreach ($vehiculos as $key => $value) {

                                                $item = "cenco_id";
			                                    $valor = $value["vehic_cenco_id"]; 
			                                    $centro = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor); 

                                                echo '
                                                <tr>
                                                <td>'.($key+1).'</td>
                                                <td>'.$centro["cenco_nombre"].'</td>                                                
                                                <td>'.$value["vehic_placa"].'</td>                                                
                                                <td>'.$value["vehic_marca"].'</td>                                                
                                                <td>'.$value["vehic_modelo"].'</td>                                                
                                                <td>'.$value["vehic_anio"].'</td>                                                
                                                <td>'.$value["vehic_clase"].'</td>                                                
                                                <td>'.$value["vehic_numero_vin"].'</td>                                                
                                                <td>'.$value["vehic_numero_motor"].'</td>                                                
                                                <td>'.$value["vehic_jefe_operacion"].'</td>';
                                                if($value["vehic_estado"] == "OPERATIVA"){
                                                    echo '<td><button class="btn btn-success btn-sm" >OPERATIVA</button></td>';
                                                  }
                                                  if($value["vehic_estado"] == "INOPERATIVA"){                                
                                                    echo '<td><button class="btn btn-danger btn-sm">INOPERATIVA</button></td>';                                
                                                  } 

                                                echo'                                                                                                                                              
                                                <td>'.$value["vehic_propietario"].'</td>                                                
                                                <td>
                                                <div class="btn-group">                          
                                                    <button class="btn btn-warning btnEditarVehiculo" idVehiculo="'.$value["vehic_id"].'" data-toggle="modal" data-target="#modalEditarVehiculo"> <i class="fa fa-pencil"></i> </button>';
                                                if($_SESSION["usu_perfil"] == "Administrador"){ 
                                                        echo '
                                                    <button class="btn btn-danger btnEliminarVehiculo" idVehiculo="'.$value["vehic_id"].'"> <i class="fa fa-trash-o" aria-hidden="true"></i>  </button>';
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
                                        <th>Operación</th>
                                        <th style="width:45px">Placa</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Año</th>
                                        <th>Clase</th> 
                                        <th>N° VIN</th> 
                                        <th>N° Motor</th> 
                                        <th>Jefe Operación</th> 
                                        <th>Estado</th> 
                                        <th>Propietario</th> 
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
MODAL AGREGAR EMPRESAS
======================================-->
<div class="modal fade" id="modalAgregarVehiculos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form role="form" method="post">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Agregar Vehículos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row">                                             

                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="inputCentro">Centro de costo</label> 
                                <select class="form-control select2" id="inputCentro" name="inputCentro" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $item = null;
                                    $valor = null;                                      
                                    $centroCosto = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor); 
                                    //var_dump($categoria);
                                    foreach ($centroCosto as $key => $value) {
                                        echo '<option value="'.$value["cenco_id"].'">'.$value["cenco_nombre"].'</option>';
                                    }  
                                    ?>
                                </select>                                
                            </div>
                        </div>   
                                             
                        <div class="form-group col-md-2">
                            <div class="form-group">
                                <label for="inputPlaca">Placa</label>
                                <input type="text" class="form-control" id="inputPlaca" name="inputPlaca"
                                    placeholder="Ingrese Placa" required>
                            </div>
                        </div>

                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="inputMarca">Marca</label>
                                <input type="text" class="form-control" id="inputMarca" name="inputMarca"
                                    placeholder="Ingrese Marca" required>
                            </div>
                        </div>

                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="inputModelo">Modelo</label>
                                <input type="text" class="form-control" id="inputModelo" name="inputModelo"
                                    placeholder="Ingrese Modelo" required>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <div class="form-group">
                                <label for="inputAnio">Año</label>
                                <input type="text" class="form-control" id="inputAnio" name="inputAnio"
                                    placeholder="Ingrese Año">
                            </div>
                        </div>

                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="inputClase">Clase</label>
                                <input type="text" class="form-control" id="inputClase" name="inputClase"
                                    placeholder="Ingrese Clase">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputNumeroVin">Número VIN </label>
                                <input type="text" class="form-control" id="inputNumeroVin" name="inputNumeroVin"
                                    placeholder="Ingrese Número VIN">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputNumeroMotor">Número Motor</label>
                                <input type="text" class="form-control" id="inputNumeroMotor" name="inputNumeroMotor"
                                    placeholder="Ingrese Número Motor">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="inputJefeOperacion">Jefe de Operacion</label>
                                <input type="text" class="form-control" id="inputJefeOperacion" name="inputJefeOperacion"
                                    placeholder="Ingrese Jefe de Operacion">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="inputEstado">Estado</label> 
                                <select class="form-control" id="inputEstado" name="inputEstado">
                                <option>Seleccione...</option>
                                <option value="OPERATIVA">OPERATIVA</option>
                                <option value="INOPERATIVA">INOPERATIVA</option>
                                </select>    
                            </div>
                        </div> 

                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="inputPropietario">Propietario</label>
                                <input type="text" class="form-control" id="inputPropietario" name="inputPropietario"
                                    placeholder="Ingrese Propietario">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

                <?php
                $crearVehiculo = new ControladorVehiculos();
                $crearVehiculo -> ctrCrearVehiculo();
                ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!--=====================================
MODAL EDITAR VEHICULOS
======================================-->
<div class="modal fade" id="modalEditarVehiculo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form role="form" method="post" id="formEditarVehiculo">

                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Editar Vehículo </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">                    

                    <div class="form-row">

                    <input type="hidden" name="inputEditId" id="inputEditId">  

                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="inputEditCentro">Centro de costo</label> 
                                <select class="form-control select2" id="inputEditCentro" name="inputEditCentro" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $item = null;
                                    $valor = null;                                      
                                    $centroCosto = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor); 
                                    //var_dump($categoria);
                                    foreach ($centroCosto as $key => $value) {
                                        echo '<option value="'.$value["cenco_id"].'">'.$value["cenco_nombre"].'</option>';
                                    }  
                                    ?>
                                </select>                                
                            </div>
                        </div>   
                                             
                        <div class="form-group col-md-2">
                            <div class="form-group">
                                <label for="inputEditPlaca">Placa</label>
                                <input type="text" class="form-control" id="inputEditPlaca" name="inputEditPlaca"
                                    placeholder="Ingrese Placa" required>
                            </div>
                        </div>

                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="inputEditMarca">Marca</label>
                                <input type="text" class="form-control" id="inputEditMarca" name="inputEditMarca"
                                    placeholder="Ingrese Marca" required>
                            </div>
                        </div>

                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="inputEditModelo">Modelo</label>
                                <input type="text" class="form-control" id="inputEditModelo" name="inputEditModelo"
                                    placeholder="Ingrese Modelo" required>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <div class="form-group">
                                <label for="inputEditAnio">Año</label>
                                <input type="text" class="form-control" id="inputEditAnio" name="inputEditAnio"
                                    placeholder="Ingrese Año">
                            </div>
                        </div>

                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="inputEditClase">Clase</label>
                                <input type="text" class="form-control" id="inputEditClase" name="inputEditClase"
                                    placeholder="Ingrese Clase">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEditNumeroVin">Número VIN </label>
                                <input type="text" class="form-control" id="inputEditNumeroVin" name="inputEditNumeroVin"
                                    placeholder="Ingrese Número VIN">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="inputEditNumeroMotor">Número Motor</label>
                                <input type="text" class="form-control" id="inputEditNumeroMotor" name="inputEditNumeroMotor"
                                    placeholder="Ingrese Número Motor">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="inputEditJefeOperacion">Jefe de Operacion</label>
                                <input type="text" class="form-control" id="inputEditJefeOperacion" name="inputEditJefeOperacion"
                                    placeholder="Ingrese Jefe de Operacion">
                            </div>
                        </div> 

                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="inputEditEstado">Estado</label> 
                                <select class="form-control" id="inputEditEstado" name="inputEditEstado">
                                <option>Seleccione...</option>
                                <option value="OPERATIVA">OPERATIVA</option>
                                <option value="INOPERATIVA">INOPERATIVA</option>
                                </select>    
                            </div>
                        </div> 

                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="inputEditPropietario">Propietario</label>
                                <input type="text" class="form-control" id="inputEditPropietario" name="inputEditPropietario"
                                    placeholder="Ingrese Propietario">
                            </div>
                        </div>

                    </div>                    

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php

  $eliminarVehiculo = new ControladorVehiculos();
  $eliminarVehiculo -> ctrEliminarVehiculo();

?>