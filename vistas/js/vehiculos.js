
/*-------------------------------------
    REVISAR SI LA PLACA YA ESTÁ REGISTRADO
    -------------------------------------*/

$("#inputPlaca").change(function(){
	$(".alert").remove();
	var placa = $(this).val();
	var datos = new FormData();
	datos.append("validarPlaca", placa);
	 $.ajax({
	    url:"ajax/vehiculos.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){
	    		$("#inputPlaca").parent().after('<div class="alert alert-warning">Esta placa ya existe en la base de datos</div>');
	    		$("#inputPlaca").val("");
	    	}
	    }
	})
});

    /*-------------------------------------
    REVISAR SI EL NUMERO VIN YA ESTÁ REGISTRADO
    -------------------------------------*/

    $("#inputNumeroVin").change(function(){
        $(".alert").remove();
        var numeroVin = $(this).val();
        var datos = new FormData();
        datos.append("validarNumeroVin", numeroVin);
         $.ajax({
            url:"ajax/vehiculos.ajax.php",
            method:"POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(respuesta){
                
                if(respuesta){
                    $("#inputNumeroVin").parent().after('<div class="alert alert-warning">Este número VIN ya existe en la base de datos</div>');
                    $("#inputNumeroVin").val("");
                }
            }
        })
    });
    

    /*-------------------------------------
    REVISAR SI EL NUMERO MOTOR YA ESTÁ REGISTRADO
    -------------------------------------*/

    $("#inputNumeroMotor").change(function(){
        $(".alert").remove();
        var numeroMotor = $(this).val();
        var datos = new FormData();
        datos.append("validarNumeroMotor", numeroMotor);
         $.ajax({
            url:"ajax/vehiculos.ajax.php",
            method:"POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(respuesta){
                
                if(respuesta){
                    $("#inputNumeroMotor").parent().after('<div class="alert alert-warning">Este número motor ya existe en la base de datos</div>');
                    $("#inputNumeroMotor").val("");
                }
            }
        })
    });


    // Función para validar el campo de caracteres especiales
    function validateInput(event) {
        const regex = /^[A-Za-z0-9]*$/;
        if (!regex.test(event.target.value)) {
            // Eliminar caracteres inválidos
            event.target.value = event.target.value.replace(/[^A-Za-z0-9]/g, '');
        }
    }

    // Función para convertir en mayúscula
    function convertToUppercase(event) {
        event.target.value = event.target.value.toUpperCase();
    }

    // Lista de IDs de los elementos de entrada
    const inputIds = [
        "inputNumeroVin",
        "inputNumeroMotor",
        "inputEditNumeroVin",
        "inputEditNumeroMotor"
    ];

    // Agregar eventos solo si los elementos existen en el DOM
    inputIds.forEach(id => {
        const inputElement = document.getElementById(id);
        if (inputElement) {
            inputElement.addEventListener("input", validateInput);
            inputElement.addEventListener("input", convertToUppercase);
        } /*else {
            console.warn(`Elemento con ID '${id}' no encontrado.`);
        }*/
    });






    // Función para validar el campo de caracteres especiales
    /*function validateInput(event) {
        const regex = /^[A-Za-z0-9]*$/;
        if (!regex.test(event.target.value)) {
            // Eliminar caracteres inválidos
            event.target.value = event.target.value.replace(/[^A-Za-z0-9]/g, '');
        }
    }*/

    // Agregar eventos a ambos campos
    /*document.getElementById("inputNumeroVin").addEventListener("input", validateInput);    
    document.getElementById("inputNumeroMotor").addEventListener("input", validateInput);

    document.getElementById("inputEditNumeroVin").addEventListener("input", validateInput);
    document.getElementById("inputEditNumeroMotor").addEventListener("input", validateInput);*/

     // Función para convertir en mayuscula
   /* function convertToUppercase(event) {
        event.target.value = event.target.value.toUpperCase();
    }*/

    // Agregar eventos a ambos campos
   /* document.getElementById("inputNumeroVin").addEventListener("input", convertToUppercase);
    document.getElementById("inputNumeroMotor").addEventListener("input", convertToUppercase);
    
    document.getElementById("inputEditNumeroVin").addEventListener("input", convertToUppercase);
    document.getElementById("inputEditNumeroMotor").addEventListener("input", convertToUppercase);*/


    /*-------------------------------------
    REVISAR SI EL NUMERO MOTOR YA ESTÁ REGISTRADO
    -------------------------------------*/
    $(".tablas").on("click", ".btnEditarVehiculo", function(){
        var idVehiculo = $(this).attr("idVehiculo");   

        var datos = new FormData();
        datos.append("idVehiculo", idVehiculo);

    // console.log(idCategoria);
        $.ajax({
            url: "ajax/vehiculos.ajax.php",
            method: "POST",
            data: datos, 
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                //console.log('Respuesta del servidor:', respuesta);

                $("#inputEditId").val(respuesta["vehic_id"]);
                $("#inputEditPlaca").val(respuesta["vehic_placa"]);
                $("#inputEditMarca").val(respuesta["vehic_marca"]);
                $("#inputEditModelo").val(respuesta["vehic_modelo"]);
                $("#inputEditAnio").val(respuesta["vehic_anio"]);
                $("#inputEditClase").val(respuesta["vehic_clase"]);
                $("#inputEditTipo").val(respuesta["vehic_tipo"]);
                $("#inputEditNumeroVin").val(respuesta["vehic_numero_vin"]);
                $("#inputEditNumeroMotor").val(respuesta["vehic_numero_motor"]);
                $("#inputEditJefeOperacion").val(respuesta["vehic_jefe_operacion"]);
                $("#inputEditEstado").val(respuesta["vehic_estado"]);
                $("#inputEditPropietario").val(respuesta["vehic_propietario"]);
                
                // Establecer el centro de costo y reinicializar select2
                var centroCostoId = respuesta["vehic_cenco_id"];
                $("#inputEditCentro").val(centroCostoId);
                
                // Si select2 está inicializado, actualizar su valor
                if ($("#inputEditCentro").hasClass("select2-hidden-accessible")) {
                    $("#inputEditCentro").trigger("change.select2");
                }
                    if ($("#inputEditTipo").hasClass("select2-hidden-accessible")) {
                        $("#inputEditTipo").trigger("change.select2");
                    }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error en la llamada AJAX:", textStatus, errorThrown);
            }
        });   
    });


