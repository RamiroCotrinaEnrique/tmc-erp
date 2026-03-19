
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Empleados</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"> Inicio</a></li>
                        <li class="breadcrumb-item active">Tablero Administrar Empleados</li>
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
                                data-target="#modalAgregarEmpleado">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Empleado </button>
                        </div>
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped tablas">

                                <thead class="text-center">
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Código</th>
                                        <th>Documento Identidad</th>
                                        <th>Apellidos </th> 
                                        <th>Nombres</th>
                                        <th>Fecha Nacimiento</th>
                                        <th>Mes Nacimiento</th>
                                        <th>Edad</th>                                        
                                        <th>Centro Costo</th>
                                        <th>Cargo</th>
                                        <th>Área</th>
                                        <th>Nacionalidad</th>
                                        <th>Ajustes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                            $item = null;
                                            $valor = null;
                                            $empleado = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);
                                            
                                            foreach ($empleado as $key => $value) {

                                                $edad = ControladorEmpleados::ctrCalcularEdad($value["emple_fecha_nacimiento"]);
                                                $mes = ControladorEmpleados::ctrObtenerMes($value["emple_fecha_nacimiento"]);

                                                echo '
                                                <tr class="text-center">
                                                <td>'.($key+1).'</td>                                               
                                                <td>'.$value["emple_codigo"].'</td>                                                
                                                <td>'.$value["emple_numero_documento"].'</td>                                                
                                                <td>'.$value["emple_apellido_paterno"].' '.$value["emple_apellido_materno"].'</td>                                                                                              
                                                <td>'.$value["emple_nombres"].'</td>                                                
                                                <td>'.$value["emple_fecha_nacimiento"].'</td>                                                
                                                <td>'.$mes.'</td>                                                
                                                <td>'.$edad.'</td> 
                                                <td>'.$value["cenco_codigo"].' - '.$value["cenco_nombre"].'</td>
                                                <td>' . $value["car_nombre"] . '</td> 
                                                <td>' . $value["are_nombre"] . '</td> 
                                                <td>'.$value["emple_nacionalidad"].'</td>                                                
                                                <td>
                                                <div class="btn-group"> 
                                                    <!-- BOTÓN NUEVO PARA GENERAR REPORTE -->
                                                    <button class="btn btn-primary btnGenerarReporte" idEmpleado="'.$value["emple_id"].'" data-toggle="modal" data-target="#modalReporteEmpleado">
                                                        <i class="fas fa-file-alt btn-reporte"></i>
                                                    </button>  
                                                    <!-- BOTÓN PARA EDITAR -->                       
                                                    <button class="btn btn-warning btnEditarEmpleado" idEmpleado="'.$value["emple_id"].'" data-toggle="modal" data-target="#modalEditarEmpleado"> <i class="fa fa-pencil"></i>  </button>';
                                                    if($_SESSION["usu_perfil"] == "Administrador"){ 
                                                        echo '
                                                    <!-- BOTÓN PARA ELIMINAR -->
                                                    <button class="btn btn-danger btnEliminarEmpleado" idEmpleado="'.$value["emple_id"].'"> <i class="fa fa-trash-o" aria-hidden="true"></i>   </button>';
                                                    }
                                                echo'
                                                </div>  
                                                </td>
                                            </tr>
                                                ';

                                            }
                                            ?>
                                </tbody>
                                <tfoot class="text-center">
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Código</th>
                                        <th>Documento Identidad</th>
                                        <th>Apellidos</th> 
                                        <th>Nombres</th>
                                        <th>Fecha Nacimiento</th>
                                        <th>Mes Nacimiento</th>
                                        <th>Edad</th>                                        
                                        <th>Centro Costo</th>
                                        <th>Cargo</th>
                                        <th>Área</th>
                                        <th>Nacionalidad</th>
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

<!-- ===================================================================== -->
<!-- ============= 1. MODAL PARA MOSTRAR EL REPORTE (SIN CAMBIOS) ======== -->
<!-- ===================================================================== -->

<div class="modal fade " id="modalReporteEmpleado" tabindex="-1" aria-labelledby="tituloModalReporte" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header color-fondo-personalizado text-white">
                <h5 class="modal-title" id="tituloModalReporte"><i class="fas fa-user-tie mr-2"></i>Reporte de Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="cuerpoReporte">
                    <!-- Loader -->
                    <div class="text-center" id="reporteLoader">
                        <i class="fas fa-spinner fa-spin fa-3x"></i>
                        <p class="mt-2">Cargando datos...</p>
                    </div>
                    <!-- Contenido del Reporte -->
                    <div id="reporteContenido" style="display: none;">
                        <div class="row">
                            <div class="col-lg-6 d-flex">
                                <!-- Datos Personales -->
                                <div class="reporte-card w-100">
                                    <h6 class="reporte-titulo"><i class="fas fa-user-circle"></i>Datos Personales</h6>
                                    <p class="reporte-item"><strong>Código:</strong> <span id="reporteCodigo"></span></p>
                                    <p class="reporte-item"><strong>Documento:</strong> <span id="reporteDocumento"></span></p>
                                    <p class="reporte-item"><strong>Nombres:</strong> <span id="reporteNombres"></span></p>
                                    <p class="reporte-item"><strong>Apellidos:</strong> <span id="reporteApellidos"></span></p>
                                    <p class="reporte-item"><strong>Fec. Nacimiento:</strong> <span id="reporteFechaNacimiento"></span></p>
                                    <p class="reporte-item"><strong>Nacionalidad:</strong> <span id="reporteNacionalidad"></span></p>
                                    <p class="reporte-item"><strong>Teléfono:</strong> <span id="reporteTelefonoMovil"></span></p>
                                    <p class="reporte-item"><strong>Correo:</strong> <span id="reporteCorreo"></span></p>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex">
                                <!-- Datos Laborales -->
                                <div class="reporte-card w-100">
                                    <h6 class="reporte-titulo"><i class="fas fa-briefcase"></i>Datos Laborales</h6>
                                    <p class="reporte-item"><strong>RUC:</strong> <span id="reporteRuc"></span></p>
                                    <p class="reporte-item"><strong>Empresa:</strong> <span id="reporteEmpresa"></span></p>
                                    <p class="reporte-item"><strong>Fecha Ingreso:</strong> <span id="reporteFechaIngreso"></span></p>
                                    <p class="reporte-item"><strong>Categoría:</strong> <span id="reporteCategoria"></span></p>
                                    <p class="reporte-item"><strong>Centro de Costo:</strong> <span id="reporteCentroCosto"></span></p>
                                    <p class="reporte-item"><strong>Área:</strong> <span id="reporteArea"></span></p>
                                    <p class="reporte-item"><strong>Cargo:</strong> <span id="reporteCargo"></span></p>
                                </div>
                            </div>
                        </div>
                        <!-- NUEVA FILA PARA DATOS ADICIONALES -->
                        <div class="row">
                            <div class="col-lg-6 d-flex">
                                <!-- Datos Educativos -->
                                <div class="reporte-card w-100">
                                    <h6 class="reporte-titulo"><i class="fas fa-graduation-cap"></i>Datos Educativos</h6>
                                    <p class="reporte-item"><strong>Nivel Educativo:</strong> <span id="reporteSituacionEducativa"></span></p>
                                    <p class="reporte-item"><strong>Institución:</strong> <span id="reporteInstitucion"></span></p>
                                    <p class="reporte-item"><strong>Carrera:</strong> <span id="reporteCarrera"></span></p>
                                    <p class="reporte-item"><strong>Año de Egreso:</strong> <span id="reporteAnioEgreso"></span></p>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex">
                                <!-- Contacto de Emergencia y Documentación -->
                                <div class="reporte-card w-100">
                                    <h6 class="reporte-titulo"><i class="fas fa-address-book"></i>Contacto de Emergencia</h6>
                                    <p class="reporte-item"><strong>Nombre:</strong> <span id="reporteNombreFamiliar"></span></p>
                                    <p class="reporte-item"><strong>Parentesco:</strong> <span id="reporteParentesco"></span></p>
                                    <p class="reporte-item"><strong>Teléfono:</strong> <span id="reporteTelefonoFamiliar"></span></p>
                                    <hr>
                                    <h6 class="reporte-titulo mt-3"><i class="fas fa-id-card"></i>Documentación</h6>
                                    <p class="reporte-item"><strong>Vencimiento Documento:</strong> <span id="reporteVencimientoDocumento"></span></p>
                                    <p class="reporte-item"><strong>Archivo Documento:</strong> <span id="reporteArchivoDocumento"></span></p>
                                    <!-- Contenedor dinámico para las licencias -->
                                    <div id="reporteLicenciasWrapper"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="window.print();"><i class="fas fa-print mr-1"></i> Imprimir o Guardar PDF</button>
            </div>
        </div>
    </div>
