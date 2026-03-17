
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

            window.location = "index.php?ruta=areas&idArea="+idArea;
            //window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;

        }

    })

})