/*-------------------------------------
ELIMINAR Categoria
=============================================*/
$(".tablas").on("click", ".btnEliminarVehiculo", function(){

    var idVehiculo = $(this).attr("idVehiculo");

    swal({
        title: '¿Está seguro de eliminar el vehículo?',
        text: "El registro no se borrará físicamente. Primero será enviado a la papelera.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, enviar a papelera'
    }).then(function(result){

        if(result.value){

            window.location = "index.php?ruta=vehiculos&idVehiculo="+idVehiculo;
            //window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;

        }

    })

});

$(document).on("click", ".btnRestaurarVehiculo", function(){
    var idVehiculo = $(this).attr("idVehiculo");
    var nombreVehiculo = $(this).attr("nombreVehiculo");

    swal({
        title: '¿Restaurar vehículo?',
        text: 'El vehículo "' + nombreVehiculo + '" volverá al listado principal.',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, restaurar'
    }).then(function(result){
        if(result.value){
            $.ajax({
                url: "ajax/vehiculos.ajax.php",
                method: "POST",
                data: { restaurarVehiculoId: idVehiculo },
                dataType: "json",
                success: function(respuesta){
                    if(respuesta && respuesta.status === "ok"){
                        swal({
                            title: "Restaurado",
                            text: "El vehículo fue restaurado correctamente.",
                            type: "success",
                            confirmButtonText: "Cerrar"
                        }).then(function(r){ if(r.value){ window.location = "vehiculos"; } });
                    }else{
                        swal({
                            title: "Error",
                            text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo restaurar el vehículo",
                            type: "error",
                            confirmButtonText: "Cerrar"
                        });
                    }
                },
                error: function(){
                    swal({
                        title: "Error",
                        text: "No se pudo conectar para restaurar el vehículo.",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                }
            });
        }
    });
});

$(document).on("click", ".btnDepurarVehiculo", function(){
    var idVehiculo = $(this).attr("idVehiculo");
    var nombreVehiculo = $(this).attr("nombreVehiculo");

    swal({
        title: 'ELIMINACIÓN DEFINITIVA',
        html: '<strong>' + nombreVehiculo + '</strong> será eliminado permanentemente de la base de datos.<br><br>Esta acción no se puede deshacer.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, eliminar para siempre'
    }).then(function(result){
        if(result.value){
            $.ajax({
                url: "ajax/vehiculos.ajax.php",
                method: "POST",
                data: { depurarVehiculoId: idVehiculo },
                dataType: "json",
                success: function(respuesta){
                    if(respuesta && respuesta.status === "ok"){
                        swal({
                            title: "Eliminado",
                            text: "El vehículo fue eliminado definitivamente.",
                            type: "success",
                            confirmButtonText: "Cerrar"
                        }).then(function(r){ if(r.value){ window.location = "vehiculos"; } });
                    }else{
                        swal({
                            title: "Error",
                            text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo eliminar el vehículo",
                            type: "error",
                            confirmButtonText: "Cerrar"
                        });
                    }
                },
                error: function(){
                    swal({
                        title: "Error",
                        text: "No se pudo conectar para eliminar el vehículo.",
                        type: "error",
                        confirmButtonText: "Cerrar"
                    });
                }
            });
        }
    });
});

/*=============================================
GUARDAR CAMBIOS DE EDITAR VEHICULO VIA AJAX
=============================================*/
$("#formEditarVehiculo").on("submit", function(e){
    e.preventDefault();

    var datos = new FormData(this);
    datos.append("actualizarVehiculo", "ok");

    // Debug: ver qué datos se están enviando
    console.log("Datos a enviar:", {
        id: $("#inputEditId").val(),
        centro: $("#inputEditCentro").val(),
        placa: $("#inputEditPlaca").val(),
        marca: $("#inputEditMarca").val(),
        modelo: $("#inputEditModelo").val(),
        anio: $("#inputEditAnio").val(),
        clase: $("#inputEditClase").val(),
        tipo: $("#inputEditTipo").val(),
        vin: $("#inputEditNumeroVin").val(),
        motor: $("#inputEditNumeroMotor").val(),
        jefe: $("#inputEditJefeOperacion").val(),
        estado: $("#inputEditEstado").val(),
        propietario: $("#inputEditPropietario").val()
    });

    $.ajax({
        url: "ajax/vehiculos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            console.log("Respuesta del servidor:", respuesta);
            
            if(respuesta == "ok") {
                swal({
                    type: "success",
                    title: "¡Correcto!",
                    text: "Los datos se han actualizado correctamente.",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value) {
                        location.reload();
                    }
                });
            } else {
                swal({
                    type: "error",
                    title: "¡Error!",
                    text: "Ocurrió un error al intentar actualizar los datos. Respuesta: " + JSON.stringify(respuesta),
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log("Error AJAX:", textStatus, errorThrown);
            console.log("Response text:", jqXHR.responseText);
            swal({
                type: "error",
                title: "¡Error!",
                text: "Error en la solicitud AJAX. " + textStatus,
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            });
        }
    });

});