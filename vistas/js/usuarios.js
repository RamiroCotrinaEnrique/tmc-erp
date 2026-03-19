/*=============================================
SUBIENDO LA FOTO DEL USUARIO
=============================================*/
$(".nuevaFoto").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

  		$(".nuevaFoto").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen debe usuar en formato JPG o PNG!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else if(imagen["size"] > 2000000){

  		$(".nuevaFoto").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen no debe pesar más de 2MB!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else{

  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);

  		$(datosImagen).on("load", function(event){

  			var rutaImagen = event.target.result;

  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}
});

/*=============================================
EDITAR Usuario
=============================================*/
$(".tablas").on("click", ".btnEditarUsuario", function(){
	var idUsuario = $(this).attr("idUsuario");   

	var datos = new FormData();

	datos.append("idUsuario", idUsuario);

    $.ajax({
        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: datos, 
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(repuesta) {
            console.log('repuesta del servidor:', repuesta);
            $("#editarNombre").val(repuesta["usu_nombre"]);
            $("#editarUsuario").val(repuesta["usu_usuario"]);
            $("#editarPerfil").val(repuesta["usu_perfil"]);
            $("#claveActual").val(repuesta["usu_password"]);
            $("#fotoActual").val(repuesta["usu_foto"]);
			if (repuesta["usu_foto"] != "") {
				$(".previsualizar").attr("src",repuesta["usu_foto"]);				
			} 		
			$("#editarId").val(repuesta["usu_id"]);
        },
        error: function(jqXHR, textStatus, errorThrown) {console.log("Error en la llamada AJAX:", textStatus, errorThrown);}
    });   
});


/*=============================================
ACTIVAR USUARIO
=============================================*/
$(document).on("click", ".btnActivar", function(){

	var idUsuario = $(this).attr("idUsuario");
	var estadoUsuario = $(this).attr("estadoUsuario");

	var datos = new FormData();
 	datos.append("activarId", idUsuario);
  	datos.append("activarUsuario", estadoUsuario);

  	$.ajax({

	  url:"ajax/usuarios.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

		swal({
			title: "El usuario ha sido actualizado",
			type: "success",
			confirmButtonText: "¡Cerrar!"
		}).then(function(result) {
			if (result.value) {
				window.location = "usuarios";
			}
		});

      },        
	  error: function(jqXHR, textStatus, errorThrown) {console.log("Error en la llamada AJAX:", textStatus, errorThrown);}

  	});

  	if(estadoUsuario == 0){
  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoUsuario',1);
  	}else{
  		$(this).addClass('btn-success');
  		$(this).removeClass('btn-danger');
  		$(this).html('Activado');
  		$(this).attr('estadoUsuario',0);
  	}
});

/*=============================================
REVISAR SI EL USUARIO YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoUsuario").change(function(){
	$(".alert").remove();
	var usuario = $(this).val();
	var datos = new FormData();
	datos.append("validarUsuario", usuario);
	 $.ajax({
	    url:"ajax/usuarios.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){
	    		$("#nuevoUsuario").parent().after('<div class="alert alert-warning">Este usuario ya existe en la base de datos</div>');
	    		$("#nuevoUsuario").val("");
	    	}
	    }
	})
});


/*=============================================
ELIMINAR USUARIO
=============================================*/
$(document).on("click", ".btnEliminarUsuario", function(){

	var idUsuario = $(this).attr("idUsuario");
	var fotoUsuario = $(this).attr("fotoUsuario");
	var usuario = $(this).attr("usuario");
  
	swal({
	  title: '¿Está seguro de eliminar este usuario?',
	  text: "El usuario no se borrará físicamente, quedará oculto en el listado.",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, eliminar usuario'
	}).then(function(result){
  
	  if(result.value){
  
		window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario;
  
	  }
  
	})
  
  })

/*=============================================
EDITAR PRIVILEGIOS DE MODULOS POR USUARIO
=============================================*/
$(document).on("click", ".btnPrivilegiosUsuario", function(){

	var idUsuario = $(this).attr("idUsuario");
	$("#privilegiosUsuarioId").val(idUsuario);
	$("#privilegiosUsuarioNombre").val("");
	$(".checkModuloUsuario").prop("checked", false);
	$("#checkTodosModulos").prop("checked", false);

	var datos = new FormData();
	datos.append("idUsuarioPrivilegios", idUsuario);

	$.ajax({
		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			if(!respuesta || respuesta.status !== "ok"){
				swal({
					title: "Error",
					text: (respuesta && respuesta.message) ? respuesta.message : "No se pudieron cargar los privilegios",
					type: "error",
					confirmButtonText: "Cerrar"
				});
				return;
			}

			if(respuesta.usuario && respuesta.usuario.usu_nombre){
				$("#privilegiosUsuarioNombre").val(respuesta.usuario.usu_nombre + " (" + respuesta.usuario.usu_perfil + ")");
			}

			if(Array.isArray(respuesta.modulos)){
				respuesta.modulos.forEach(function(modulo){
					$(".checkModuloUsuario[value='" + modulo + "']").prop("checked", true);
				});
			}

			actualizarEstadoCheckTodos();
		},
		error: function(){
			swal({
				title: "Error",
				text: "No se pudo consultar los privilegios del usuario",
				type: "error",
				confirmButtonText: "Cerrar"
			});
		}
	});
});

