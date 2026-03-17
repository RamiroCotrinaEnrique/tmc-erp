
$(document).ready(function() {
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    
    // Inicializar datepickers globales (incluye el modal) - sólo una vez por elemento
    $('.date').each(function(){
        var $el = $(this);
        if (!$el.data('dtp-initialized')) {
            $el.datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'es'
            });
            $el.data('dtp-initialized', true);
        }
    });

    // Re-iniciar dentro del modal cuando se muestra por primera vez
    $('#modalEditarEmpleado').on('shown.bs.modal', function(){
        $(this).find('.date').each(function(){
            var $el = $(this);
            if (!$el.data('dtp-initialized')) {
                $el.datetimepicker({
                    format: 'DD/MM/YYYY',
                    locale: 'es'
                });
                $el.data('dtp-initialized', true);
            }
        });
    });
});

// Convierte fechas devueltas por el servidor (YYYY-MM-DD o YYYY-MM-DD HH:MM:SS)
function formatServerDateToDisplay(dateStr) {
    if (!dateStr) return '';
    // manejar valores tipo 0000-00-00
    if (dateStr.indexOf('0000-00-00') !== -1) return '';
    // extraer la parte de fecha si viene con hora
    var dateOnly = dateStr.split(' ')[0];
    // formatos esperados: YYYY-MM-DD
    var m = dateOnly.match(/^(\d{4})-(\d{2})-(\d{2})$/);
    if (m) {
        return m[3] + '/' + m[2] + '/' + m[1];
    }
    // si ya viene en formato DD/MM/YYYY devolver tal cual
    if (dateStr.match(/^[0-3]?\d\/[0-1]?\d\/\d{4}$/)) return dateStr;
    return '';
}

$(document).ready(function () {
  // Oculta las tablas al cargar si están en "No"
  $('#tablaLicencia').hide();
  $('#tablaLicenciaEditar').hide();

  // Escucha cambios en los radios del formulario de CREAR
  $('input[name="radioLicencia"]').change(function () {
      if ($('#licenciaSi').is(':checked')) {
          $('#tablaLicencia').show();
      } else {
          $('#tablaLicencia').hide();
      }
  });
  
  // Escucha cambios en los radios del formulario de EDITAR
  $('input[name="editarRadioLicencia"]').change(function () {
      if ($('#editarLicenciaSi').is(':checked')) {
          $('#tablaLicenciaEditar').show();
      } else {
          $('#tablaLicenciaEditar').hide();
      }
  });
});

// =============================================================================
// =========== SCRIPT PARA ACTIVAR O DESACTIVAR FECHA DE CESE ==================
// =============================================================================

document.addEventListener('DOMContentLoaded', function() {
    let estadoSelect = document.getElementById('inputEstado');
    let fechaCeseInput = document.getElementById('inputFechaCese');

    // Solo ejecutar si los elementos existen en esta página
    if (!estadoSelect || !fechaCeseInput) return;

    // Al iniciar, deshabilitamos si no está en "Cesado"
    if (estadoSelect.value !== 'Cesado') {
        fechaCeseInput.disabled = true;
        fechaCeseInput.value = ''; // opcional: limpiar valor
    }

    estadoSelect.addEventListener('change', function() {
        if (this.value === 'Cesado') {
            fechaCeseInput.disabled = false;
        } else {
            fechaCeseInput.disabled = true;
            fechaCeseInput.value = ''; // opcional: limpiar valor
        }
    });
}); 


