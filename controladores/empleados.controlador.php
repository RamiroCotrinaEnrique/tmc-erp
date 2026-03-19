<?php

class ControladorEmpleados {

    /*-------------------------------------
    LISTAR CENTRO DE COSTO
    -------------------------------------*/

    static public function ctrMostrarEmpleados( $item, $valor ) {
        $tabla = 'empleados';
        $respuesta = ModeloEmpleados::mdlMostrarEmpleados( $tabla, $item, $valor );
        return $respuesta;
    }

/* ========================================================== */
/* =================== 2. CREAR EMPLEADOS =================== */
/* ========================================================== */

    static public function ctrCrearEmpleado(){

        if(isset($_POST["inputNumeroDocumento"])){
            // ============================================
            // VALIDACIÓN DE CAMPOS REQUERIDOS (SERVER-SIDE)
            // ============================================
            $errores = [];

            // Campos requeridos según el formulario
            $camposRequeridos = [
                "inputCodigo" => "Código",
                "inputTipoDocumento" => "Tipo de documento",
                "inputNumeroDocumento" => "Número de documento",
                "inputApellidoPaterno" => "Apellido paterno",
                "inputApellidoMaterno" => "Apellido materno",
                "inputNombres" => "Nombres",
                "inputFechaNacimiento" => "Fecha de nacimiento",
                "inputNacionalidad" => "Nacionalidad",
                "inputSexo" => "Sexo",
                "inputEstadoCivil" => "Estado civil",
                "inputEmpresa" => "Empresa",
                "inputFechaIngreso" => "Fecha de ingreso",
                "inputCentroCosto" => "Centro de costo",
                "inputArea" => "Área",
                "inputCargo" => "Cargo",
            ];

            foreach ($camposRequeridos as $campo => $label) {
                if (empty($_POST[$campo])) {
                    $errores[] = "El campo $label es obligatorio.";
                }
            }

            // Validar formato de fechas (esperado DD/MM/YYYY)
            $fechasAChequear = [
                'inputFechaNacimiento', 'inputFechaIngreso', 'inputFechaCese', 'inputFechaVencimientoDocumento',
            ];
            foreach ($fechasAChequear as $fechaField) {
                if (!empty($_POST[$fechaField])) {
                    $d = DateTime::createFromFormat('d/m/Y', $_POST[$fechaField]);
                    if (!$d || $d->format('d/m/Y') !== $_POST[$fechaField]) {
                        $errores[] = "Formato de fecha inválido en: $fechaField. Use DD/MM/YYYY.";
                    }
                }
            }


            // ==============================================================
            // 1. MAPA DE ARCHIVOS PARA VALIDACIÓN Y RENOMBRADO
            // ==============================================================
            $mapaArchivos = [
                // "Nombre del input en el form" => ["columna" => "Nombre en la BD", "nombre_base" => "Nombre para el archivo PDF"]
                "inputAdjuntarDocumentoIdentidad" => ["columna" => "emple_archivo_documento", "nombre_base" => "documento"],
                "inputAdjuntarLicenciaAI" => ["columna" => "emple_archivo_a1", "nombre_base" => "a1"],
                "inputAdjuntarLicenciaAIIa" => ["columna" => "emple_archivo_a2a", "nombre_base" => "a2a"],
                "inputAdjuntarLicenciaAIIb" => ["columna" => "emple_archivo_a2b", "nombre_base" => "a2b"],
                "inputAdjuntarLicenciaAIIIa" => ["columna" => "emple_archivo_a3a", "nombre_base" => "a3a"],
                "inputAdjuntarLicenciaAIIIb" => ["columna" => "emple_archivo_a3b", "nombre_base" => "a3b"],
                "inputAdjuntarLicenciaAIIIc" => ["columna" => "emple_archivo_a3c", "nombre_base" => "a3c"],
                "inputAdjuntarLicenciaBI" => ["columna" => "emple_archivo_b1", "nombre_base" => "b1"],
                "inputAdjuntarLicenciaBIIa" => ["columna" => "emple_archivo_b2a", "nombre_base" => "b2a"],
                "inputAdjuntarLicenciaBIIb" => ["columna" => "emple_archivo_b2b", "nombre_base" => "b2b"],
                "inputAdjuntarLicenciaBIIc" => ["columna" => "emple_archivo_b2c", "nombre_base" => "b2c"]
            ];

            // Antes de validar archivos, chequear errores de campos
            if (!empty($errores)) {
                // Mostrar como lista HTML
                $mensaje = '<ul style="text-align:left;">';
                foreach ($errores as $err) {
                    $mensaje .= '<li>' . htmlspecialchars($err) . '</li>';
                }
                $mensaje .= '</ul>';
                echo "<script>swal({ type: 'error', title: 'Errores en el formulario', html: '$mensaje', showConfirmButton: true, confirmButtonText: 'Cerrar' });</script>";
                return;
            }

            foreach ($mapaArchivos as $nombreCampo => $info) {
                if(isset($_FILES[$nombreCampo]) && $_FILES[$nombreCampo]["error"] == 0){
                    $archivo = $_FILES[$nombreCampo];
                    // Permitir PDF e imágenes comunes
                    $allowedTypes = [
                        'application/pdf',
                        'image/jpeg',
                        'image/jpg',
                        'image/png'
                    ];
                    if($archivo["size"] > 2000000 || !in_array($archivo["type"], $allowedTypes)){
                        echo json_encode([
                            'status' => 'error',
                            'title' => 'Archivo inválido: ' . $archivo["name"],
                            'message' => 'El archivo debe ser PDF o imagen (JPG/PNG) y pesar menos de 2MB.'
                        ]);
                        return;
                    }
                }
            }

            // ============================================
            // 2. PROCESAR Y MOVER ARCHIVOS
            // ============================================
            
            $codigoEmpleado = $_POST["inputCodigo"];
            $numeroDocumento = $_POST["inputNumeroDocumento"];
            
            // ensure path is always resolved from project root (not current working directory)
            $basePath = dirname(__DIR__) . "/vistas/archivos/empleados/";
            $directorio = $basePath . $codigoEmpleado . "/";
            if (!file_exists($directorio)) {
                mkdir($directorio, 0755, true);
            }

            function procesarArchivo($archivo, $directorio, $nombreBase, $numeroDocumento) {
                if(isset($archivo) && $archivo["error"] == 0){
                    // conservar la extension original
                    $ext = pathinfo($archivo['name'], PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    // Añadir timestamp (fecha y hora) para evitar conflictos
                    $timestamp = date('YmdHis');
                    $nombreArchivo = $nombreBase . "_" . $numeroDocumento . "_" . $timestamp . "." . $ext;
                    if(move_uploaded_file($archivo["tmp_name"], $directorio . $nombreArchivo)){
                        return $nombreArchivo;
                    }
                }
                return null;
            }

            $archivosGuardados = [];
            foreach ($mapaArchivos as $nombreCampo => $info) {
                $archivosGuardados[$info["columna"]] = procesarArchivo(
                    $_FILES[$nombreCampo], 
                    $directorio, 
                    $info["nombre_base"],
                    $numeroDocumento
                );
            }

            // ============================================
            // 3. PREPARAR Y LIMPIAR LOS DATOS PARA LA BASE DE DATOS
            // ============================================

            function limpiarTelefono($telefono) { if (empty($telefono)) return null; return preg_replace('/[^0-9]/', '', $telefono); }
            function formatearFecha($fecha) { if (empty($fecha)) return null; try { $fechaObj = DateTime::createFromFormat('d/m/Y', $fecha); return $fechaObj ? $fechaObj->format('Y-m-d') : null; } catch (Exception $e) { return null; } }
            function formatearFechaHora($fechaHora) { if (empty($fechaHora)) return null; try { $fechaObj = DateTime::createFromFormat('d/m/Y', $fechaHora); return $fechaObj ? $fechaObj->format('Y-m-d H:i:s') : null; } catch (Exception $e) { return null; } }

            $datos = array(
                "emple_codigo" => $_POST["inputCodigo"] ?? null,
                "emple_tipo_documento" => $_POST["inputTipoDocumento"] ?? null,
                "emple_numero_documento" => $_POST["inputNumeroDocumento"] ?? null,
                "emple_apellido_paterno" => $_POST["inputApellidoPaterno"] ?? null,
                "emple_apellido_materno" => $_POST["inputApellidoMaterno"] ?? null,
                "emple_nombres" => $_POST["inputNombres"] ?? null,
                "emple_fecha_nacimiento" => formatearFecha($_POST["inputFechaNacimiento"] ?? null),
                "emple_nacionalidad" => $_POST["inputNacionalidad"] ?? null,
                "emple_sexo" => $_POST["inputSexo"] ?? null,
                "emple_estado_civil" => $_POST["inputEstadoCivil"] ?? null,
                "emple_telefono_movil" => limpiarTelefono($_POST["inputNumeroTelefonoMovil"] ?? null),
                "emple_telefono_fijo" => limpiarTelefono($_POST["inputNumeroTelefonoFijo"] ?? null),
                "emple_correo" => $_POST["inputCorreo"] ?? null,
                "emple_departamento" => $_POST["inputDepartamento"] ?? null,
                "emple_provincia" => $_POST["inputProvincia"] ?? null,
                "emple_distrito" => $_POST["inputDistrito"] ?? null,
                "emple_lugar_residencia" => $_POST["inputLugarResidencia"] ?? null,
                "emple_empresa_id" => $_POST["inputEmpresa"] ?? 1,
                "emple_fecha_ingreso" => formatearFecha($_POST["inputFechaIngreso"] ?? null),
                "emple_categoria_ocupacional" => $_POST["inputCategoriaOcupacional"] ?? null,
                "emple_cenco_id" => $_POST["inputCentroCosto"] ?? 1,
                "emple_area_id" => $_POST["inputArea"] ?? 1,
                "emple_cargo_id" => $_POST["inputCargo"] ?? 1,
                "emple_estado" => $_POST["inputEstado"] ?? null,
                "emple_fecha_cese" => formatearFecha($_POST["inputFechaCese"] ?? null),
                "emple_situacion_educativa" => $_POST["inputSituacionEducativa"] ?? null,
                "emple_estado_educativa" => $_POST["inputEstadoEducativa"] ?? null,
                "emple_tipo_regimen" => $_POST["inputTipoRegimen"] ?? null,
                "emple_tipo_institucion" => $_POST["inputTipoInstitucion"] ?? null,
                "emple_institucion" => $_POST["inputInstitucion"] ?? null,
                "emple_carrera" => $_POST["inputCarrera"] ?? null,
                "emple_anio" => $_POST["inputAnio"] ?? null,
                "emple_nombre_familiar" => $_POST["inputNombreFamiliar"] ?? null,
                "emple_telefono_familiar" => limpiarTelefono($_POST["inputTelefonoFamiliar"] ?? null),
                "emple_parentesco" => $_POST["inputParentesco"] ?? null,
                "emple_fecha_vencimiento_documento" => formatearFecha($_POST["inputFechaVencimientoDocumento"] ?? null),
                "emple_licencia" => $_POST["radioLicencia"] ?? null,
                "emple_id_usuario" => $_SESSION["id_usuario"] ?? 1,

                // Archivo de documento identidad
                "emple_archivo_documento" => $archivosGuardados["emple_archivo_documento"],

                // Fechas y Archivos de Licencias
                "emple_fecha_vencimiento_a1" => formatearFechaHora($_POST["inputFechaVencimientoAI"] ?? null),
                "emple_archivo_a1" => $archivosGuardados["emple_archivo_a1"],
                "emple_fecha_vencimiento_a2a" => formatearFechaHora($_POST["inputFechaVencimientoAIIa"] ?? null),
                "emple_archivo_a2a" => $archivosGuardados["emple_archivo_a2a"],
                "emple_fecha_vencimiento_a2b" => formatearFechaHora($_POST["inputFechaVencimientoAIIb"] ?? null),
                "emple_archivo_a2b" => $archivosGuardados["emple_archivo_a2b"],
                "emple_fecha_vencimiento_a3a" => formatearFechaHora($_POST["inputFechaVencimientoAIIIa"] ?? null),
                "emple_archivo_a3a" => $archivosGuardados["emple_archivo_a3a"],
                "emple_fecha_vencimiento_a3b" => formatearFechaHora($_POST["inputFechaVencimientoAIIIb"] ?? null),
                "emple_archivo_a3b" => $archivosGuardados["emple_archivo_a3b"],
                "emple_fecha_vencimiento_a3c" => formatearFechaHora($_POST["inputFechaVencimientoAIIIc"] ?? null),
                "emple_archivo_a3c" => $archivosGuardados["emple_archivo_a3c"],
                "emple_fecha_vencimiento_b1" => formatearFechaHora($_POST["inputFechaVencimientoBI"] ?? null),
                "emple_archivo_b1" => $archivosGuardados["emple_archivo_b1"],
                "emple_fecha_vencimiento_b2a" => formatearFechaHora($_POST["inputFechaVencimientoBIIa"] ?? null),
                "emple_archivo_b2a" => $archivosGuardados["emple_archivo_b2a"],
                "emple_fecha_vencimiento_b2b" => formatearFechaHora($_POST["inputFechaVencimientoBIIb"] ?? null),
                "emple_archivo_b2b" => $archivosGuardados["emple_archivo_b2b"],
                "emple_fecha_vencimiento_b2c" => formatearFechaHora($_POST["inputFechaVencimientoBIIc"] ?? null),
                "emple_archivo_b2c" => $archivosGuardados["emple_archivo_b2c"],
            );
          
            // ============================================
            // 4. ENVIAR DATOS AL MODELO
            // ============================================
            $respuesta = ModeloEmpleados::mdlIngresarEmpleado("empleados", $datos);

            if($respuesta == "ok"){
                echo '<script>
                    swal({
                        type: "success",
                        title: "¡El empleado ha sido guardado correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "empleados";
                        }
                    });
                </script>';
            } else {
                // Log error for debugging
                error_log("Error al guardar empleado: " . print_r($respuesta, true));
                echo '<script>
                    swal({
                        type: "error",
                        title: "¡Error al guardar en la base de datos!",
                        text: "Ocurrió un problema al registrar al empleado. Revise los datos e intente de nuevo.",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    });
                </script>';
            }
        }
    }

/* ========================================================== */
/* =================== 3. EDITAR EMPLEADOS =================== */
/* ========================================================== */

