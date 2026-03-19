/*=============================================
CONSULTAR RUC EN API APISPERU
=============================================*/
$("#inputRuc").on("blur", function(){
    var ruc = $(this).val().trim();
    
    if(ruc.length === 11 && /^[0-9]+$/.test(ruc)){
        consultarRuc(ruc, 'agregar');
    }
});

$("#inputRuc").on("keyup", function(){
    var ruc = $(this).val().trim();
    // Solo permitir números
    this.value = ruc.replace(/[^0-9]/g, '');
});

$("#inputEditRuc").on("blur", function(){
    var ruc = $(this).val().trim();
    
    if(ruc.length === 11 && /^[0-9]+$/.test(ruc)){
        consultarRuc(ruc, 'editar');
    }
});

$("#inputEditRuc").on("keyup", function(){
    var ruc = $(this).val().trim();
    // Solo permitir números
    this.value = ruc.replace(/[^0-9]/g, '');
});

function consultarRuc(ruc, tipo){
    var datos = new FormData();
    datos.append("ruc", ruc);
    
    // Mostrar indicador de carga
    if(tipo === 'agregar'){
        $("#loadingRuc").show();
    }
    
    $.ajax({
        url: "ajax/consultar_ruc.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            // Ocultar indicador de carga
            if(tipo === 'agregar'){
                $("#loadingRuc").hide();
            }
            
            if(respuesta.success){
                // Llenar campos según el tipo de formulario
                if(tipo === 'agregar'){
                    $("#inputRazonSocial").val(respuesta.razonSocial);
                    $("#inputNombreComercial").val(respuesta.nombreComercial);
                    
                    // Construir dirección completa
                    var domicilio = respuesta.domicilio || '';
                    if(respuesta.direccion){
                        domicilio = respuesta.direccion;
                    }
                    $("#inputDomicilioLegal").val(domicilio);
                    
                    // Usar primer teléfono si existe
                    if(respuesta.telefonos && respuesta.telefonos.length > 0){
                        $("#inputNumeroContacto").val(respuesta.telefonos[0]);
                    }
                    
                    swal({
                        title: '✓ Éxito',
                        text: 'Los datos del RUC se han cargado automáticamente. Puede editarlos si lo necesita.',
                        type: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                } else if(tipo === 'editar'){
                    $("#inputEditRazonSocial").val(respuesta.razonSocial);
                    $("#inputEditNombreComercial").val(respuesta.nombreComercial);
                    
                    var domicilio = respuesta.domicilio || '';
                    if(respuesta.direccion){
                        domicilio = respuesta.direccion;
                    }
                    $("#inputEditDomicilioLegal").val(domicilio);
                    
                    if(respuesta.telefonos && respuesta.telefonos.length > 0){
                        $("#inputEditNumeroContacto").val(respuesta.telefonos[0]);
                    }
                    
                    swal({
                        title: '✓ Éxito',
                        text: 'Los datos del RUC se han cargado automáticamente. Puede editarlos si lo necesita.',
                        type: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                }
            } else {
                swal({
                    title: 'ⓘ Información',
                    text: 'No se encontró información para este RUC en el sistema.\n\nLlene los campos manualmente:',
                    type: 'info',
                    confirmButtonText: 'De acuerdo'
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Ocultar indicador de carga
            if(tipo === 'agregar'){
                $("#loadingRuc").hide();
            }
            
            swal({
                title: '⚠ Información',
                text: 'No se pudo consultar el RUC.\n\nLlene los campos manualmente:',
                type: 'warning',
                confirmButtonText: 'De acuerdo'
            });
            console.log("Error en la llamada AJAX:", textStatus, errorThrown);
        }
    });
}

/*=============================================
EDITAR Categoria
=============================================*/
$(".tablas").on("click", ".btnEditarEmpresa", function(){
	var idEmpresa = $(this).attr("idEmpresa");   

	var datos = new FormData();
	datos.append("idEmpresa", idEmpresa);

   // console.log(idCategoria);
    $.ajax({
        url: "ajax/empresas.ajax.php",
        method: "POST",
        data: datos, 
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            //console.log('Respuesta del servidor:', respuesta);
            $("#inputEditRuc").val(respuesta["empre_ruc"]);
            $("#inputEditRazonSocial").val(respuesta["empre_razon_social"]);
            $("#inputEditNombreComercial").val(respuesta["empre_nombre_comercial"]);
            $("#inputEditDomicilioLegal").val(respuesta["empre_domicilio_legal"]);
            $("#inputEditNumeroContacto").val(respuesta["empre_numero_contacto"]);
            $("#inputEditEmail").val(respuesta["empre_email_contacto"]);
            $("#inputEditId").val(respuesta["empre_id"]);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error en la llamada AJAX:", textStatus, errorThrown);
        }
    });   
});


/*=============================================
ELIMINAR Categoria
=============================================*/
$(".tablas").on("click", ".btnEliminarEmpresa", function(){

    var idEmpresa = $(this).attr("idEmpresa");

    swal({
        title: '¿Está seguro de eliminar la empresa?',
        text: "La empresa no se borrará físicamente. Primero será enviada a la papelera.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, enviar a papelera'
    }).then(function(result){

        if(result.value){

            window.location = "index.php?ruta=empresas&idEmpresa="+idEmpresa;
            //window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;

        }

    })

});

/*=============================================
RESTAURAR EMPRESA DESDE PAPELERA
=============================================*/
$(document).on("click", ".btnRestaurarEmpresa", function(){

    var idEmpresa = $(this).attr("idEmpresa");
    var nombreEmpresa = $(this).attr("nombreEmpresa");

    swal({
        title: '¿Restaurar empresa?',
        text: 'La empresa "' + nombreEmpresa + '" volverá a estar disponible en el sistema.',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, restaurar'
    }).then(function(result){

        if(result.value){

            var datos = new FormData();
            datos.append("restaurarEmpresaId", idEmpresa);

            $.ajax({
                url: "ajax/empresas.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                    if(respuesta && respuesta.status === "ok"){
                        swal({
                            title: "Restaurada",
                            text: "La empresa fue restaurada correctamente.",
                            type: "success",
                            confirmButtonText: "Cerrar"
                        }).then(function(r){
                            if(r.value){ window.location = "empresas"; }
                        });
                    }else{
                        swal({
                            title: "Error",
                            text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo restaurar la empresa",
                            type: "error",
                            confirmButtonText: "Cerrar"
                        });
                    }
                },
                error: function(){
                    swal({
                        title: "Error",
                        text: "No se pudo conectar para restaurar la empresa.",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                }
            });
        }
    });
});

/*=============================================
DEPURAR EMPRESA - ELIMINACION FISICA
=============================================*/
$(document).on("click", ".btnDepurarEmpresa", function(){

    var idEmpresa = $(this).attr("idEmpresa");
    var nombreEmpresa = $(this).attr("nombreEmpresa");

    swal({
        title: 'ELIMINACIÓN DEFINITIVA',
        html: '<strong>' + nombreEmpresa + '</strong> será eliminada <strong>permanentemente</strong> de la base de datos.<br><br>Esta acción no se puede deshacer.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, eliminar para siempre'
    }).then(function(result){

        if(result.value){

            var datos = new FormData();
            datos.append("depurarEmpresaId", idEmpresa);

            $.ajax({
                url: "ajax/empresas.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                    if(respuesta && respuesta.status === "ok"){
                        swal({
                            title: "Eliminada",
                            text: "La empresa fue eliminada definitivamente.",
                            type: "success",
                            confirmButtonText: "Cerrar"
                        }).then(function(r){
                            if(r.value){ window.location = "empresas"; }
                        });
                    }else{
                        swal({
                            title: "Error",
                            text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo eliminar la empresa",
                            type: "error",
                            confirmButtonText: "Cerrar"
                        });
                    }
                },
                error: function(){
                    swal({
                        title: "Error",
                        text: "No se pudo conectar para eliminar la empresa.",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                }
            });
        }
    });
});