// =====================================================================
// =========== SCRIPT LÓGICA AJAX PARA MOSTAR REPORTE ==================
// =====================================================================
$(document).ready(function() {

    // --- FUNCIÓN AUXILIAR PARA CALCULAR DÍAS RESTANTES ---
        function calcularDiasRestantes(fechaVencimiento) {
        if (!fechaVencimiento) {
            return ''; // No hay fecha, no se muestra nada
        }
        
        const hoy = new Date();
        const fechaVence = new Date(fechaVencimiento.split(' ')[0]); // Ignorar la hora
        hoy.setHours(0, 0, 0, 0); // Normalizar la fecha de hoy

        const diffTime = fechaVence - hoy;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        let claseBadge = 'badge-success';
        let textoBadge = `Vigente (${diffDays} días)`;

        if (diffDays < 0) {
            claseBadge = 'badge-danger';
            textoBadge = 'Vencido';
        } else if (diffDays <= 30) {
            claseBadge = 'badge-danger';
            textoBadge = `Vence en ${diffDays} días`;
        } else if (diffDays <= 90) {
            claseBadge = 'badge-warning';
            textoBadge = `Vence en ${diffDays} días`;
        }
        
        return `<span class="badge ${claseBadge} ml-2">${textoBadge}</span>`;
    }

    // --- EVENTO CLICK PARA GENERAR REPORTE ---
    // Se usa delegación para manejar dinámicamente los botones generados

    $('.tablas').on('click', '.btnGenerarReporte', function() {
        var idEmpleado = $(this).attr('idEmpleado');

        $('#reporteLoader').show();
        $('#reporteContenido').hide();

        var data = new FormData();
        data.append('idEmpleadoReporte', idEmpleado);

        $.ajax({
            url: 'ajax/empleados.ajax.php',
            method: 'POST',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(respuesta) {
                $('#reporteLoader').hide();
                $('#reporteContenido').show();
                
                // --- Llenar los campos del modal con la respuesta del AJAX ---
                
                // Datos Personales
                $("#reporteCodigo").text(respuesta.emple_codigo || "N/A");
                $("#reporteDocumento").text((respuesta.emple_tipo_documento || "") + ": " + (respuesta.emple_numero_documento || "N/A"));
                $("#reporteNombres").text(respuesta.emple_nombres || "N/A");
                $("#reporteApellidos").text((respuesta.emple_apellido_paterno || "") + " " + (respuesta.emple_apellido_materno || ""));
                $("#reporteFechaNacimiento").text(respuesta.emple_fecha_nacimiento || "N/A");
                $("#reporteNacionalidad").text(respuesta.emple_nacionalidad || "N/A");
                $("#reporteTelefonoMovil").text(respuesta.emple_telefono_movil || "N/A");
                $("#reporteCorreo").text(respuesta.emple_correo || "N/A");

                // Datos Laborales
                $("#reporteRuc").text(respuesta.empre_ruc || "N/A"); 
                $("#reporteEmpresa").text(respuesta.empre_razon_social || "N/A"); 
                $("#reporteFechaIngreso").text(respuesta.emple_fecha_ingreso || "N/A");
                $("#reporteCategoria").text(respuesta.emple_categoria_ocupacional || "N/A");
                $("#reporteCentroCosto").text((respuesta.cenco_codigo || "N/A") + " - " + (respuesta.cenco_nombre || "N/A"));
                $("#reporteArea").text(respuesta.are_nombre || "N/A");
                $("#reporteCargo").text(respuesta.car_nombre || "N/A");

                // Datos Educativos
                $("#reporteSituacionEducativa").text(respuesta.emple_situacion_educativa || "N/A");
                $("#reporteInstitucion").text(respuesta.emple_institucion || "N/A");
                $("#reporteCarrera").text(respuesta.emple_carrera || "N/A");
                $("#reporteAnioEgreso").text(respuesta.emple_anio || "N/A");

                // Contacto de Emergencia
                $("#reporteNombreFamiliar").text(respuesta.emple_nombre_familiar || "N/A");
                $("#reporteParentesco").text(respuesta.emple_parentesco || "N/A");
                $("#reporteTelefonoFamiliar").text(respuesta.emple_telefono_familiar || "N/A");

                // Documentación General
                //$("#reporteVencimientoDocumento").text(respuesta.emple_fecha_vencimiento_documento || "N/A");

                // Documentación General con indicador de vencimiento
                const fechaVencDoc = respuesta.emple_fecha_vencimiento_documento || "N/A";
                // Se llama a la nueva función
                const badgeDoc = calcularDiasRestantes(respuesta.emple_fecha_vencimiento_documento);
                // Se unen la fecha y la insignia usando .html() en lugar de .text()
                $("#reporteVencimientoDocumento").html(fechaVencDoc + badgeDoc);
                
                // Archivo del Documento de Identidad
                const archivoDocSpan = $("#reporteArchivoDocumento");
                if (respuesta.emple_archivo_documento) {
                    // incluir carpeta del código del empleado para apuntar al archivo real
                    const codigo = respuesta.emple_codigo || "";
                    const url = `vistas/archivos/empleados/${codigo}/${respuesta.emple_archivo_documento}`;
                    archivoDocSpan.html(`<a href="${url}" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf mr-1"></i> Ver PDF</a>`);
                } else {
                    archivoDocSpan.text("No adjunto");
                }
                
                // --- LÓGICA DINÁMICA PARA LICENCIAS DE CONDUCIR ---
                const licenciasWrapper = $("#reporteLicenciasWrapper");
                licenciasWrapper.empty(); // Limpiar contenido anterior

                if (respuesta.emple_licencia === 'SI') {
                     const licencias = [
                        { key: 'emple_fecha_vencimiento_a1',  label: 'A-I',   archivoKey: 'emple_archivo_a1' },
                        { key: 'emple_fecha_vencimiento_a2a', label: 'A-IIa', archivoKey: 'emple_archivo_a2a' },
                        { key: 'emple_fecha_vencimiento_a2b', label: 'A-IIb', archivoKey: 'emple_archivo_a2b' },
                        { key: 'emple_fecha_vencimiento_a3a', label: 'A-IIIa',archivoKey: 'emple_archivo_a3a' },
                        { key: 'emple_fecha_vencimiento_a3b', label: 'A-IIIb',archivoKey: 'emple_archivo_a3b' },
                        { key: 'emple_fecha_vencimiento_a3c', label: 'A-IIIc',archivoKey: 'emple_archivo_a3c' },
                        { key: 'emple_fecha_vencimiento_b1',  label: 'B-I',   archivoKey: 'emple_archivo_b1' },
                        { key: 'emple_fecha_vencimiento_b2a', label: 'B-IIa', archivoKey: 'emple_archivo_b2a' },
                        { key: 'emple_fecha_vencimiento_b2b', label: 'B-IIb', archivoKey: 'emple_archivo_b2b' },
                        { key: 'emple_fecha_vencimiento_b2c', label: 'B-IIc', archivoKey: 'emple_archivo_b2c' },
                    ];

                    let licenciasHtml = '';
                    let tieneLicenciasRegistradas = false;

                    licencias.forEach(lic => {
                        if (respuesta[lic.key]) { 
                            tieneLicenciasRegistradas = true;
                            let archivoBtn = '';
                            if (respuesta[lic.archivoKey]) {
                                // IMPORTANTE: Ajusta esta ruta a la ubicación de tus archivos
                                const codigo = respuesta.emple_codigo || "";
                                const url = `vistas/archivos/empleados/${codigo}/${respuesta[lic.archivoKey]}`;
                                archivoBtn = ` <a href="${url}" target="_blank" class="btn btn-danger btn-sm ml-2" title="Ver PDF"><i class="fas fa-file-pdf"></i></a>`;
                            }

                            // Se llama a la nueva función para la fecha de la licencia actual
                            const badgeLic = calcularDiasRestantes(respuesta[lic.key]);
                            // Se añade la insignia (badgeLic) al HTML junto a la fecha y el botón
                            licenciasHtml += `<div class="reporte-item"><strong>Licencia ${lic.label}:</strong> <span>${respuesta[lic.key].split(' ')[0]} ${badgeLic} ${archivoBtn || ''}</span></div>`;
                                                        
                                                        

                            // Se envuelve el span en un div para controlar el layout con flexbox
                            //licenciasHtml += `<div class="reporte-item"><strong>Licencia ${lic.label}:</strong> <span>${respuesta[lic.key]}${archivoBtn}</span></div>`;
                        }
                    });

                    if (tieneLicenciasRegistradas) {
                        licenciasWrapper.html(licenciasHtml);
                    } else {
                        licenciasWrapper.html('<p class="text-muted mt-2">Tiene licencia pero no hay fechas registradas.</p>');
                    }

                } else {
                    licenciasWrapper.html('<p class="text-muted mt-2">No tiene licencia de conducir.</p>');
                }

            },
            error: function() {
                $('#reporteLoader').hide();
                $('#reporteContenido').html("<div class='alert alert-danger'>No se pudieron cargar los datos del empleado.</div>").show();
            }
        });
    });
});


