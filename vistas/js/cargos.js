
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

            window.location = "index.php?ruta=cargos&idCargo="+idCargo;
            //window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;

        }

    })

})


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