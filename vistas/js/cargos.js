
/*=============================================
EDITAR Categoria
=============================================*/
$(".tablas").on("click", ".btnEditarCargo", function(){
	var idCargo = $(this).attr("idCargo");   

	var datos = new FormData();
	datos.append("idCargo", idCargo);

   // console.log(idCategoria);
    $.ajax({
        url: "ajax/cargos.ajax.php",
        method: "POST",
        data: datos, 
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            //console.log('Respuesta del servidor:', respuesta);
            $("#inputEditNombre").val(respuesta["car_nombre"]);
            $("#inputEditId").val(respuesta["car_id"]);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error en la llamada AJAX:", textStatus, errorThrown);
        }
    });   
});


/*=============================================
ELIMINAR Categoria
=============================================*/
$(".tablas").on("click", ".btnEliminarCargo", function(){

    var idCargo = $(this).attr("idCargo");

    swal({
        title: '¿Está seguro de eliminar el cargo?',
        text: "El registro no se borrará físicamente. Primero será enviado a la papelera.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, enviar a papelera'
    }).then(function(result){

        if(result.value){

            window.location = "index.php?ruta=cargos&idCargo="+idCargo;
            //window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;

        }

    })

});

/*=============================================
RESTAURAR CARGO DESDE PAPELERA
=============================================*/
$(document).on("click", ".btnRestaurarCargo", function(){

    var idCargo = $(this).attr("idCargo");
    var nombreCargo = $(this).attr("nombreCargo");

    swal({
        title: '¿Restaurar cargo?',
        text: 'El cargo "' + nombreCargo + '" volverá al listado principal.',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, restaurar'
    }).then(function(result){

        if(result.value){

            var datos = new FormData();
            datos.append("restaurarCargoId", idCargo);

            $.ajax({
                url: "ajax/cargos.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                    if(respuesta && respuesta.status === "ok"){
                        swal({
                            title: "Restaurado",
                            text: "El cargo fue restaurado correctamente.",
                            type: "success",
                            confirmButtonText: "Cerrar"
                        }).then(function(r){
                            if(r.value){ window.location = "cargos"; }
                        });
                    }else{
                        swal({
                            title: "Error",
                            text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo restaurar el cargo",
                            type: "error",
                            confirmButtonText: "Cerrar"
                        });
                    }
                },
                error: function(){
                    swal({
                        title: "Error",
                        text: "No se pudo conectar para restaurar el cargo.",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                }
            });
        }
    });
});

/*=============================================
DEPURAR CARGO - ELIMINACION FISICA
=============================================*/
$(document).on("click", ".btnDepurarCargo", function(){

    var idCargo = $(this).attr("idCargo");
    var nombreCargo = $(this).attr("nombreCargo");

    swal({
        title: 'ELIMINACIÓN DEFINITIVA',
        html: '<strong>' + nombreCargo + '</strong> será eliminado permanentemente de la base de datos.<br><br>Esta acción no se puede deshacer.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, eliminar para siempre'
    }).then(function(result){

        if(result.value){

            var datos = new FormData();
            datos.append("depurarCargoId", idCargo);

            $.ajax({
                url: "ajax/cargos.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                    if(respuesta && respuesta.status === "ok"){
                        swal({
                            title: "Eliminado",
                            text: "El cargo fue eliminado definitivamente.",
                            type: "success",
                            confirmButtonText: "Cerrar"
                        }).then(function(r){
                            if(r.value){ window.location = "cargos"; }
                        });
                    }else{
                        swal({
                            title: "Error",
                            text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo eliminar el cargo",
                            type: "error",
                            confirmButtonText: "Cerrar"
                        });
                    }
                },
                error: function(){
                    swal({
                        title: "Error",
                        text: "No se pudo conectar para eliminar el cargo.",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                }
            });
        }
    });
});


// Validación cliente-side para el formulario de edición (modalEditarCargo)
$(document).on('submit', '#formEditarCargo', function(e){
    var nombre = $.trim($('#inputEditNombre').val());
    var regex = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/;
    if(nombre === '' || !regex.test(nombre)){
        e.preventDefault();
        swal({
            type: 'error',
            title: 'Nombre inválido',
            text: 'El campo Área no puede estar vacío ni contener caracteres especiales.',
            showConfirmButton: true,
            confirmButtonText: 'Cerrar'
        });
        return false;
    }
    // permitir envío
    return true;
});