//<!-- =================================================================== -->
//<!-- ============= 2. SCRIPT DE VALIDACIÓN CARGA PDF =================== -->
//<!-- =================================================================== -->

(function() {

    var MB2 = 2000000;

    function validarSoloPDF(input) {
        var archivo = input.files[0];
        var $input = $(input);

        if (!archivo) return;

        // Validar tipo MIME
        if (archivo.type !== "application/pdf") {
            $input.val("");
            $input.next(".custom-file-label").text("Seleccionar");
            swal({
                title: "Error al subir el archivo",
                text: "¡El archivo debe estar en formato PDF!",
                type: "error",
                confirmButtonText: "¡Cerrar!"
            });
            return;
        }

        // Validar tamaño
        if (archivo.size > MB2) {
            $input.val("");
            $input.next(".custom-file-label").text("Seleccionar");
            swal({
                title: "Error al subir el archivo",
                text: "¡El archivo no debe pesar más de 2 MB!",
                type: "error",
                confirmButtonText: "¡Cerrar!"
            });
            return;
        }

        // Mostrar nombre del archivo
        $input.next(".custom-file-label").text(archivo.name);
    }

    /* =======================
       Lista de campos a validar
       ======================= */
    var camposPDF = [
        "#inputAdjuntarDocumentoIdentidad",
        "#inputAdjuntarLicenciaAI",
        "#inputAdjuntarLicenciaAIIa",
        "#inputAdjuntarLicenciaAIIb",
        "#inputAdjuntarLicenciaAIIIa",
        "#inputAdjuntarLicenciaAIIIb",
        "#inputAdjuntarLicenciaAIIIc",
        "#inputAdjuntarLicenciaBI",
        "#inputAdjuntarLicenciaBIIa",
        "#inputAdjuntarLicenciaBIIb",
        "#inputAdjuntarLicenciaBIIc"
    ];

    /* Enlazar eventos campo por campo */
    camposPDF.forEach(function(selector) {
        $(document).on("change", selector, function() {
            validarSoloPDF(this);
        });
    });

})();