    static public function ctrEditarEmpleado() {
        // GET - Cargar datos del empleado para el modal de edición
        if(isset($_POST["idEmpleado"]) && !isset($_POST["editarApellidoPaterno"])){
            $idEmpleado = $_POST["idEmpleado"];
            $tabla = "empleados";
            $item = "emple_id";
            $valor = $idEmpleado;
            $respuesta = ModeloEmpleados::mdlMostrarEmpleados($tabla, $item, $valor);
            echo json_encode($respuesta);
            return;
        }

        // POST - Actualizar empleado
        if(isset($_POST["editarApellidoPaterno"])){
            // ============================================
            // VALIDACIÓN DE CAMPOS REQUERIDOS (SERVER-SIDE)
            // ============================================
            $errores = [];

            // Campos requeridos en edición
            $camposRequeridos = [
                "idEmpleado" => "ID del empleado",
                "editarApellidoPaterno" => "Apellido paterno",
                "editarApellidoMaterno" => "Apellido materno",
                "editarNombres" => "Nombres",
            ];

            foreach ($camposRequeridos as $campo => $label) {
                if (empty($_POST[$campo])) {
                    $errores[] = "El campo $label es obligatorio.";
                }
            }

            // Validar formato de fechas (esperado DD/MM/YYYY)
            $fechasAChequear = [
                'editarFechaNacimiento', 'editarFechaIngreso', 'editarFechaCese', 'editarFechaVencimientoDocumento',
                'editarFechaVencimientoAI', 'editarFechaVencimientoAIIa', 'editarFechaVencimientoAIIb',
                'editarFechaVencimientoAIIIa', 'editarFechaVencimientoAIIIb', 'editarFechaVencimientoAIIIc',
                'editarFechaVencimientoBI', 'editarFechaVencimientoBIIa', 'editarFechaVencimientoBIIb', 'editarFechaVencimientoBIIc'
            ];

            foreach ($fechasAChequear as $fechaField) {
                if (!empty($_POST[$fechaField])) {
                    $d = DateTime::createFromFormat('d/m/Y', $_POST[$fechaField]);
                    if (!$d || $d->format('d/m/Y') !== $_POST[$fechaField]) {
                        $errores[] = "Formato de fecha inválido en: $fechaField. Use DD/MM/YYYY.";
                    }
                }
            }

            // Mostrar errores de validación si existen
            if (!empty($errores)) {
                echo json_encode([
                    'status' => 'error',
                    'title' => 'Errores en el formulario',
                    'errors' => $errores
                ]);
                return;
            }

            // ==============================================================
            // 1. MAPA DE ARCHIVOS PARA VALIDACIÓN Y RENOMBRADO (EDICIÓN)
            // ==============================================================
            $mapaArchivos = [
                // documento identidad (campo adicional en la edición)
                "editarAdjuntarDocumentoIdentidad" => ["columna" => "emple_archivo_documento", "nombre_base" => "documento"],
                "editarAdjuntarLicenciaAI" => ["columna" => "emple_archivo_a1", "nombre_base" => "a1"],
                "editarAdjuntarLicenciaAIIa" => ["columna" => "emple_archivo_a2a", "nombre_base" => "a2a"],
                "editarAdjuntarLicenciaAIIb" => ["columna" => "emple_archivo_a2b", "nombre_base" => "a2b"],
                "editarAdjuntarLicenciaAIIIa" => ["columna" => "emple_archivo_a3a", "nombre_base" => "a3a"],
                "editarAdjuntarLicenciaAIIIb" => ["columna" => "emple_archivo_a3b", "nombre_base" => "a3b"],
                "editarAdjuntarLicenciaAIIIc" => ["columna" => "emple_archivo_a3c", "nombre_base" => "a3c"],
                "editarAdjuntarLicenciaBI" => ["columna" => "emple_archivo_b1", "nombre_base" => "b1"],
                "editarAdjuntarLicenciaBIIa" => ["columna" => "emple_archivo_b2a", "nombre_base" => "b2a"],
                "editarAdjuntarLicenciaBIIb" => ["columna" => "emple_archivo_b2b", "nombre_base" => "b2b"],
                "editarAdjuntarLicenciaBIIc" => ["columna" => "emple_archivo_b2c", "nombre_base" => "b2c"]
            ];

            // Validar archivos si existen
            foreach ($mapaArchivos as $nombreCampo => $info) {
                if(isset($_FILES[$nombreCampo]) && $_FILES[$nombreCampo]["error"] == 0){
                    $archivo = $_FILES[$nombreCampo];
                    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                    if($archivo["size"] > 2000000 || !in_array($archivo["type"], $allowedTypes)){
                        echo '<script>
                            swal({
                                  type: "error",
                                  title: "Archivo inválido: '.$archivo["name"].'",
                                  text: "El archivo debe ser PDF o imagen (JPG/PNG) y pesar menos de 2MB.",
                                  showConfirmButton: true,
                                  confirmButtonText: "Cerrar"
                                });
                        </script>';
                        return;
                    }
                }
            }

            // ============================================
            // 2. PROCESAR Y MOVER ARCHIVOS
            // ============================================
            $idEmpleado = $_POST["idEmpleado"];
            $numeroDocumento = $_POST["editarNumeroDocumento"] ?? "";
            $codigoEmpleado = $_POST["editarCodigo"] ?? "EMP";

            // base path from project root so AJAX calls work correctly
            $basePath = dirname(__DIR__) . "/vistas/archivos/empleados/";
            $directorio = $basePath . $codigoEmpleado . "/";
            if (!file_exists($directorio)) {
                mkdir($directorio, 0755, true);
            }

            function procesarArchivo($archivo, $directorio, $nombreBase, $numeroDocumento) {
                if(isset($archivo) && $archivo["error"] == 0){
                    $ext = pathinfo($archivo['name'], PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    // Añadir timestamp (fecha y hora) para evitar conflictos
                    $timestamp = date('YmdHis');
                    $nombreArchivo = $nombreBase . "_" . $numeroDocumento . "_" . $timestamp . "." . $ext;
                    if(move_uploaded_file($archivo["tmp_name"], $directorio . $nombreArchivo)){
                        return $nombreArchivo;
                    }
                }
                return null;
            }

            $archivosGuardados = [];
            foreach ($mapaArchivos as $nombreCampo => $info) {
                $archivosGuardados[$info["columna"]] = procesarArchivo(
                    $_FILES[$nombreCampo] ?? null, 
                    $directorio, 
                    $info["nombre_base"],
                    $numeroDocumento
                );
            }

            // ============================================
            // 3. PREPARAR Y LIMPIAR LOS DATOS PARA LA BASE DE DATOS
            // ============================================

            function limpiarTelefono($telefono) { if (empty($telefono)) return null; return preg_replace('/[^0-9]/', '', $telefono); }
            function formatearFecha($fecha) { if (empty($fecha)) return null; try { $fechaObj = DateTime::createFromFormat('d/m/Y', $fecha); return $fechaObj ? $fechaObj->format('Y-m-d') : null; } catch (Exception $e) { return null; } }
            function formatearFechaHora($fechaHora) { if (empty($fechaHora)) return null; try { $fechaObj = DateTime::createFromFormat('d/m/Y', $fechaHora); return $fechaObj ? $fechaObj->format('Y-m-d H:i:s') : null; } catch (Exception $e) { return null; } }
            
              // Registrar fecha y hora de actualización
            date_default_timezone_set( 'America/Lima' );
            $fechaActual = date( 'Y-m-d H:i:s' );

            $datos = array(
                "emple_id" => $idEmpleado,
                "emple_apellido_paterno" => $_POST["editarApellidoPaterno"] ?? null,
                "emple_apellido_materno" => $_POST["editarApellidoMaterno"] ?? null,
                "emple_nombres" => $_POST["editarNombres"] ?? null,
                "emple_fecha_nacimiento" => formatearFecha($_POST["editarFechaNacimiento"] ?? null),
                "emple_nacionalidad" => $_POST["editarNacionalidad"] ?? null,
                "emple_sexo" => $_POST["editarSexo"] ?? null,
                "emple_estado_civil" => $_POST["editarEstadoCivil"] ?? null,
                "emple_telefono_movil" => limpiarTelefono($_POST["editarNumeroTelefonoMovil"] ?? null),
                "emple_telefono_fijo" => limpiarTelefono($_POST["editarNumeroTelefonoFijo"] ?? null),
                "emple_correo" => $_POST["editarCorreo"] ?? null,
                "emple_departamento" => $_POST["editarDepartamento"] ?? null,
                "emple_provincia" => $_POST["editarProvincia"] ?? null,
                "emple_distrito" => $_POST["editarDistrito"] ?? null,
                "emple_lugar_residencia" => $_POST["editarLugarResidencia"] ?? null,
                "emple_empresa_id" => $_POST["editarEmpresa"] ?? 1,
                "emple_fecha_ingreso" => formatearFecha($_POST["editarFechaIngreso"] ?? null),
                "emple_categoria_ocupacional" => $_POST["editarCategoriaOcupacional"] ?? null,
                "emple_cenco_id" => $_POST["editarCentroCosto"] ?? 1,
                "emple_area_id" => $_POST["editarArea"] ?? 1,
                "emple_cargo_id" => $_POST["editarCargo"] ?? 1,
                "emple_estado" => $_POST["editarEstado"] ?? null,
                "emple_fecha_cese" => formatearFecha($_POST["editarFechaCese"] ?? null),
                "emple_situacion_educativa" => $_POST["editarSituacionEducativa"] ?? null,
                "emple_estado_educativa" => $_POST["editarEstadoEducativa"] ?? null,
                "emple_tipo_regimen" => $_POST["editarTipoRegimen"] ?? null,
                "emple_tipo_institucion" => $_POST["editarTipoInstitucion"] ?? null,
                "emple_institucion" => $_POST["editarInstitucion"] ?? null,
                "emple_carrera" => $_POST["editarCarrera"] ?? null,
                "emple_anio" => $_POST["editarAnio"] ?? null,
                "emple_nombre_familiar" => $_POST["editarNombreFamiliar"] ?? null,
                "emple_telefono_familiar" => limpiarTelefono($_POST["editarTelefonoFamiliar"] ?? null),
                "emple_parentesco" => $_POST["editarParentesco"] ?? null,
                "emple_fecha_vencimiento_documento" => formatearFecha($_POST["editarFechaVencimientoDocumento"] ?? null),
                "emple_licencia" => $_POST["editarRadioLicencia"] ?? null,

                // Archivo de documento identidad (se actualiza solo si se sube uno nuevo)
                "emple_archivo_documento" => $archivosGuardados["emple_archivo_documento"],

                // Fechas y Archivos de Licencias (solo si hay archivo nuevo)
                "emple_fecha_vencimiento_a1" => formatearFechaHora($_POST["editarFechaVencimientoAI"] ?? null),
                "emple_archivo_a1" => $archivosGuardados["emple_archivo_a1"],
                "emple_fecha_vencimiento_a2a" => formatearFechaHora($_POST["editarFechaVencimientoAIIa"] ?? null),
                "emple_archivo_a2a" => $archivosGuardados["emple_archivo_a2a"],
                "emple_fecha_vencimiento_a2b" => formatearFechaHora($_POST["editarFechaVencimientoAIIb"] ?? null),
                "emple_archivo_a2b" => $archivosGuardados["emple_archivo_a2b"],
                "emple_fecha_vencimiento_a3a" => formatearFechaHora($_POST["editarFechaVencimientoAIIIa"] ?? null),
                "emple_archivo_a3a" => $archivosGuardados["emple_archivo_a3a"],
                "emple_fecha_vencimiento_a3b" => formatearFechaHora($_POST["editarFechaVencimientoAIIIb"] ?? null),
                "emple_archivo_a3b" => $archivosGuardados["emple_archivo_a3b"],
                "emple_fecha_vencimiento_a3c" => formatearFechaHora($_POST["editarFechaVencimientoAIIIc"] ?? null),
                "emple_archivo_a3c" => $archivosGuardados["emple_archivo_a3c"],
                "emple_fecha_vencimiento_b1" => formatearFechaHora($_POST["editarFechaVencimientoBI"] ?? null),
                "emple_archivo_b1" => $archivosGuardados["emple_archivo_b1"],
                "emple_fecha_vencimiento_b2a" => formatearFechaHora($_POST["editarFechaVencimientoBIIa"] ?? null),
                "emple_archivo_b2a" => $archivosGuardados["emple_archivo_b2a"],
                "emple_fecha_vencimiento_b2b" => formatearFechaHora($_POST["editarFechaVencimientoBIIb"] ?? null),
                "emple_archivo_b2b" => $archivosGuardados["emple_archivo_b2b"],
                "emple_fecha_vencimiento_b2c" => formatearFechaHora($_POST["editarFechaVencimientoBIIc"] ?? null),
                "emple_archivo_b2c" => $archivosGuardados["emple_archivo_b2c"],
                "emple_fecha_update" => $fechaActual,
            );

            // ============================================
            // 4. ENVIAR DATOS AL MODELO PARA ACTUALIZAR
            // ============================================
            $respuesta = ModeloEmpleados::mdlEditarEmpleado("empleados", $datos);

            if($respuesta == "ok"){
                echo json_encode([
                    'status' => 'success',
                    'title' => '¡El empleado ha sido actualizado correctamente!',
                    'message' => 'Los cambios han sido guardados.',
                    'redirect' => 'empleados'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'title' => '¡Error al actualizar en la base de datos!',
                    'message' => 'Ocurrió un problema al guardar los cambios. Revise los datos e intente de nuevo.'
                ]);
            }
        }
    }

/* ========================================================== */
/* =================== 3. ELIMINAR EMPLEADO =================== */
/* ========================================================== */

    static public function ctrEliminarEmpleado() {
        // primero manejamos petición AJAX/POST
        if(isset($_POST["idEmpleadoEliminar"])){
            $idEmpleado = (int) $_POST["idEmpleadoEliminar"];
            $tabla = "empleados";
            $respuesta = ModeloEmpleados::mdlEliminarEmpleado($tabla, $idEmpleado);
            if($respuesta == "ok"){
                echo json_encode([
                    'status' => 'success',
                    'title' => '¡El empleado fue enviado a papelera!',
                    'message' => 'El registro fue eliminado lógicamente.',
                    'redirect' => 'empleados'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'title' => '¡Error al eliminar el empleado!',
                    'message' => 'No se pudo eliminar el registro o ya estaba eliminado.'
                ]);
            }
            return;
        }

        // si la llamada viene por GET (redirección tradicional) compatible con otros módulos
        if(isset($_GET["idEmpleado"])){
            $idEmpleado = (int) $_GET["idEmpleado"];
            $tabla = "empleados";
            $respuesta = ModeloEmpleados::mdlEliminarEmpleado($tabla, $idEmpleado);
            if($respuesta == "ok"){
                echo '<script>
                    swal({
                          type: "success",
                          title: "¡El empleado fue enviado a papelera!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "empleados";
                                    }
                                })
                    </script>';
            } else {
                echo '<script>
                    swal({
                          type: "error",
                          title: "¡Error al eliminar el empleado!",
                          text: "No se pudo eliminar el registro o ya estaba eliminado.",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          });
                    </script>';
            }
            return;
        }
    }

