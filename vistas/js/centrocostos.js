
/*=============================================
EDITAR Categoria
=============================================*/
$(".tablas").on("click", ".btnEditarCentroCosto", function(){
	var idCentroCosto = $(this).attr("idCentroCosto");   

	var datos = new FormData();
	datos.append("idCentroCosto", idCentroCosto);

   // console.log(idCategoria);
    $.ajax({
        url: "ajax/centrocostos.ajax.php",
        method: "POST",
        data: datos, 
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            //console.log('Respuesta del servidor:', respuesta);
            $("#inputEditCodigo").val(respuesta["cenco_codigo"]);
            $("#inputEditNombre").val(respuesta["cenco_nombre"]);
            $("#inputEditId").val(respuesta["cenco_id"]);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error en la llamada AJAX:", textStatus, errorThrown);
        }
    });   
});


/*=============================================
ELIMINAR Categoria
=============================================*/
$(".tablas").on("click", ".btnEliminarCentroCosto", function(){

    var idCentroCosto = $(this).attr("idCentroCosto");

    swal({
        title: '¿Está seguro de eliminar el centro de costo?',
        text: "El registro no se borrará físicamente. Primero será enviado a la papelera.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, enviar a papelera'
    }).then(function(result){

        if(result.value){

            window.location = "index.php?ruta=centro-costo&idCentroCosto="+idCentroCosto;
            //window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;

        }

    })

});

/*=============================================
RESTAURAR CENTRO DE COSTO DESDE PAPELERA
=============================================*/
$(document).on("click", ".btnRestaurarCentroCosto", function(){

    var idCentroCosto = $(this).attr("idCentroCosto");
    var nombreCentroCosto = $(this).attr("nombreCentroCosto");

    swal({
        title: '¿Restaurar centro de costo?',
        text: 'El centro de costo "' + nombreCentroCosto + '" volverá al listado principal.',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, restaurar'
    }).then(function(result){

        if(result.value){

            var datos = new FormData();
            datos.append("restaurarCentroCostoId", idCentroCosto);

            $.ajax({
                url: "ajax/centrocostos.ajax.php",
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
                            text: "El centro de costo fue restaurado correctamente.",
                            type: "success",
                            confirmButtonText: "Cerrar"
                        }).then(function(r){
                            if(r.value){ window.location = "centro-costo"; }
                        });
                    }else{
                        swal({
                            title: "Error",
                            text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo restaurar el centro de costo",
                            type: "error",
                            confirmButtonText: "Cerrar"
                        });
                    }
                },
                error: function(){
                    swal({
                        title: "Error",
                        text: "No se pudo conectar para restaurar el centro de costo.",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                }
            });
        }
    });
});

/*=============================================
DEPURAR CENTRO DE COSTO - ELIMINACION FISICA
=============================================*/
$(document).on("click", ".btnDepurarCentroCosto", function(){

    var idCentroCosto = $(this).attr("idCentroCosto");
    var nombreCentroCosto = $(this).attr("nombreCentroCosto");

    swal({
        title: 'ELIMINACIÓN DEFINITIVA',
        html: '<strong>' + nombreCentroCosto + '</strong> será eliminado permanentemente de la base de datos.<br><br>Esta acción no se puede deshacer.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, eliminar para siempre'
    }).then(function(result){

        if(result.value){

            var datos = new FormData();
            datos.append("depurarCentroCostoId", idCentroCosto);

            $.ajax({
                url: "ajax/centrocostos.ajax.php",
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
                            text: "El centro de costo fue eliminado definitivamente.",
                            type: "success",
                            confirmButtonText: "Cerrar"
                        }).then(function(r){
                            if(r.value){ window.location = "centro-costo"; }
                        });
                    }else{
                        swal({
                            title: "Error",
                            text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo eliminar el centro de costo",
                            type: "error",
                            confirmButtonText: "Cerrar"
                        });
                    }
                },
                error: function(){
                    swal({
                        title: "Error",
                        text: "No se pudo conectar para eliminar el centro de costo.",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                }
            });
        }
    });
});