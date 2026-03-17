
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
$(".tablas").on("click", ".btnEliminarrCentroCosto", function(){

    var idCentroCosto = $(this).attr("idCentroCosto");

    swal({
        title: '¿Está seguro de borrar Centro de Costo?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar categoría!'
    }).then(function(result){

        if(result.value){

            window.location = "index.php?ruta=centro-costo&idCentroCosto="+idCentroCosto;
            //window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;

        }

    })

})