// =====================================================================
    // --- PARTE B: VALIDACIÓN INMEDIATA DE CAMPOS DE TEXTO Y SELECT ---
    const camposRequeridos = '#inputTipoDocumento, #inputNumeroDocumento, #inputApellidoPaterno, #inputApellidoMaterno, #inputNombres, #inputEmpresa, #inputCentroCosto, #inputArea, #inputCargo';

    // Función para validar un campo individualmente
    function validarCampo(campo) {
        if ($(campo).val() === null || $(campo).val().trim() === '') {
            $(campo).addClass('is-invalid');
            return false;
        } else {
            $(campo).removeClass('is-invalid');
            return true;
        }
    }

    // Evento para cuando el usuario sale de un campo de texto (blur)
    $('#formAgregarEmpleado').on('blur', 'input[required]', function() {
        validarCampo(this);
    });

    // Evento para cuando el usuario cambia la selección de un dropdown (change)
    $('#formAgregarEmpleado').on('change', 'select[required]', function() {
        validarCampo(this);
    });

/*=============================================
EDITAR Empleado
=============================================*/
$(".tablas").on("click", ".btnEditarEmpleado", function(){
	var idEmpleado = $(this).attr("idEmpleado");   

	var datos = new FormData();
	datos.append("idEmpleado", idEmpleado);

   // console.log(idEmpleado);
    $.ajax({
        url: "ajax/empleados.ajax.php",
        method: "POST",
        data: datos, 
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            
            // Guardar el ID del empleado en el campo oculto
            $("#idEmpleado").val(respuesta["emple_id"]);
            
            // DATOS PERSONALES
            $("#editarCodigo").val(respuesta["emple_codigo"]);
            $("#editarTipoDocumento").val(respuesta["emple_tipo_documento"]);
            $("#editarNumeroDocumento").val(respuesta["emple_numero_documento"]);
            $("#editarApellidoPaterno").val(respuesta["emple_apellido_paterno"]);
            $("#editarApellidoMaterno").val(respuesta["emple_apellido_materno"]);
            $("#editarNombres").val(respuesta["emple_nombres"]);
            $("#editarFechaNacimiento").val(formatServerDateToDisplay(respuesta["emple_fecha_nacimiento"]));
            $("#editarNacionalidad").val(respuesta["emple_nacionalidad"]);
            $("#editarSexo").val(respuesta["emple_sexo"]);
            $("#editarEstadoCivil").val(respuesta["emple_estado_civil"]);
            $("#editarNumeroTelefonoMovil").val(respuesta["emple_telefono_movil"]);
            $("#editarNumeroTelefonoFijo").val(respuesta["emple_telefono_fijo"]);
            $("#editarCorreo").val(respuesta["emple_correo"]);
            $("#editarDepartamento").val(respuesta["emple_departamento"]);
            $("#editarProvincia").val(respuesta["emple_provincia"]);
            $("#editarDistrito").val(respuesta["emple_distrito"]);
            $("#editarLugarResidencia").val(respuesta["emple_lugar_residencia"]);
            
            // DATOS LABORALES
            // Use the employee's foreign-key fields returned in e.* (emple_empresa_id, emple_cenco_id, emple_area_id, emple_cargo_id)
            // Si los selects usan Select2 es necesario disparar el cambio para que la UI muestre el valor seleccionado
            $("#editarEmpresa").val(respuesta["emple_empresa_id"]).trigger('change');
            $("#editarFechaIngreso").val(formatServerDateToDisplay(respuesta["emple_fecha_ingreso"]));
            $("#editarCategoriaOcupacional").val(respuesta["emple_categoria_ocupacional"]).trigger('change');
            $("#editarCentroCosto").val(respuesta["emple_cenco_id"]).trigger('change');
            $("#editarArea").val(respuesta["emple_area_id"]).trigger('change');
            $("#editarCargo").val(respuesta["emple_cargo_id"]).trigger('change');
            $("#editarEstado").val(respuesta["emple_estado"]);
            $("#editarFechaCese").val(formatServerDateToDisplay(respuesta["emple_fecha_cese"]));
            
            // DATOS EDUCATIVOS
            $("#editarSituacionEducativa").val(respuesta["emple_situacion_educativa"]);
            $("#editarEstadoEducativa").val(respuesta["emple_estado_educativa"]);
            $("#editarTipoRegimen").val(respuesta["emple_tipo_regimen"]);
            $("#editarTipoInstitucion").val(respuesta["emple_institucion_tipo"]);
            $("#editarInstitucion").val(respuesta["emple_institucion"]);
            $("#editarCarrera").val(respuesta["emple_carrera"]);
            $("#editarAnio").val(respuesta["emple_anio"]);
            
            // DATOS CONTACTO
            $("#editarNombreFamiliar").val(respuesta["emple_nombre_familiar"]);
            $("#editarTelefonoFamiliar").val(respuesta["emple_telefono_familiar"]);
            $("#editarParentesco").val(respuesta["emple_parentesco"]);
            
            // DOCUMENTACIÓN
            $("#editarFechaVencimientoDocumento").val(formatServerDateToDisplay(respuesta["emple_fecha_vencimiento_documento"]));
            
            // Archivo del Documento de Identidad
            const archivoDocDiv = $("#editarArchivoDocumentoActual");
            archivoDocDiv.empty();
            if (respuesta["emple_archivo_documento"]) {
                const codigo = respuesta.emple_codigo || "";
                const url = `vistas/archivos/empleados/${codigo}/${respuesta["emple_archivo_documento"]}`;
                archivoDocDiv.append(`<a href="${url}" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i></a>`);
            } else {
                archivoDocDiv.append(`<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-file-pdf"></i></button>`);
            }
            
            // Licencias de conducir
            if(respuesta["emple_licencia"] === "SI") {
                $("#editarLicenciaSi").prop("checked", true);
                $("#editarLicenciaNo").prop("checked", false);
                $("#tablaLicenciaEditar").show();
            } else {
                $("#editarLicenciaSi").prop("checked", false);
                $("#editarLicenciaNo").prop("checked", true);
                $("#tablaLicenciaEditar").hide();
            }
            
            // Fechas de licencias A
            $("#editarFechaVencimientoAI").val(formatServerDateToDisplay(respuesta["emple_fecha_vencimiento_a1"]));
            $("#editarFechaVencimientoAIIa").val(formatServerDateToDisplay(respuesta["emple_fecha_vencimiento_a2a"]));
            $("#editarFechaVencimientoAIIb").val(formatServerDateToDisplay(respuesta["emple_fecha_vencimiento_a2b"]));
            $("#editarFechaVencimientoAIIIa").val(formatServerDateToDisplay(respuesta["emple_fecha_vencimiento_a3a"]));
            $("#editarFechaVencimientoAIIIb").val(formatServerDateToDisplay(respuesta["emple_fecha_vencimiento_a3b"]));
            $("#editarFechaVencimientoAIIIc").val(formatServerDateToDisplay(respuesta["emple_fecha_vencimiento_a3c"]));
            
            // Fechas de licencias B
            $("#editarFechaVencimientoBI").val(formatServerDateToDisplay(respuesta["emple_fecha_vencimiento_b1"]));
            $("#editarFechaVencimientoBIIa").val(formatServerDateToDisplay(respuesta["emple_fecha_vencimiento_b2a"]));
            $("#editarFechaVencimientoBIIb").val(formatServerDateToDisplay(respuesta["emple_fecha_vencimiento_b2b"]));
            $("#editarFechaVencimientoBIIc").val(formatServerDateToDisplay(respuesta["emple_fecha_vencimiento_b2c"]));
            
            // Función para mostrar archivo de licencia
            function mostrarArchivoLicencia(nombreCampo, nombreArchivo) {
                const contenedor = $(`.archivo-licencia[data-campo="${nombreCampo}"]`);
                contenedor.empty();
                if (nombreArchivo) {
                    const codigo = respuesta.emple_codigo || "";
                    const url = `vistas/archivos/empleados/${codigo}/${nombreArchivo}`;
                    contenedor.append(`<a href="${url}" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i></a>`);
                } else {
                    contenedor.append(`<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-file-pdf"></i></button>`);
                }
            }
            
            // Mostrar archivos de licencias A
            mostrarArchivoLicencia("editarAdjuntarLicenciaAI", respuesta["emple_archivo_a1"]);
            mostrarArchivoLicencia("editarAdjuntarLicenciaAIIa", respuesta["emple_archivo_a2a"]);
            mostrarArchivoLicencia("editarAdjuntarLicenciaAIIb", respuesta["emple_archivo_a2b"]);
            mostrarArchivoLicencia("editarAdjuntarLicenciaAIIIa", respuesta["emple_archivo_a3a"]);
            mostrarArchivoLicencia("editarAdjuntarLicenciaAIIIb", respuesta["emple_archivo_a3b"]);
            mostrarArchivoLicencia("editarAdjuntarLicenciaAIIIc", respuesta["emple_archivo_a3c"]);
            
            // Mostrar archivos de licencias B
            mostrarArchivoLicencia("editarAdjuntarLicenciaBI", respuesta["emple_archivo_b1"]);
            mostrarArchivoLicencia("editarAdjuntarLicenciaBIIa", respuesta["emple_archivo_b2a"]);
            mostrarArchivoLicencia("editarAdjuntarLicenciaBIIb", respuesta["emple_archivo_b2b"]);
            mostrarArchivoLicencia("editarAdjuntarLicenciaBIIc", respuesta["emple_archivo_b2c"]);
            
            // Mostrar modal (datepickers ya inicializados en document.ready)
            $("#modalEditarEmpleado").modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la llamada AJAX:", textStatus);
        }
    });   
});