</div>

<!-- /.modal -->

<!-- =================================================================== -->
<!-- ============= 2. MODAL PARA AGREGAR EMPLEADO ======== -->
<!-- =================================================================== -->

<div class="modal fade" id="modalAgregarEmpleado">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form role="form" method="post" id="formAgregarEmpleado" enctype="multipart/form-data" novalidate>              
                
                <div class="modal-header color-fondo-personalizado">
                    <h4 class="modal-title">Agregar Empleado</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" id="miTab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active " id="datos-personales-tab" data-toggle="tab"
                                href="#datos-personales" role="tab">
                                <strong>Datos Personales</strong> </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="datos-laborales-tab" data-toggle="tab" href="#datos-laborales"
                                role="tab">
                                <strong>Datos Laborales</strong> </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="datos-educativos-tab" data-toggle="tab" href="#datos-educativos"
                                role="tab">
                                <strong>Datos Educativos</strong> </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="datos-contactos-tab" data-toggle="tab" href="#datos-contactos"
                                role="tab">
                                <strong>Datos Contacto</strong> </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="documentacion-tab" data-toggle="tab" href="#documentacion"
                                role="tab">
                                <strong>Documentación</strong> </a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" id="miTabContent">

                        <div class="tab-pane fade show active" id="datos-personales" role="tabpanel">
                            <!-- Aquí van tus campos de datos personales -->
                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputCodigo">Código <span class="text-danger">(*)</span> </label>
                                        <?php $codigo = ControladorEmpleados::ctrObtenerCodigo(); ?>
                                        <input type="text" class="form-control" id="inputCodigo" name="inputCodigo"
                                            value="<?php echo $codigo ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputTipoDocumento">Tipo Documento <span class="text-danger">(*)</span> </label>
                                    <select class="form-control" id="inputTipoDocumento" name="inputTipoDocumento" required>
                                        <option >Seleccione...</option>
                                        <option value="DNI">DNI</option>
                                        <option value="Carnet de Fuerzas Policiales">Carnet de Fuerzas Policiales</option>
                                        <option value="Carnet de Fuerzas Armadas">Carnet de Fuerzas Armadas</option>
                                        <option value="Carnet de Extranjería">Carnet de Extranjería</option>
                                        <option value="Pasaporte">Pasaporte</option>
                                        <option value="Doc. Povisional de Identidad">Doc. Povisional de Identidad</option>
                                        <option value="Partida de Nacimiento">Partida de Nacimiento</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-5">
                                    <div class="form-group">
                                        <label for="inputNumeroDocumento">Nro. Documento <span class="text-danger">(*)</span> </label>
                                        <input type="text" class="form-control" id="inputNumeroDocumento"
                                            name="inputNumeroDocumento" placeholder="Ingrese número documento" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="inputApellidoPaterno">Apellido Paterno <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control" id="inputApellidoPaterno"
                                            name="inputApellidoPaterno" placeholder="Ingrese apellido paterno" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="inputApellidoMaterno">Apellido Materno <span class="text-danger">(*)</span> </label>
                                        <input type="text" class="form-control" id="inputApellidoMaterno"
                                            name="inputApellidoMaterno" placeholder="Ingrese apellido materno" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="inputNombres">Nombres <span class="text-danger">(*)</span> </label>
                                        <input type="text" class="form-control" id="inputNombres" name="inputNombres"
                                            placeholder="Ingrese Nombres" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputFechaNacimiento">Fecha de Nacimiento <span class="text-danger">(*)</span> </label>
                                        <div class="input-group date" id="fechaNacimienntoDatePicker"
                                            data-target-input="nearest">
                                            <input type="text" id="inputFechaNacimiento" name="inputFechaNacimiento"
                                                placeholder="DD/MM/YYYY" required
                                                class="form-control datetimepicker-input"
                                                data-target="#fechaNacimienntoDatePicker">
                                            <div class="input-group-append" data-target="#fechaNacimienntoDatePicker"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputNacionalidad">Nacionalidad <span class="text-danger">(*)</span> </label>
                                        <input type="text" class="form-control" id="inputNacionalidad"
                                            name="inputNacionalidad" placeholder="Ingrese Nacionalidad" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputSexo"> Sexo <span class="text-danger">(*)</span> </label>
                                        <select class="form-control" id="inputSexo" name="inputSexo" required>
                                            <option value="">Seleccione...</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputEstadoCivil"> Estado Civil <span class="text-danger">(*)</span> </label>
                                        <select class="form-control" id="inputEstadoCivil" name="inputEstadoCivil" required>
                                            <option value="">Seleccione...</option>
                                            <option value="Soltero">Soltero</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Viudo">Viudo</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Conviviente">Conviviente</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputNumeroTelefonoMovil">Nro. Movil</label>
                                        <input type="text" class="form-control" id="inputNumeroTelefonoMovil"
                                            name="inputNumeroTelefonoMovil" data-inputmask="'mask':'(99) 999-999-999'"
                                            data-mask>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputNumeroTelefonoFijo">Nro. Telf. Fijo</label>
                                        <input type="text" class="form-control" id="inputNumeroTelefonoFijo"
                                            name="inputNumeroTelefonoFijo" data-inputmask="'mask':'(99) 999-9999'"
                                            data-mask>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label for="inputCorreo">Correo</label>
                                        <input type="email" class="form-control" id="inputCorreo" name="inputCorreo"
                                            placeholder="ejemplo@ejemplo.com">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="inputDepartamento">Departamento</label>
                                        <input type="text" class="form-control" id="inputDepartamento"
                                            name="inputDepartamento" placeholder="Ingrese Departamento">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="inputProvincia">Provincia</label>
                                        <input type="text" class="form-control" id="inputProvincia"
                                            name="inputProvincia" placeholder="Ingrese Provincia">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="inputDistrito">Distrito </label>
                                        <input type="text" class="form-control" id="inputDistrito" name="inputDistrito"
                                            placeholder="Ingrese Distrito">
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="form-group">
                                        <label for="inputLugarResidencia">Lugar Residencia</label>
                                        <input type="text" class="form-control" id="inputLugarResidencia"
                                            name="inputLugarResidencia" placeholder="Ingrese lugar de residencia">
                                    </div>
                                </div>

                            </div>
                            <!-- Agrega el resto de campos aquí -->
                        </div>

                        <!-- 
                        -- DATOS LABORALES 
                        -->

                        <div class="tab-pane fade" id="datos-laborales" role="tabpanel">
                            <!-- Campos de Planilla -->
                            <div class="form-row">

                                <div class="form-group col-md-5">
                                    <div class="form-group">
                                        <label for="inputEmpresa">Empresa <span class="text-danger">(*)</span> </label>
                                        <select class="form-control select2" id="inputEmpresa" name="inputEmpresa"
                                            required>
                                            <option value="">Seleccione..</option>
                                            <?php 
                                                $item = null;
                                                $valor = null;                                      
                                                $empresa = ControladorEmpresas::ctrMostrarEmpresas($item, $valor); 
                                                foreach ($empresa as $key => $value) {
                                                    echo '<option value="'.$value["empre_id"].'">'.$value["empre_ruc"].' '.$value["empre_razon_social"].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="inputFechaIngreso">Fecha Ingreso <span class="text-danger">(*)</span> </label>
                                        <div class="input-group date" id="fechaIngresoDatePicker"
                                            data-target-input="nearest">
                                            <input type="text" id="inputFechaIngreso" name="inputFechaIngreso"
                                                placeholder="DD/MM/YYYY" required
                                                class="form-control datetimepicker-input"
                                                data-target="#fechaIngresoDatePicker">
                                            <div class="input-group-append" data-target="#fechaIngresoDatePicker"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputCategoriaOcupacional"> Categoría Ocupacional </label>
                                        <select class="form-control" id="inputCategoriaOcupacional"
                                            name="inputCategoriaOcupacional">
                                            <option value="">Seleccione...</option>
                                            <option value="Ejecutivo">Ejecutivo</option>
                                            <option value="Obrero">Obrero</option>
                                            <option value="Empleado">Empleado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="form-group">
                                        <label for="inputCentroCosto">Centro de Costo <span class="text-danger">(*)</span></label>
                                        <select class="form-control select2" id="inputCentroCosto"
                                            name="inputCentroCosto" required>
                                            <option value="">Seleccione..</option>
                                            <?php 
                                                $item = null;
                                                $valor = null;                                      
                                                $centroCosto = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor); 
                                                foreach ($centroCosto as $key => $value) {
                                                    echo '<option value="'.$value["cenco_id"].'">'.$value["cenco_codigo"].' '.$value["cenco_nombre"].'</option>';
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label for="inputArea">Área <span class="text-danger">(*)</span></label>
                                        <select class="form-control select2" id="inputArea" name="inputArea" required>
                                            <option value="">Seleccione..</option>
                                            <?php 
                                                $item = null;
                                                $valor = null;                                      
                                                $area = ControladorAreas::ctrMostrarAreas($item, $valor); 
                                                foreach ($area as $key => $value) {
                                                    echo '<option value="'.$value["are_id"].'">'.$value["are_nombre"].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label for="inputCargo">Cargo <span class="text-danger">(*)</span></label>
                                        <select class="form-control select2" id="inputCargo" name="inputCargo" required>
                                            <option value="">Seleccione..</option>
                                            <?php 
                                                $item = null;
                                                $valor = null;                                      
                                                $area = ControladorCargos::ctrMostrarCargos($item, $valor); 
                                                foreach ($area as $key => $value) {
                                                    echo '<option value="'.$value["car_id"].'">'.$value["car_nombre"].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label for="inputEstado"> Estado </label>
                                        <select class="form-control" id="inputEstado"
                                            name="inputEstado">
                                            <option value="">Seleccione...</option>
                                            <option value="Activo">Activo</option>
                                            <option value="Cesado">Cesado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label for="inputFechaCese">Fecha Cese</label>
                                        <div class="input-group date" id="fechaCeseDatePicker"
                                            data-target-input="nearest">
                                            <input type="text" id="inputFechaCese" name="inputFechaCese"
                                                placeholder="DD/MM/YYYY" required
                                                class="form-control datetimepicker-input"
                                                data-target="#fechaCeseDatePicker">
                                            <div class="input-group-append" data-target="#fechaCeseDatePicker"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </div>

                        </div>

                        <!-- 
                        -- DATOS EDUCATIVOS 
                        -->

                        <div class="tab-pane fade" id="datos-educativos" role="tabpanel">
                            <!-- Campos de Bancos -->
                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label for="inputSituacionEducativa">Situación Educativa</label>
                                        <select class="form-control select2" id="inputSituacionEducativa" name="inputSituacionEducativa" required>
                                            <option value="">Seleccione..</option>
                                            <option value="Sin educación formal">Sin educación formal</option>
                                            <option value="Eduación Especial">Eduación Especial </option>  
                                            <option value="Eduación Primaria">Eduación Primaria </option>  
                                            <option value="Educación Secundaria">Educación Secundaria</option>
                                            <option value="Educación Técnica">Educación Técnica</option>
                                            <option value="Educación Superior (Instituto Superior, etc)">Educación Superior (Instituto Superior, etc)</option>
                                            <option value="Educación Universitaria">Educación Universitaria</option>
                                            <option value="Grado Bachiller">Grado Bachiller</option>
                                            <option value="Titulado">Titulado</option>
                                            <option value="Estudio de Maestría">Estudio de Maestría</option>
                                            <option value="Grado de Maestría">Grado de Maestría</option>
                                            <option value="Estudios de Doctorado">Estudios de Doctorado</option>                                             
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputEstadoEducativa"> Estado </label>
                                        <select class="form-control" id="inputEstadoEducativa"
                                            name="inputEstadoEducativa">
                                            <option value="">Seleccione...</option>
                                            <option value="Incompleta">Incompleta</option>
                                            <option value="Completa">Completa</option>
                                            <option value="No aplica">No aplica</option> 
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputTipoRegimen"> Tipo Régimen </label>
                                        <select class="form-control" id="inputTipoRegimen"
                                            name="inputTipoRegimen">
                                            <option value="">Seleccione...</option>
                                            <option value="Pública">Pública</option>
                                            <option value="Privada">Privada</option> 
                                            <option value="No aplica">No aplica</option> 
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label for="inputTipoInstitucion">Tipo de Institución</label>
                                        <select class="form-control select2" id="inputTipoInstitucion" name="inputTipoInstitucion" required>
                                            <option value="">Seleccione..</option> 
                                            <option value="Educación Superior de Formación Artistica">Educación Superior de Formación Artistica</option>   
                                            <option value="Escuela e Institutos de Educación Superior Tecnológicos de las Fuerzas Armadas">Escuela e Institutos de Educación Superior Tecnológicos de las Fuerzas Armadas</option>   
                                            <option value="Instituto Superior Pedagógico">Instituto Superior Pedagógico</option>   
                                            <option value="Institutos de Educación Superior Tecnológica (IEST) ">Institutos de Educación Superior Tecnológica (IEST) </option>   
                                            <option value="Universidad">Universidad</option>   
                                            <option value="No Especificado">No Especificado</option>   
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label for="inputInstitucion">Ingrese Institución</label>
                                        <input type="text" class="form-control" id="inputInstitucion"
                                            name="inputInstitucion" placeholder="Ingrese Institución">
                                    </div>
                                </div>

                                <div class="form-group col-md-9">
                                    <div class="form-group">
                                        <label for="inputCarrera">Ingrese Carrera</label>
                                        <input type="text" class="form-control" id="inputCarrera"
                                            name="inputCarrera" placeholder="Ingrese Carrera">
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputAnio">Ingrese Año</label>
                                        <input type="text" class="form-control" id="inputAnio"
                                            name="inputAnio" placeholder="Ingrese Año">
                                    </div>
                                </div>


                            </div>
                        </div>

                        <!-- 
                        -- DATOS CONTACTO 
                        -->

                        <div class="tab-pane fade" id="datos-contactos" role="tabpanel">
                            <!-- Campos de Bancos -->
                            <div class="form-row">

                                <div class="form-group col-md-12">
                                    <div class="form-group">
                                        <label> (*) Contacto en caso de emergencia </label>
                                    </div>
                                </div>

                                <div class="form-group col-md-5">
                                    <div class="form-group">
                                        <label for="inputNombreFamiliar">Nombre Familiar</label>
                                        <input type="text" class="form-control" id="inputNombreFamiliar"
                                            name="inputNombreFamiliar" placeholder="Ingrese Nombre Familiar">
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="inputTelefonoFamiliar">Teléfono Familiar</label>
                                        <input type="text" class="form-control" id="inputTelefonoFamiliar"
                                            name="inputTelefonoFamiliar" data-inputmask="'mask':'(99) 999-999-999'"
                                            data-mask>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="inputParentesco">Parentesco</label>
                                        <input type="text" class="form-control" id="inputParentesco"
                                            name="inputParentesco" placeholder="Ingrese Parentesco">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- 
                        -- DOCUMENTACIÓN 
                        -->

                        <div class="tab-pane fade" id="documentacion" role="tabpanel">
                            <!-- Campos de Bancos -->
                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="inputFechaVencimientoDocumento">Fecha Vencimiento Documento</label>
                                        <div class="input-group date" id="fechaVencimientoDocumentoDatePicker"
                                            data-target-input="nearest">
                                            <input type="text" id="inputFechaVencimientoDocumento" name="inputFechaVencimientoDocumento"
                                                placeholder="DD/MM/YYYY" required
                                                class="form-control datetimepicker-input"
                                                data-target="#fechaVencimientoDocumentoDatePicker">
                                            <div class="input-group-append" data-target="#fechaVencimientoDocumentoDatePicker"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-md-8">
                                    <div class="form-group">
                                        <label for="inputAdjuntarDocumentoIdentidad">Adjuntar Documento de
                                            Identidad</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input solo-pdf"
                                                id="inputAdjuntarDocumentoIdentidad"
                                                name="inputAdjuntarDocumentoIdentidad" accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="inputAdjuntarDocumentoIdentidad"
                                                data-browse="Examinar">Seleccionar</label>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="form-group col-md-8">
                                    <div class="form-group">
                                        <label for="inputLugarResidencia">Marcar si el trabajador tiene algun tipo de
                                            licencia
                                            de conducir </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radioLicencia"
                                            id="licenciaSi" value="SI">
                                        <label class="form-check-label" for="licenciaSi">Sí</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radioLicencia"
                                            id="licenciaNo" value="NO" checked>
                                        <label class="form-check-label" for="licenciaNo">No</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">

                                    <table class="table table-bordered " id="tablaLicencia">
                                        <thead class="color-fondo-personalizado">
                                            <tr class="text-center">
                                                <th>Clase</th>
                                                <th>Tipo</th>
                                                <th style="width:25%">Fecha de Vencimiento</th>
                                                <th>Adjuntar Archivo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Clase A -->
                                            <tr>
                                                <th rowspan="6" scope="rowgroup" class="align-middle">Clase A</th>
                                                <td class="text-center">A-I</td>
                                                <td>
                                                    <div class="input-group date" id="datePickerAI"
                                                        data-target-input="nearest">
                                                        <input type="text" id="inputFechaVencimientoAI"
                                                            name="inputFechaVencimientoAI"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#datePickerAI" placeholder="DD/MM/YYYY">
                                                        <div class="input-group-append" data-target="#datePickerAI"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputAdjuntarLicenciaAI" name="inputAdjuntarLicenciaAI"
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label" for="inputAdjuntarLicenciaAI"
                                                            data-browse="Examinar">Seleccionar</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">A-IIa</td>
                                                <td>
                                                    <div class="input-group date" id="datePickerAIIa"
                                                        data-target-input="nearest">
                                                        <input type="text" id="inputFechaVencimientoAIIa"
                                                            name="inputFechaVencimientoAIIa"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#datePickerAIIa" placeholder="DD/MM/YYYY">
                                                        <div class="input-group-append" data-target="#datePickerAIIa"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputAdjuntarLicenciaAIIa"
                                                            name="inputAdjuntarLicenciaAIIa"
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label" for="inputAdjuntarLicenciaAIIa"
                                                            data-browse="Examinar">Seleccionar</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">A-IIb</td>
                                                <td>
                                                    <div class="input-group date" id="datePickerAIIb"
                                                        data-target-input="nearest">
                                                        <input type="text" id="inputFechaVencimientoAIIb"
                                                            name="inputFechaVencimientoAIIb"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#datePickerAIIb" placeholder="DD/MM/YYYY">
                                                        <div class="input-group-append" data-target="#datePickerAIIb"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputAdjuntarLicenciaAIIb"
                                                            name="inputAdjuntarLicenciaAIIb"
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label" for="inputAdjuntarLicenciaAIIb"
                                                            data-browse="Examinar">Seleccionar</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">A-IIIa</td>
                                                <td>
                                                    <div class="input-group date" id="datePickerAIIIa"
                                                        data-target-input="nearest">
                                                        <input type="text" id="inputFechaVencimientoAIIIa"
                                                            name="inputFechaVencimientoAIIIa"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#datePickerAIIIa" placeholder="DD/MM/YYYY">
                                                        <div class="input-group-append" data-target="#datePickerAIIIa"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputAdjuntarLicenciaAIIIa"
                                                            name="inputAdjuntarLicenciaAIIIa"
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label"
                                                            for="inputAdjuntarLicenciaAIIIa"
                                                            data-browse="Examinar">Seleccionar</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">A-IIIb</td>
                                                <td>
                                                    <div class="input-group date" id="datePickerAIIIb"
                                                        data-target-input="nearest">
                                                        <input type="text" id="inputFechaVencimientoAIIIb"
                                                            name="inputFechaVencimientoAIIIb"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#datePickerAIIIb" placeholder="DD/MM/YYYY">
                                                        <div class="input-group-append" data-target="#datePickerAIIIb"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputAdjuntarLicenciaAIIIb"
                                                            name="inputAdjuntarLicenciaAIIIb"
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label"
                                                            for="inputAdjuntarLicenciaAIIIb"
                                                            data-browse="Examinar">Seleccionar</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">A-IIIc</td>
                                                <td>
                                                    <div class="input-group date" id="datePickerAIIIc"
                                                        data-target-input="nearest">
                                                        <input type="text" id="inputFechaVencimientoAIIIc"
                                                            name="inputFechaVencimientoAIIIc"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#datePickerAIIIc" placeholder="DD/MM/YYYY">
                                                        <div class="input-group-append" data-target="#datePickerAIIIc"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputAdjuntarLicenciaAIIIc"
                                                            name="inputAdjuntarLicenciaAIIIc"
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label"
                                                            for="inputAdjuntarLicenciaAIIIc"
                                                            data-browse="Examinar">Seleccionar</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Continuar con los demás tipos A-IIIa, A-IIIb, A-IIIc -->

                                            <!-- Clase B -->
                                            <tr>
                                                <th rowspan="4" scope="rowgroup" class="align-middle">Clase B</th>
                                                <td class="text-center">B-I</td>
                                                <td>
                                                    <div class="input-group date" id="datePickerBI"
                                                        data-target-input="nearest">
                                                        <input type="text" id="inputFechaVencimientoBI"
                                                            name="inputFechaVencimientoBI"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#datePickerBI" placeholder="DD/MM/YYYY">
                                                        <div class="input-group-append" data-target="#datePickerBI"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputAdjuntarLicenciaBI" name="inputAdjuntarLicenciaBI"
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label" for="inputAdjuntarLicenciaBI"
                                                            data-browse="Examinar">Seleccionar</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">B-IIa</td>
                                                <td>
                                                    <div class="input-group date" id="datePickerBIIa"
                                                        data-target-input="nearest">
                                                        <input type="text" id="inputFechaVencimientoBIIa"
                                                            name="inputFechaVencimientoBIIa"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#datePickerBIIa" placeholder="DD/MM/YYYY">
                                                        <div class="input-group-append" data-target="#datePickerBIIa"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputAdjuntarLicenciaBIIa"
                                                            name="inputAdjuntarLicenciaBIIa"
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label" for="inputAdjuntarLicenciaBIIa"
                                                            data-browse="Examinar">Seleccionar</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">B-IIb</td>
                                                <td>
                                                    <div class="input-group date" id="datePickerBIIb"
                                                        data-target-input="nearest">
                                                        <input type="text" id="inputFechaVencimientoBIIb"
                                                            name="inputFechaVencimientoBIIb"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#datePickerBIIb" placeholder="DD/MM/YYYY">
                                                        <div class="input-group-append" data-target="#datePickerBIIb"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputAdjuntarLicenciaBIIb"
                                                            name="inputAdjuntarLicenciaBIIb"
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label" for="inputAdjuntarLicenciaBIIb"
                                                            data-browse="Examinar">Seleccionar</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">B-IIc</td>
                                                <td>
                                                    <div class="input-group date" id="datePickerBIIc"
                                                        data-target-input="nearest">
                                                        <input type="text" id="inputFechaVencimientoBIIc"
                                                            name="inputFechaVencimientoBIIc"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#datePickerBIIc" placeholder="DD/MM/YYYY">
                                                        <div class="input-group-append" data-target="#datePickerBIIc"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputAdjuntarLicenciaBIIc"
                                                            name="inputAdjuntarLicenciaBIIc"
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label" for="inputAdjuntarLicenciaBIIc"
                                                            data-browse="Examinar">Seleccionar</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Continuar con los demás tipos B-IIb, B-IIc -->
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>


                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn color-fondo-personalizado"> Guardar</button>
                </div>

            <?php
                $crearEmpleado = new ControladorEmpleados();
                $crearEmpleado -> ctrCrearEmpleado();
            ?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- =================================================================== -->
<!-- ============= 3. MODAL PARA EDITAR EMPLEADO ======== -->
<!-- =================================================================== -->


<div class="modal fade" id="modalEditarEmpleado">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form role="form" method="post" id="formEditarEmpleado" enctype="multipart/form-data" novalidate>

        <!-- Campo oculto para almacenar el ID del empleado -->
        <input type="hidden" id="idEmpleado" name="idEmpleado">

        <div class="modal-header color-fondo-personalizado">
          <h4 class="modal-title">Editar Empleado</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <!-- Nav tabs -->
          <ul class="nav nav-tabs mb-3" id="miTabEditar" role="tablist">

            <li class="nav-item">
              <a class="nav-link active" id="datos-personales-edit-tab" data-toggle="tab" href="#datos-personales-edit" role="tab">
                <strong>Datos Personales</strong>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" id="datos-laborales-edit-tab" data-toggle="tab" href="#datos-laborales-edit" role="tab">
                <strong>Datos Laborales</strong>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" id="datos-educativos-edit-tab" data-toggle="tab" href="#datos-educativos-edit" role="tab">
                <strong>Datos Educativos</strong>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" id="datos-contactos-edit-tab" data-toggle="tab" href="#datos-contactos-edit" role="tab">
                <strong>Datos Contacto</strong>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" id="documentacion-edit-tab" data-toggle="tab" href="#documentacion-edit" role="tab">
                <strong>Documentación</strong>
              </a>
            </li>

          </ul>

          <!-- Tab panes -->
          <div class="tab-content" id="miTabContentEditar">

            <!-- DATOS PERSONALES -->
            <div class="tab-pane fade show active" id="datos-personales-edit" role="tabpanel">
              <div class="form-row">

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarCodigo">Código</label> 
                    <input type="text" class="form-control" id="editarCodigo" name="editarCodigo" readonly>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label for="editarTipoDocumento">Tipo Documento</label>
                  <select class="form-control" id="editarTipoDocumento" name="editarTipoDocumento" required>
                    <option>Seleccione...</option>
                    <option value="DNI">DNI</option>
                    <option value="Carnet de Fuerzas Policiales">Carnet de Fuerzas Policiales</option>
                    <option value="Carnet de Fuerzas Armadas">Carnet de Fuerzas Armadas</option>
                    <option value="Carnet de Extranjería">Carnet de Extranjería</option>
                    <option value="Pasaporte">Pasaporte</option>
                    <option value="Doc. Povisional de Identidad">Doc. Povisional de Identidad</option>
                    <option value="Partida de Nacimiento">Partida de Nacimiento</option>
                  </select>
                </div>

                <div class="form-group col-md-5">
                  <div class="form-group">
                    <label for="editarNumeroDocumento">Nro. Documento</label>
                    <input type="text" class="form-control" id="editarNumeroDocumento" name="editarNumeroDocumento"
                           placeholder="Ingrese número documento" required>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <div class="form-group">
                    <label for="editarApellidoPaterno">Apellido Paterno</label>
                    <input type="text" class="form-control" id="editarApellidoPaterno" name="editarApellidoPaterno"
                           placeholder="Ingrese apellido paterno" required>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <div class="form-group">
                    <label for="editarApellidoMaterno">Apellido Materno</label>
                    <input type="text" class="form-control" id="editarApellidoMaterno" name="editarApellidoMaterno"
                           placeholder="Ingrese apellido materno" required>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <div class="form-group">
                    <label for="editarNombres">Nombres</label>
                    <input type="text" class="form-control" id="editarNombres" name="editarNombres"
                           placeholder="Ingrese Nombres" required>
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarFechaNacimiento">Fecha de Nacimiento</label>
                    <div class="input-group date" id="fechaNacimienntoDatePickerEditar" data-target-input="nearest">
                      <input type="text" id="editarFechaNacimiento" name="editarFechaNacimiento"
                             placeholder="DD/MM/YYYY" required
                             class="form-control datetimepicker-input"
                             data-target="#fechaNacimienntoDatePickerEditar">
                      <div class="input-group-append" data-target="#fechaNacimienntoDatePickerEditar" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarNacionalidad">Nacionalidad</label>
                    <input type="text" class="form-control" id="editarNacionalidad" name="editarNacionalidad"
                           placeholder="Ingrese Nacionalidad" required>
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarSexo">Sexo</label>
                    <select class="form-control" id="editarSexo" name="editarSexo" required>
                      <option value="">Seleccione...</option>
                      <option value="Masculino">Masculino</option>
                      <option value="Femenino">Femenino</option>
                      <option value="Otro">Otro</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarEstadoCivil">Estado Civil</label>
                    <select class="form-control" id="editarEstadoCivil" name="editarEstadoCivil" required>
                      <option value="">Seleccione...</option>
                      <option value="Soltero">Soltero</option>
                      <option value="Casado">Casado</option>
                      <option value="Viudo">Viudo</option>
                      <option value="Divorciado">Divorciado</option>
                      <option value="Conviviente">Conviviente</option>
                      <option value="Otro">Otro</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarNumeroTelefonoMovil">Nro. Movil</label>
                    <input type="text" class="form-control" id="editarNumeroTelefonoMovil" name="editarNumeroTelefonoMovil"
                           data-inputmask="'mask':'(99) 999-999-999'" data-mask>
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarNumeroTelefonoFijo">Nro. Telf. Fijo</label>
                    <input type="text" class="form-control" id="editarNumeroTelefonoFijo" name="editarNumeroTelefonoFijo"
                           data-inputmask="'mask':'(99) 999-9999'" data-mask>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="form-group">
                    <label for="editarCorreo">Correo</label>
                    <input type="email" class="form-control" id="editarCorreo" name="editarCorreo"
                           placeholder="ejemplo@ejemplo.com">
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <div class="form-group">
                    <label for="editarDepartamento">Departamento</label>
                    <input type="text" class="form-control" id="editarDepartamento" name="editarDepartamento"
                           placeholder="Ingrese Departamento">
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <div class="form-group">
                    <label for="editarProvincia">Provincia</label>
                    <input type="text" class="form-control" id="editarProvincia" name="editarProvincia"
                           placeholder="Ingrese Provincia">
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <div class="form-group">
                    <label for="editarDistrito">Distrito</label>
                    <input type="text" class="form-control" id="editarDistrito" name="editarDistrito"
                           placeholder="Ingrese Distrito">
                  </div>
                </div>

                <div class="form-group col-md-12">
                  <div class="form-group">
                    <label for="editarLugarResidencia">Lugar Residencia</label>
                    <input type="text" class="form-control" id="editarLugarResidencia" name="editarLugarResidencia"
                           placeholder="Ingrese lugar de residencia">
                  </div>
                </div>

              </div>
            </div>

            <!-- DATOS LABORALES -->
            <div class="tab-pane fade" id="datos-laborales-edit" role="tabpanel">
              <div class="form-row">

                <div class="form-group col-md-5">
                  <div class="form-group">
                    <label for="editarEmpresa">Empresa</label>
                    <select class="form-control select2" id="editarEmpresa" name="editarEmpresa" required>
                      <option value="">Seleccione..</option>
                      <?php
                        $item = null;
                        $valor = null;
                        $empresa = ControladorEmpresas::ctrMostrarEmpresas($item, $valor);
                        foreach ($empresa as $key => $value) {
                          echo '<option value="'.$value["empre_id"].'">'.$value["empre_ruc"].' '.$value["empre_razon_social"].'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <div class="form-group">
                    <label for="editarFechaIngreso">Fecha Ingreso</label>
                    <div class="input-group date" id="fechaIngresoDatePickerEditar" data-target-input="nearest">
                      <input type="text" id="editarFechaIngreso" name="editarFechaIngreso"
                             placeholder="DD/MM/YYYY" required
                             class="form-control datetimepicker-input"
                             data-target="#fechaIngresoDatePickerEditar">
                      <div class="input-group-append" data-target="#fechaIngresoDatePickerEditar" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarCategoriaOcupacional">Categoría Ocupacional</label>
                    <select class="form-control" id="editarCategoriaOcupacional" name="editarCategoriaOcupacional">
                      <option value="">Seleccione...</option>
                      <option value="Ejecutivo">Ejecutivo</option>
                      <option value="Obrero">Obrero</option>
                      <option value="Empleado">Empleado</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-12">
                  <div class="form-group">
                    <label for="editarCentroCosto">Centro de Costo</label>
                    <select class="form-control select2" id="editarCentroCosto" name="editarCentroCosto" required>
                      <option value="">Seleccione..</option>
                      <?php
                        $item = null;
                        $valor = null;
                        $centroCosto = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor);
                        foreach ($centroCosto as $key => $value) {
                          echo '<option value="'.$value["cenco_id"].'">'.$value["cenco_codigo"].' '.$value["cenco_nombre"].'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="form-group">
                    <label for="editarArea">Área</label>
                    <select class="form-control select2" id="editarArea" name="editarArea" required>
                      <option value="">Seleccione..</option>
                      <?php
                        $item = null;
                        $valor = null;
                        $area = ControladorAreas::ctrMostrarAreas($item, $valor);
                        foreach ($area as $key => $value) {
                          echo '<option value="'.$value["are_id"].'">'.$value["are_nombre"].'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="form-group">
                    <label for="editarCargo">Cargo</label>
                    <select class="form-control select2" id="editarCargo" name="editarCargo" required>
                      <option value="">Seleccione..</option>
                      <?php
                        $item = null;
                        $valor = null;
                        $area = ControladorCargos::ctrMostrarCargos($item, $valor);
                        foreach ($area as $key => $value) {
                          echo '<option value="'.$value["car_id"].'">'.$value["car_nombre"].'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="form-group">
                    <label for="editarEstado">Estado</label>
                    <select class="form-control" id="editarEstado" name="editarEstado">
                      <option value="">Seleccione...</option>
                      <option value="Activo">Activo</option>
                      <option value="Cesado">Cesado</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="form-group">
                    <label for="editarFechaCese">Fecha Cese</label>
                    <div class="input-group date" id="fechaCeseDatePicker" data-target-input="nearest">
                      <input type="text" id="editarFechaCese" name="editarFechaCese"
                             placeholder="DD/MM/YYYY" required
                             class="form-control datetimepicker-input"
                             data-target="#fechaCeseDatePicker">
                      <div class="input-group-append" data-target="#fechaCeseDatePicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <!-- DATOS EDUCATIVOS -->
            <div class="tab-pane fade" id="datos-educativos-edit" role="tabpanel">
              <div class="form-row">

                <div class="form-group col-md-6">
                  <div class="form-group">
                    <label for="editarSituacionEducativa">Situación Educativa</label>
                    <select class="form-control select2" id="editarSituacionEducativa" name="editarSituacionEducativa" required>
                      <option value="">Seleccione..</option>
                      <option value="Sin educación formal">Sin educación formal</option>
                      <option value="Eduación Especial">Eduación Especial</option>
                      <option value="Eduación Primaria">Eduación Primaria</option>
                      <option value="Educación Secundaria">Educación Secundaria</option>
                      <option value="Educación Técnica">Educación Técnica</option>
                      <option value="Educación Superior (Instituto Superior, etc)">Educación Superior (Instituto Superior, etc)</option>
                      <option value="Educación Universitaria">Educación Universitaria</option>
                      <option value="Grado Bachiller">Grado Bachiller</option>
                      <option value="Titulado">Titulado</option>
                      <option value="Estudio de Maestría">Estudio de Maestría</option>
                      <option value="Grado de Maestría">Grado de Maestría</option>
                      <option value="Estudios de Doctorado">Estudios de Doctorado</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarEstadoEducativa">Estado</label>
                    <select class="form-control" id="editarEstadoEducativa" name="editarEstadoEducativa">
                      <option value="">Seleccione...</option>
                      <option value="Incompleta">Incompleta</option>
                      <option value="Completa">Completa</option>
                      <option value="No aplica">No aplica</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarTipoRegimen">Tipo Régimen</label>
                    <select class="form-control" id="editarTipoRegimen" name="editarTipoRegimen">
                      <option value="">Seleccione...</option>
                      <option value="Pública">Pública</option>
                      <option value="Privada">Privada</option>
                      <option value="No aplica">No aplica</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="form-group">
                    <label for="editarTipoInstitucion">Tipo de Institución</label>
                    <select class="form-control select2" id="editarTipoInstitucion" name="editarTipoInstitucion" required>
                      <option value="">Seleccione..</option>
                      <option value="Educación Superior de Formación Artistica">Educación Superior de Formación Artistica</option>
                      <option value="Escuela e Institutos de Educación Superior Tecnológicos de las Fuerzas Armadas">Escuela e Institutos de Educación Superior Tecnológicos de las Fuerzas Armadas</option>
                      <option value="Instituto Superior Pedagógico">Instituto Superior Pedagógico</option>
                      <option value="Institutos de Educación Superior Tecnológica (IEST) ">Institutos de Educación Superior Tecnológica (IEST)</option>
                      <option value="Universidad">Universidad</option>
                      <option value="No Especificado">No Especificado</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="form-group">
                    <label for="editarInstitucion">Ingrese Institución</label>
                    <input type="text" class="form-control" id="editarInstitucion" name="editarInstitucion" placeholder="Ingrese Institución">
                  </div>
                </div>

                <div class="form-group col-md-9">
                  <div class="form-group">
                    <label for="editarCarrera">Ingrese Carrera</label>
                    <input type="text" class="form-control" id="editarCarrera" name="editarCarrera" placeholder="Ingrese Carrera">
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarAnio">Ingrese Año</label>
                    <input type="text" class="form-control" id="editarAnio" name="editarAnio" placeholder="Ingrese Año">
                  </div>
                </div>

              </div>
            </div>

            <!-- DATOS CONTACTO -->
            <div class="tab-pane fade" id="datos-contactos-edit" role="tabpanel">
              <div class="form-row">

                <div class="form-group col-md-12">
                  <div class="form-group">
                    <label>(*) Contacto en caso de emergencia</label>
                  </div>
                </div>

                <div class="form-group col-md-5">
                  <div class="form-group">
                    <label for="editarNombreFamiliar">Nombre Familiar</label>
                    <input type="text" class="form-control" id="editarNombreFamiliar" name="editarNombreFamiliar" placeholder="Ingrese Nombre Familiar">
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <div class="form-group">
                    <label for="editarTelefonoFamiliar">Teléfono Familiar</label>
                    <input type="text" class="form-control" id="editarTelefonoFamiliar" name="editarTelefonoFamiliar"
                           data-inputmask="'mask':'(99) 999-999-999'" data-mask>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <div class="form-group">
                    <label for="editarParentesco">Parentesco</label>
                    <input type="text" class="form-control" id="editarParentesco" name="editarParentesco" placeholder="Ingrese Parentesco">
                  </div>
                </div>

              </div>
            </div>

            <!-- DOCUMENTACIÓN -->
            <div class="tab-pane fade" id="documentacion-edit" role="tabpanel">
              <div class="form-row">

                <div class="form-group col-md-4">
                  <div class="form-group">
                    <label for="editarFechaVencimientoDocumento">Fecha Vencimiento Documento</label>
                    <div class="input-group date" id="fechaVencimientoDocumentoDatePickerEditar" data-target-input="nearest">
                      <input type="text" id="editarFechaVencimientoDocumento" name="editarFechaVencimientoDocumento"
                             placeholder="DD/MM/YYYY" required
                             class="form-control datetimepicker-input"
                             data-target="#fechaVencimientoDocumentoDatePickerEditar">
                      <div class="input-group-append" data-target="#fechaVencimientoDocumentoDatePickerEditar" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group col-md-7">
                  <div class="form-group">
                    <label for="editarAdjuntarDocumentoIdentidad">Adjuntar Documento de Identidad</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input solo-pdf"
                               id="editarAdjuntarDocumentoIdentidad" name="editarAdjuntarDocumentoIdentidad" accept=".pdf,.jpg,.jpeg,.png">
                        <label class="custom-file-label" for="editarAdjuntarDocumentoIdentidad" data-browse="Examinar">Seleccionar</label>
                      </div>
                      <div id="editarArchivoDocumentoActual" class="input-group-append">
                        <!-- botón de ver se inserta aquí -->
                      </div>
                    </div>
                  </div>
                
                </div>

                <div class="form-group col-md-1" id="editarArchivoDocumentoActual">                  
                      <!-- Se llenará con JavaScript -->
                </div>

                <div class="form-group col-md-8">
                  <div class="form-group">
                    <label>Marcar si el trabajador tiene algun tipo de licencia de conducir</label>
                  </div>
                </div>
                <div class="form-group col-md-2">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="editarRadioLicencia" id="editarLicenciaSi" value="SI">
                    <label class="form-check-label" for="editarLicenciaSi">Sí</label>
                  </div>
                </div>
                <div class="form-group col-md-2">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="editarRadioLicencia" id="editarLicenciaNo" value="NO" checked>
                    <label class="form-check-label" for="editarLicenciaNo">No</label>
                  </div>
                </div>

                <div class="form-group col-md-12">
                  <table class="table table-bordered" id="tablaLicenciaEditar">
                    <thead class="color-fondo-personalizado">
                      <tr class="text-center">
                        <th>Clase</th>
                        <th>Tipo</th>
                        <th style="width:25%">Fecha de Vencimiento</th>
                        <th>Adjuntar Archivo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Clase A -->
                      <tr>
                        <th rowspan="6" scope="rowgroup" class="align-middle">Clase A</th>
                        <td class="text-center">A-I</td>
                        <td>
                          <div class="input-group date" id="datePickerAIEditar" data-target-input="nearest">
                            <input type="text" id="editarFechaVencimientoAI" name="editarFechaVencimientoAI"
                                   class="form-control datetimepicker-input" data-target="#datePickerAIEditar" placeholder="DD/MM/YYYY">
                            <div class="input-group-append" data-target="#datePickerAIEditar" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="editarAdjuntarLicenciaAI" name="editarAdjuntarLicenciaAI" accept=".pdf,.jpg,.jpeg,.png">
                              <label class="custom-file-label" for="editarAdjuntarLicenciaAI" data-browse="Examinar">Seleccionar</label>
                            </div>
                            <div class="input-group-append archivo-licencia" data-campo="editarAdjuntarLicenciaAI"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td class="text-center">A-IIa</td>
                        <td>
                          <div class="input-group date" id="datePickerAIIaEditar" data-target-input="nearest">
                            <input type="text" id="editarFechaVencimientoAIIa" name="editarFechaVencimientoAIIa"
                                   class="form-control datetimepicker-input" data-target="#datePickerAIIaEditar" placeholder="DD/MM/YYYY">
                            <div class="input-group-append" data-target="#datePickerAIIaEditar" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="editarAdjuntarLicenciaAIIa" name="editarAdjuntarLicenciaAIIa" accept=".pdf,.jpg,.jpeg,.png">
                              <label class="custom-file-label" for="editarAdjuntarLicenciaAIIa" data-browse="Examinar">Seleccionar</label>
                            </div>
                            <div class="input-group-append archivo-licencia" data-campo="editarAdjuntarLicenciaAIIa"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td class="text-center">A-IIb</td>
                        <td>
                          <div class="input-group date" id="datePickerAIIbEditar" data-target-input="nearest">
                            <input type="text" id="editarFechaVencimientoAIIb" name="editarFechaVencimientoAIIb"
                                   class="form-control datetimepicker-input" data-target="#datePickerAIIbEditar" placeholder="DD/MM/YYYY">
                            <div class="input-group-append" data-target="#datePickerAIIbEditar" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="editarAdjuntarLicenciaAIIb" name="editarAdjuntarLicenciaAIIb" accept=".pdf,.jpg,.jpeg,.png">
                              <label class="custom-file-label" for="editarAdjuntarLicenciaAIIb" data-browse="Examinar">Seleccionar</label>
                            </div>
                            <div class="input-group-append archivo-licencia" data-campo="editarAdjuntarLicenciaAIIb"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td class="text-center">A-IIIa</td>
                        <td>
                          <div class="input-group date" id="datePickerAIIIaEditar" data-target-input="nearest">
                            <input type="text" id="editarFechaVencimientoAIIIa" name="editarFechaVencimientoAIIIa"
                                   class="form-control datetimepicker-input" data-target="#datePickerAIIIaEditar" placeholder="DD/MM/YYYY">
                            <div class="input-group-append" data-target="#datePickerAIIIaEditar" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="editarAdjuntarLicenciaAIIIa" name="editarAdjuntarLicenciaAIIIa" accept=".pdf,.jpg,.jpeg,.png">
                              <label class="custom-file-label" for="editarAdjuntarLicenciaAIIIa" data-browse="Examinar">Seleccionar</label>
                            </div>
                            <div class="input-group-append archivo-licencia" data-campo="editarAdjuntarLicenciaAIIIa"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td class="text-center">A-IIIb</td>
                        <td>
                          <div class="input-group date" id="datePickerAIIIbEditar" data-target-input="nearest">
                            <input type="text" id="editarFechaVencimientoAIIIb" name="editarFechaVencimientoAIIIb"
                                   class="form-control datetimepicker-input" data-target="#datePickerAIIIbEditar" placeholder="DD/MM/YYYY">
                            <div class="input-group-append" data-target="#datePickerAIIIbEditar" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="editarAdjuntarLicenciaAIIIb" name="editarAdjuntarLicenciaAIIIb" accept=".pdf,.jpg,.jpeg,.png">
                              <label class="custom-file-label" for="editarAdjuntarLicenciaAIIIb" data-browse="Examinar">Seleccionar</label>
                            </div>
                            <div class="input-group-append archivo-licencia" data-campo="editarAdjuntarLicenciaAIIIb"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td class="text-center">A-IIIc</td>
                        <td>
                          <div class="input-group date" id="datePickerAIIIcEditar" data-target-input="nearest">
                            <input type="text" id="editarFechaVencimientoAIIIc" name="editarFechaVencimientoAIIIc"
                                   class="form-control datetimepicker-input" data-target="#datePickerAIIIcEditar" placeholder="DD/MM/YYYY">
                            <div class="input-group-append" data-target="#datePickerAIIIcEditar" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="editarAdjuntarLicenciaAIIIc" name="editarAdjuntarLicenciaAIIIc" accept=".pdf,.jpg,.jpeg,.png">
                              <label class="custom-file-label" for="editarAdjuntarLicenciaAIIIc" data-browse="Examinar">Seleccionar</label>
                            </div>
                            <div class="input-group-append archivo-licencia" data-campo="editarAdjuntarLicenciaAIIIc"></div>
                          </div>
                        </td>
                      </tr>

                      <!-- Clase B -->
                      <tr>
                        <th rowspan="4" scope="rowgroup" class="align-middle">Clase B</th>
                        <td class="text-center">B-I</td>
                        <td>
                          <div class="input-group date" id="datePickerBIEditar" data-target-input="nearest">
                            <input type="text" id="editarFechaVencimientoBI" name="editarFechaVencimientoBI"
                                   class="form-control datetimepicker-input" data-target="#datePickerBIEditar" placeholder="DD/MM/YYYY">
                            <div class="input-group-append" data-target="#datePickerBIEditar" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="editarAdjuntarLicenciaBI" name="editarAdjuntarLicenciaBI" accept=".pdf,.jpg,.jpeg,.png">
                              <label class="custom-file-label" for="editarAdjuntarLicenciaBI" data-browse="Examinar">Seleccionar</label>
                            </div>
                            <div class="input-group-append archivo-licencia" data-campo="editarAdjuntarLicenciaBI"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td class="text-center">B-IIa</td>
                        <td>
                          <div class="input-group date" id="datePickerBIIaEditar" data-target-input="nearest">
                            <input type="text" id="editarFechaVencimientoBIIa" name="editarFechaVencimientoBIIa"
                                   class="form-control datetimepicker-input" data-target="#datePickerBIIaEditar" placeholder="DD/MM/YYYY">
                            <div class="input-group-append" data-target="#datePickerBIIaEditar" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="editarAdjuntarLicenciaBIIa" name="editarAdjuntarLicenciaBIIa" accept=".pdf,.jpg,.jpeg,.png">
                              <label class="custom-file-label" for="editarAdjuntarLicenciaBIIa" data-browse="Examinar">Seleccionar</label>
                            </div>
                            <div class="input-group-append archivo-licencia" data-campo="editarAdjuntarLicenciaBIIa"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td class="text-center">B-IIb</td>
                        <td>
                          <div class="input-group date" id="datePickerBIIbEditar" data-target-input="nearest">
                            <input type="text" id="editarFechaVencimientoBIIb" name="editarFechaVencimientoBIIb"
                                   class="form-control datetimepicker-input" data-target="#datePickerBIIbEditar" placeholder="DD/MM/YYYY">
                            <div class="input-group-append" data-target="#datePickerBIIbEditar" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="editarAdjuntarLicenciaBIIb" name="editarAdjuntarLicenciaBIIb" accept=".pdf,.jpg,.jpeg,.png">
                              <label class="custom-file-label" for="editarAdjuntarLicenciaBIIb" data-browse="Examinar">Seleccionar</label>
                            </div>
                            <div class="input-group-append archivo-licencia" data-campo="editarAdjuntarLicenciaBIIb"></div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td class="text-center">B-IIc</td>
                        <td>
                          <div class="input-group date" id="datePickerBIIcEditar" data-target-input="nearest">
                            <input type="text" id="editarFechaVencimientoBIIc" name="editarFechaVencimientoBIIc"
                                   class="form-control datetimepicker-input" data-target="#datePickerBIIcEditar" placeholder="DD/MM/YYYY">
                            <div class="input-group-append" data-target="#datePickerBIIcEditar" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="editarAdjuntarLicenciaBIIc" name="editarAdjuntarLicenciaBIIc" accept=".pdf,.jpg,.jpeg,.png">
                              <label class="custom-file-label" for="editarAdjuntarLicenciaBIIc" data-browse="Examinar">Seleccionar</label>
                            </div>
                            <div class="input-group-append archivo-licencia" data-campo="editarAdjuntarLicenciaBIIc"></div>
                          </div>
                        </td>
                      </tr>

                    </tbody>
                  </table>

                </div>

              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn color-fondo-personalizado">Guardar cambios</button>
        </div>

        <?php
          $editarEmpleado = new ControladorEmpleados();
          $editarEmpleado->ctrEditarEmpleado();
        ?>

      </form>
    </div>
  </div>
</div>