    static public function ctrMostrarEmpleadosEliminados(){
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        $tabla = 'empleados';
        return ModeloEmpleados::mdlMostrarEmpleadosEliminados($tabla);
    }

    static public function ctrRestaurarEmpleado($id){
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden restaurar empleados.'
            );
        }

        $id = (int) $id;
        if($id <= 0){
            return array(
                'status' => 'error',
                'message' => 'ID de empleado inválido.'
            );
        }

        $respuesta = ModeloEmpleados::mdlRestaurarEmpleado('empleados', $id);
        if($respuesta === 'ok'){
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo restaurar el empleado o ya estaba activo.'
        );
    }

    static public function ctrDepurarEmpleado($id){
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden eliminar empleados definitivamente.'
            );
        }

        $id = (int) $id;
        if($id <= 0){
            return array(
                'status' => 'error',
                'message' => 'ID de empleado inválido.'
            );
        }

        $respuesta = ModeloEmpleados::mdlDepurarEmpleado('empleados', $id);
        if($respuesta === 'ok'){
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo eliminar definitivamente el empleado.'
        );
    }


/* ===================================================== */
/* =================== CALCULAR EDAD =================== */
/* ===================================================== */

    static public function ctrCalcularEdad($fechaNaci) {
        // Si no hay fecha, devolvemos null
        if ($fechaNaci == null) {
            return null;
        }
        try {
            // Creamos un objeto DateTime para la fecha de nacimiento
            $fechaNacimiento = new DateTime($fechaNaci);
            // Creamos un objeto DateTime para la fecha actual
            $fechaActual = new DateTime();            
            // Calculamos la diferencia entre las dos fechas
            $diferencia = $fechaActual->diff($fechaNacimiento);            
            // Devolvemos la diferencia en años (la 'y' es de years)
            return $diferencia->y;
        } catch (Exception $e) {
            // Si la fecha tiene un formato inválido, devolvemos null para evitar errores
            return null;
        }
    }

    static public function ctrObtenerMes($fechaMes) {
        $mes = "null";
        if ($fechaMes != "") {
            $fecha = substr($fechaMes, 5, 2);
            switch ($fecha) {
                case "01":
                    $mes = "ENERO";
                    break;
                case "02":
                    $mes = "FEBRERO";
                    break;
                case "03":
                    $mes = "MARZO";
                    break;
                case "04":
                    $mes = "ABRIL";
                    break;
                case "05":
                    $mes = "MAYO";
                    break;
                case "06":
                    $mes = "JUNIO";
                    break;
                case "07":
                    $mes = "JULIO";
                    break;
                case "08":
                    $mes = "AGOSTO";
                    break;
                case "09":
                    $mes = "SEPTIEMBRE";
                    break;
                case "10":
                    $mes = "OCTUBRE";
                    break;
                case "11":
                    $mes = "NOVIEMBRE";
                    break;
                case "12":
                    $mes = "DICIEMBRE";
                    break;
                    return $mes;
            }
        }
        return $mes;
    }

    static public function ctrObtenerCodigo()
    {
        //SELECT COUNT(numero_historia) FROM historia_clinica;
        $tabla = "empleados";
        $respuesta = ModeloEmpleados::mdlCodigoEmpleados($tabla);
        $codigo = "";
        if ($respuesta >= 0 && $respuesta < 10) {
            $aumento = $respuesta + 1;
            $codigo = "EMP000" .  $aumento;
        }
        if ($respuesta >= 9 && $respuesta < 100) {
            $aumento = $respuesta + 1;
            $codigo = "EMP00" .  $aumento;
        }
        if ($respuesta >= 99 && $respuesta < 1000) {
            $aumento = $respuesta + 1;
            $codigo = "EMP0" .  $aumento;
        }
        if ($respuesta >= 999) {
            $aumento = $respuesta + 1;
            $codigo = "EMP" .  $aumento;
        }
        return $codigo;
    }


}
//Fin Class