// =============================================================================
// =========== MANEJAR ENVÍO DEL FORMULARIO DE EDICIÓN =======================
// =============================================================================
$(document).on("submit", "#formEditarEmpleado", function(e){
    e.preventDefault();

    // Crear FormData con todos los datos del formulario (incluyendo archivos)
    var formData = new FormData(this);
    
    // Asegurarse de que idEmpleado está incluido (se obtiene del campo oculto)
    var idEmpleado = $("#idEmpleado").val();
    
    if (!idEmpleado) {
        swal({
            type: "error",
            title: "Error",
            text: "ID del empleado no encontrado. Intente de nuevo.",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        });
        return;
    }
    formData.append("idEmpleado", idEmpleado);
    
    // Enviar mediante AJAX al controlador
    $.ajax({
        url: "ajax/empleados.ajax.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            // Procesar la respuesta JSON del controlador
            if(respuesta.status === 'success') {
                swal({
                    type: "success",
                    title: respuesta.title,
                    text: respuesta.message,
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if (result.value) {
                        window.location = respuesta.redirect;
                    }
                });
            } else if(respuesta.status === 'error') {
                // Verificar si es un array de errores
                if(respuesta.errors && Array.isArray(respuesta.errors)) {
                    var mensajeHTML = '<ul style="text-align:left;">';
                    respuesta.errors.forEach(function(error) {
                        mensajeHTML += '<li>' + error + '</li>';
                    });
                    mensajeHTML += '</ul>';
                    swal({
                        type: "error",
                        title: respuesta.title,
                        html: mensajeHTML,
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    });
                } else {
                    swal({
                        type: "error",
                        title: respuesta.title,
                        text: respuesta.message,
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    });
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error", textStatus, errorThrown, jqXHR.responseText);
            swal({
                type: "error",
                title: "Error en la solicitud",
                text: "Ocurrió un problema al intentar guardar los cambios.",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            });
        }
    });
});

/*=============================================
ELIMINAR EMPLEADO
=============================================*/
$(".tablas").on("click", ".btnEliminarEmpleado", function(){

    var idEmpleado = $(this).attr("idEmpleado");

    swal({
        title: '¿Está seguro de borrar los datos?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar!'
    }).then(function(result){

        if(result.value){
        // enviar petición AJAX para eliminar y mostrar el resultado
        $.ajax({
            url: "ajax/empleados.ajax.php",
            method: "POST",
            data: { idEmpleadoEliminar: idEmpleado },
            dataType: "json",
            success: function(respuesta) {
                if(respuesta.status === 'success') {
                    swal({
                        type: 'success',
                        title: respuesta.title,
                        text: respuesta.message,
                        showConfirmButton: true,
                        confirmButtonText: 'Cerrar'
                    }).then(function(){
                        window.location = 'empleados';
                    });
                } else {
                    swal({
                        type: 'error',
                        title: respuesta.title,
                        text: respuesta.message,
                        showConfirmButton: true,
                        confirmButtonText: 'Cerrar'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error AJAX eliminar empleado', textStatus, errorThrown);
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'No se pudo procesar la eliminación. Intente de nuevo.',
                    showConfirmButton: true,
                    confirmButtonText: 'Cerrar'
                });
            }
        });
        }
    });
});