$(document).on("change", "#checkTodosModulos", function(){
	$(".checkModuloUsuario").prop("checked", $(this).is(":checked"));
});

$(document).on("change", ".checkModuloUsuario", function(){
	actualizarEstadoCheckTodos();
});

function actualizarEstadoCheckTodos(){
	var total = $(".checkModuloUsuario").length;
	var marcados = $(".checkModuloUsuario:checked").length;
	$("#checkTodosModulos").prop("checked", total > 0 && total === marcados);
}

$("#formPrivilegiosUsuario").on("submit", function(e){
	e.preventDefault();

	var idUsuario = $("#privilegiosUsuarioId").val();
	var modulos = [];
	$(".checkModuloUsuario:checked").each(function(){
		modulos.push($(this).val());
	});

	var datos = new FormData();
	datos.append("guardarPrivilegiosUsuario", "1");
	datos.append("idUsuario", idUsuario);
	for(var i = 0; i < modulos.length; i++){
		datos.append("modulos[]", modulos[i]);
	}

	$.ajax({
		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			if(respuesta && respuesta.status === "ok"){
				swal({
					title: "Correcto",
					text: "Los privilegios fueron guardados correctamente",
					type: "success",
					confirmButtonText: "Cerrar"
				}).then(function(result){
					if(result.value){
						window.location = "usuarios";
					}
				});
				return;
			}

			swal({
				title: "Error",
				text: (respuesta && respuesta.message) ? respuesta.message : "No se pudieron guardar los privilegios",
				type: "error",
				confirmButtonText: "Cerrar"
			});
		},
		error: function(){
			swal({
				title: "Error",
				text: "No se pudo guardar los privilegios del usuario",
				type: "error",
				confirmButtonText: "Cerrar"
			});
		}
	});
});

/*=============================================
RESTAURAR USUARIO DESDE PAPELERA
=============================================*/
$(document).on("click", ".btnRestaurarUsuario", function(){

	var idUsuario = $(this).attr("idUsuario");
	var nombreUsuario = $(this).attr("nombreUsuario");

	swal({
		title: '¿Restaurar usuario?',
		text: 'El usuario "' + nombreUsuario + '" volverá a estar disponible en el sistema.',
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#28a745',
		cancelButtonColor: '#6c757d',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Sí, restaurar'
	}).then(function(result){

		if(result.value){

			var datos = new FormData();
			datos.append("restaurarUsuarioId", idUsuario);

			$.ajax({
				url: "ajax/usuarios.ajax.php",
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
							text: "El usuario ha sido restaurado correctamente.",
							type: "success",
							confirmButtonText: "Cerrar"
						}).then(function(r){
							if(r.value){ window.location = "usuarios"; }
						});
					}else{
						swal({
							title: "Error",
							text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo restaurar el usuario",
							type: "error",
							confirmButtonText: "Cerrar"
						});
					}
				},
				error: function(){
					swal({
						title: "Error",
						text: "No se pudo conectar para restaurar el usuario.",
						type: "error",
						confirmButtonText: "Cerrar"
					});
				}
			});
		}
	});
});

/*=============================================
DEPURAR USUARIO - ELIMINACION FISICA (SOLO ADMINISTRADOR)
=============================================*/
$(document).on("click", ".btnDepurarUsuario", function(){

	var idUsuario = $(this).attr("idUsuario");
	var nombreUsuario = $(this).attr("nombreUsuario");

	swal({
		title: '\u26a0\ufe0f ELIMINACI\u00d3N DEFINITIVA',
		html: '<strong>' + nombreUsuario + '</strong> ser\u00e1 eliminado <strong>permanentemente</strong> de la base de datos.<br><br>Esta acci\u00f3n <u>no se puede deshacer</u>.',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#dc3545',
		cancelButtonColor: '#6c757d',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'S\u00ed, eliminar para siempre'
	}).then(function(result){

		if(result.value){

			var datos = new FormData();
			datos.append("depurarUsuarioId", idUsuario);

			$.ajax({
				url: "ajax/usuarios.ajax.php",
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
							text: "El usuario ha sido eliminado definitivamente.",
							type: "success",
							confirmButtonText: "Cerrar"
						}).then(function(r){
							if(r.value){ window.location = "usuarios"; }
						});
					}else{
						swal({
							title: "Error",
							text: (respuesta && respuesta.message) ? respuesta.message : "No se pudo eliminar al usuario",
							type: "error",
							confirmButtonText: "Cerrar"
						});
					}
				},
				error: function(){
					swal({
						title: "Error",
						text: "No se pudo conectar para eliminar al usuario.",
						type: "error",
						confirmButtonText: "Cerrar"
					});
				}
			});
		}
	});
});
