
/*=============================================
EDITAR Categoria
=============================================*/
$(".tablas").on("click", ".btnEditarArea", function(){
	var idArea = $(this).attr("idArea");   

	var datos = new FormData();
	datos.append("idArea", idArea);

   // console.log(idCategoria);
    $.ajax({
        url: "ajax/areas.ajax.php",
        method: "POST",
        data: datos, 
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            //console.log('Respuesta del servidor:', respuesta);
            $("#inputEditNombre").val(respuesta["are_nombre"]);
            $("#inputEditId").val(respuesta["are_id"]);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error en la llamada AJAX:", textStatus, errorThrown);
        }
    });   
});


/*=============================================
ELIMINAR Categoria
=============================================*/
$(".tablas").on("click", ".btnEliminarArea", function(){

    var idArea = $(this).attr("idArea");

    swal({
        title: '¿Está seguro de eliminar el área?',
        text: "El registro no se borrará físicamente. Primero será enviado a la papelera.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, enviar a papelera'
    }).then(function(result){

        if(result.value){

            window.location = "index.php?ruta=areas&idArea="+idArea;
            //window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;

        }

    })

});

/*=============================================
RESTAURAR AREA DESDE PAPELERA
=============================================*/
$(document).on("click", ".btnRestaurarArea", function(){

    var idArea = $(this).attr("idArea");
    var nombreArea = $(this).attr("nombreArea");

    swal({
        title: '¿Restaurar área?',
        text: 'El área "' + nombreArea + '" volverá al listado principal.',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, restaurar'
    }).then(function(result){

        if(result.value){

            var datos = new FormData();
            datos.append("restaurarAreaId", idArea);

            $.ajax({
                url: "ajax/areas.ajax.php",
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
                            text: "El área fue restaurada correctamente.",
                            type: "success",
                            confirmButtonText: "Cerrar"
                        }).then(function(r){
                            if(r.value){ window.location = "areas"; }
                        });
                    }else{
                        swal({
                            title: "Error",
                            text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo restaurar el área",
                            type: "error",
                            confirmButtonText: "Cerrar"
                        });
                    }
                },
                error: function(){
                    swal({
                        title: "Error",
                        text: "No se pudo conectar para restaurar el área.",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                }
            });
        }
    });
});

/*=============================================
DEPURAR AREA - ELIMINACION FISICA
=============================================*/
$(document).on("click", ".btnDepurarArea", function(){

    var idArea = $(this).attr("idArea");
    var nombreArea = $(this).attr("nombreArea");

    swal({
        title: 'ELIMINACIÓN DEFINITIVA',
        html: '<strong>' + nombreArea + '</strong> será eliminada permanentemente de la base de datos.<br><br>Esta acción no se puede deshacer.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, eliminar para siempre'
    }).then(function(result){

        if(result.value){

            var datos = new FormData();
            datos.append("depurarAreaId", idArea);

            $.ajax({
                url: "ajax/areas.ajax.php",
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
                            text: "El área fue eliminada definitivamente.",
                            type: "success",
                            confirmButtonText: "Cerrar"
                        }).then(function(r){
                            if(r.value){ window.location = "areas"; }
                        });
                    }else{
                        swal({
                            title: "Error",
                            text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo eliminar el área",
                            type: "error",
                            confirmButtonText: "Cerrar"
                        });
                    }
                },
                error: function(){
                    swal({
                        title: "Error",
                        text: "No se pudo conectar para eliminar el área.",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                }
            });
        }
    });
});