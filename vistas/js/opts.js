//Date picker
$("#reservationdateEditar").datetimepicker({
	//format: 'L'
	format: "YYYY-MM-DD",
  });

/*=============================================
MOSTRAR IMAGEN EN MODAL
=============================================*/
  // Espera a que el DOM esté listo
  document.addEventListener("DOMContentLoaded", function () {
    // Delegación para todas las miniaturas con clase .verImagenModal
    document.querySelectorAll('.verImagenModal').forEach(function(img) {
      img.addEventListener('click', function() {
        var src = this.getAttribute('data-src');
        document.getElementById('imagenModal').setAttribute('src', src);
      });
    });
  }); 

/*=============================================
SUBIENDO LA FOTO DEL Opt nuevaFoto1
=============================================*/
$(".nuevaFoto1").change(function () {
	var imagen = this.files[0];
	//console.log(imagen);

	/*=============================================
		VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
		=============================================*/

	if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
		$(".nuevaFoto1").val("");

		swal({
			title: "Error al subir la imagen",
			text: "¡La imagen debe estar en formato JPG o PNG!",
			type: "error",
			confirmButtonText: "¡Cerrar!",
		});

	} else if (imagen["size"] > 4000000) {
		$(".nuevaFoto1").val("");

		swal({
			title: "Error al subir la imagen",
			text: "¡La imagen no debe pesar más de 4MB!",
			type: "error",
			confirmButtonText: "¡Cerrar!",
		});
	} else {
		var datosImagen = new FileReader();
		datosImagen.readAsDataURL(imagen);
		$(datosImagen).on("load", function (event) {
			var rutaImagen = event.target.result;
            //console.log(rutaImagen);
			$(".previsualizar1").attr("src", rutaImagen);
		});
	}
});

$(".nuevaFoto2").change(function () {
	var imagen = this.files[0];

	/*=============================================
		VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
		=============================================*/

	if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
		$(".nuevaFoto2").val("");

		swal({
			title: "Error al subir la imagen",
			text: "¡La imagen debe estar en formato JPG o PNG!",
			type: "error",
			confirmButtonText: "¡Cerrar!",
		});
	} else if (imagen["size"] > 4000000) {
		$(".nuevaFoto2").val("");

		swal({
			title: "Error al subir la imagen",
			text: "¡La imagen no debe pesar más de 4MB!",
			type: "error",
			confirmButtonText: "¡Cerrar!",
		});
	} else {
		var datosImagen = new FileReader();
		datosImagen.readAsDataURL(imagen);
		$(datosImagen).on("load", function (event) {
			var rutaImagen = event.target.result;
			$(".previsualizar2").attr("src", rutaImagen);
		});
	}
});

function mostrarTablaParaGuardar() {
    let seleccion = document.getElementById("inputOperacion").value;
    let tablas = document.querySelectorAll(".guardarTable");

    // Ocultar todas las tablas
    tablas.forEach(tabla => {
        tabla.style.display = "none";
    });

    // Mostrar la tabla correspondiente a la selección
    if (seleccion) {
        let tablaMostrar = document.getElementById(seleccion);
        if (tablaMostrar) {
            tablaMostrar.style.display = "table";
        }
    }
} 




function mostrarEditarTabla() {
    let seleccion = document.getElementById("inputEditarOperacion").value;
    let tablas = document.querySelectorAll(".editarTable"); // solo las tablas del formulario editar

    // Ocultar todas las tablas primero
    tablas.forEach(tabla => {
        tabla.style.display = "none";
    });

    // Mostrar la tabla seleccionada
    if (seleccion) {
        let tablaMostrar = document.getElementById(seleccion);
		//console.log(document.getElementById("tablaEdit500")); // ¿devuelve null?

        if (tablaMostrar) {
            tablaMostrar.style.display = "table";

            // Desplazar suavemente hacia la tabla mostrada
            tablaMostrar.scrollIntoView({ behavior: 'smooth' });
        } else {
            console.warn("No se encontró la tabla con el ID:", seleccion);
        }
    }
}



/*=============================================
EDITAR Opt
=============================================*/
$(document).on("click", ".btnEditarOpt", function () {
	var idOpt = $(this).attr("idOpt");
	//console.log(idOpt);
	var datos = new FormData();
	datos.append("idOpt", idOpt);
	//	console.log(datos);
	$.ajax({
		url: "ajax/opts.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			//LISTADO DE SELECT 
			$("#inputEditarOperacion").val("tablaEdit" + respuesta["opt_cenco_codigo"]).trigger('change');
			mostrarEditarTabla();

			//ENTRADA 500 TSE LIMA Y PROVINCIAS - SOLGAS 
			$("input[name='500_edit_txtPregunta1'][value='" + respuesta["opt_500_pregunta1"] + "']").prop("checked", true);
			$("input[name='500_edit_txtPregunta2'][value='" + respuesta["opt_500_pregunta2"] + "']").prop("checked", true);
			$("input[name='500_edit_txtPregunta3'][value='" + respuesta["opt_500_pregunta3"] + "']").prop("checked", true);
			$("input[name='500_edit_txtPregunta4'][value='" + respuesta["opt_500_pregunta4"] + "']").prop("checked", true);
			$("input[name='500_edit_txtPregunta5'][value='" + respuesta["opt_500_pregunta5"] + "']").prop("checked", true);
			$("input[name='500_edit_txtPregunta6'][value='" + respuesta["opt_500_pregunta6"] + "']").prop("checked", true);
			$("input[name='500_edit_txtPregunta7'][value='" + respuesta["opt_500_pregunta7"] + "']").prop("checked", true);
			$("input[name='500_edit_txtPregunta8'][value='" + respuesta["opt_500_pregunta8"] + "']").prop("checked", true);
			$("input[name='500_edit_txtPregunta9'][value='" + respuesta["opt_500_pregunta9"] + "']").prop("checked", true);
			$("input[name='500_edit_txtPregunta10'][value='" + respuesta["opt_500_pregunta10"] + "']").prop("checked", true); 
			$("input[name='500_edit_txtPregunta11'][value='" + respuesta["opt_500_pregunta11"] + "']").prop("checked", true); 
			$("input[name='500_edit_txtPregunta12'][value='" + respuesta["opt_500_pregunta12"] + "']").prop("checked", true); 
			$("input[name='500_edit_txtPregunta13'][value='" + respuesta["opt_500_pregunta13"] + "']").prop("checked", true); 
			$("input[name='500_edit_txtPregunta14'][value='" + respuesta["opt_500_pregunta14"] + "']").prop("checked", true); 
			$("input[name='500_edit_txtPregunta15'][value='" + respuesta["opt_500_pregunta15"] + "']").prop("checked", true); 
			$("textarea[name='500_edit_txtOtros']").val(respuesta["opt_500_otros"]);

			//ENTRADA  501 CANJE LIMA Y PROVINCIAS - SOLGAS
			$("input[name='501_edit_txtPregunta1'][value='" + respuesta["opt_501_pregunta1"] + "']").prop("checked", true);
			$("input[name='501_edit_txtPregunta2'][value='" + respuesta["opt_501_pregunta2"] + "']").prop("checked", true);
			$("input[name='501_edit_txtPregunta3'][value='" + respuesta["opt_501_pregunta3"] + "']").prop("checked", true);
			$("input[name='501_edit_txtPregunta4'][value='" + respuesta["opt_501_pregunta4"] + "']").prop("checked", true);
			$("input[name='501_edit_txtPregunta5'][value='" + respuesta["opt_501_pregunta5"] + "']").prop("checked", true);
			$("input[name='501_edit_txtPregunta6'][value='" + respuesta["opt_501_pregunta6"] + "']").prop("checked", true);
			$("input[name='501_edit_txtPregunta7'][value='" + respuesta["opt_501_pregunta7"] + "']").prop("checked", true);
			$("input[name='501_edit_txtPregunta8'][value='" + respuesta["opt_501_pregunta8"] + "']").prop("checked", true);
			$("input[name='501_edit_txtPregunta9'][value='" + respuesta["opt_501_pregunta9"] + "']").prop("checked", true);
			$("input[name='501_edit_txtPregunta10'][value='" + respuesta["opt_501_pregunta10"] + "']").prop("checked", true); 
			$("input[name='501_edit_txtPregunta11'][value='" + respuesta["opt_501_pregunta11"] + "']").prop("checked", true); 
			$("input[name='501_edit_txtPregunta12'][value='" + respuesta["opt_501_pregunta12"] + "']").prop("checked", true); 
			$("input[name='501_edit_txtPregunta13'][value='" + respuesta["opt_501_pregunta13"] + "']").prop("checked", true); 
			$("input[name='501_edit_txtPregunta14'][value='" + respuesta["opt_501_pregunta14"] + "']").prop("checked", true);  
			$("textarea[name='501_edit_txtOtros']").val(respuesta["opt_501_otros"]);

			//OK ENTRADA  504 TSG LIMA Y PROVINCIAS - REPSOL
			$("input[name='504_edit_txtPregunta1'][value='" + respuesta["opt_504_pregunta1"] + "']").prop("checked", true);
			$("input[name='504_edit_txtPregunta2'][value='" + respuesta["opt_504_pregunta2"] + "']").prop("checked", true);
			$("input[name='504_edit_txtPregunta3'][value='" + respuesta["opt_504_pregunta3"] + "']").prop("checked", true);
			$("input[name='504_edit_txtPregunta4'][value='" + respuesta["opt_504_pregunta4"] + "']").prop("checked", true);
			$("input[name='504_edit_txtPregunta5'][value='" + respuesta["opt_504_pregunta5"] + "']").prop("checked", true);
			$("input[name='504_edit_txtPregunta6'][value='" + respuesta["opt_504_pregunta6"] + "']").prop("checked", true);
			$("input[name='504_edit_txtPregunta7'][value='" + respuesta["opt_504_pregunta7"] + "']").prop("checked", true);
			$("input[name='504_edit_txtPregunta8'][value='" + respuesta["opt_504_pregunta8"] + "']").prop("checked", true);
			$("input[name='504_edit_txtPregunta9'][value='" + respuesta["opt_504_pregunta9"] + "']").prop("checked", true);
			$("input[name='504_edit_txtPregunta10'][value='" + respuesta["opt_504_pregunta10"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta11'][value='" + respuesta["opt_504_pregunta11"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta12'][value='" + respuesta["opt_504_pregunta12"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta13'][value='" + respuesta["opt_504_pregunta13"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta14'][value='" + respuesta["opt_504_pregunta14"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta15'][value='" + respuesta["opt_504_pregunta15"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta16'][value='" + respuesta["opt_504_pregunta16"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta17'][value='" + respuesta["opt_504_pregunta17"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta18'][value='" + respuesta["opt_504_pregunta18"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta19'][value='" + respuesta["opt_504_pregunta19"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta20'][value='" + respuesta["opt_504_pregunta20"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta21'][value='" + respuesta["opt_504_pregunta21"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta22'][value='" + respuesta["opt_504_pregunta22"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta23'][value='" + respuesta["opt_504_pregunta23"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta24'][value='" + respuesta["opt_504_pregunta24"] + "']").prop("checked", true); 
			$("input[name='504_edit_txtPregunta25'][value='" + respuesta["opt_504_pregunta25"] + "']").prop("checked", true); 
			$("textarea[name='504_edit_txtOtros']").val(respuesta["opt_504_otros"]);

			//506 - TTP LIMA - CEMEX 
			$("input[name='506_edit_txtPregunta1'][value='" + respuesta["opt_506_pregunta1"] + "']").prop("checked", true);
			$("input[name='506_edit_txtPregunta2'][value='" + respuesta["opt_506_pregunta2"] + "']").prop("checked", true);
			$("input[name='506_edit_txtPregunta3'][value='" + respuesta["opt_506_pregunta3"] + "']").prop("checked", true);
			$("input[name='506_edit_txtPregunta4'][value='" + respuesta["opt_506_pregunta4"] + "']").prop("checked", true);
			$("input[name='506_edit_txtPregunta5'][value='" + respuesta["opt_506_pregunta5"] + "']").prop("checked", true);
			$("input[name='506_edit_txtPregunta6'][value='" + respuesta["opt_506_pregunta6"] + "']").prop("checked", true);
			$("input[name='506_edit_txtPregunta7'][value='" + respuesta["opt_506_pregunta7"] + "']").prop("checked", true);
			$("input[name='506_edit_txtPregunta8'][value='" + respuesta["opt_506_pregunta8"] + "']").prop("checked", true);
			$("input[name='506_edit_txtPregunta9'][value='" + respuesta["opt_506_pregunta9"] + "']").prop("checked", true);
			$("input[name='506_edit_txtPregunta10'][value='" + respuesta["opt_506_pregunta10"] + "']").prop("checked", true); 
			$("input[name='506_edit_txtPregunta11'][value='" + respuesta["opt_506_pregunta11"] + "']").prop("checked", true); 
			$("input[name='506_edit_txtPregunta12'][value='" + respuesta["opt_506_pregunta12"] + "']").prop("checked", true); 
			$("input[name='506_edit_txtPregunta13'][value='" + respuesta["opt_506_pregunta13"] + "']").prop("checked", true);  
			$("textarea[name='506_edit_txtOtros']").val(respuesta["opt_506_otros"]);

			//507 TSG LIMA Y PROVINCIAS - SOLGAS
			$("input[name='507_edit_txtPregunta1'][value='" + respuesta["opt_507_pregunta1"] + "']").prop("checked", true);
			$("input[name='507_edit_txtPregunta2'][value='" + respuesta["opt_507_pregunta2"] + "']").prop("checked", true);
			$("input[name='507_edit_txtPregunta3'][value='" + respuesta["opt_507_pregunta3"] + "']").prop("checked", true);
			$("input[name='507_edit_txtPregunta4'][value='" + respuesta["opt_507_pregunta4"] + "']").prop("checked", true);
			$("input[name='507_edit_txtPregunta5'][value='" + respuesta["opt_507_pregunta5"] + "']").prop("checked", true);
			$("input[name='507_edit_txtPregunta6'][value='" + respuesta["opt_507_pregunta6"] + "']").prop("checked", true);
			$("input[name='507_edit_txtPregunta7'][value='" + respuesta["opt_507_pregunta7"] + "']").prop("checked", true);
			$("input[name='507_edit_txtPregunta8'][value='" + respuesta["opt_507_pregunta8"] + "']").prop("checked", true);
			$("input[name='507_edit_txtPregunta9'][value='" + respuesta["opt_507_pregunta9"] + "']").prop("checked", true);
			$("input[name='507_edit_txtPregunta10'][value='" + respuesta["opt_507_pregunta10"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta11'][value='" + respuesta["opt_507_pregunta11"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta12'][value='" + respuesta["opt_507_pregunta12"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta13'][value='" + respuesta["opt_507_pregunta13"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta14'][value='" + respuesta["opt_507_pregunta14"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta15'][value='" + respuesta["opt_507_pregunta15"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta16'][value='" + respuesta["opt_507_pregunta16"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta17'][value='" + respuesta["opt_507_pregunta17"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta18'][value='" + respuesta["opt_507_pregunta18"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta19'][value='" + respuesta["opt_507_pregunta19"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta20'][value='" + respuesta["opt_507_pregunta20"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta21'][value='" + respuesta["opt_507_pregunta21"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta22'][value='" + respuesta["opt_507_pregunta22"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta23'][value='" + respuesta["opt_507_pregunta23"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta24'][value='" + respuesta["opt_507_pregunta24"] + "']").prop("checked", true); 
			$("input[name='507_edit_txtPregunta25'][value='" + respuesta["opt_507_pregunta25"] + "']").prop("checked", true); 
			$("textarea[name='507_edit_txtOtros']").val(respuesta["opt_507_otros"]);

			//508 PACKAGE LIMA - LINDE
			$("input[name='508_edit_txtPregunta1'][value='" + respuesta["opt_508_pregunta1"] + "']").prop("checked", true);
			$("input[name='508_edit_txtPregunta2'][value='" + respuesta["opt_508_pregunta2"] + "']").prop("checked", true);
			$("input[name='508_edit_txtPregunta3'][value='" + respuesta["opt_508_pregunta3"] + "']").prop("checked", true);
			$("input[name='508_edit_txtPregunta4'][value='" + respuesta["opt_508_pregunta4"] + "']").prop("checked", true);
			$("input[name='508_edit_txtPregunta5'][value='" + respuesta["opt_508_pregunta5"] + "']").prop("checked", true);
			$("input[name='508_edit_txtPregunta6'][value='" + respuesta["opt_508_pregunta6"] + "']").prop("checked", true);
			$("input[name='508_edit_txtPregunta7'][value='" + respuesta["opt_508_pregunta7"] + "']").prop("checked", true);
			$("input[name='508_edit_txtPregunta8'][value='" + respuesta["opt_508_pregunta8"] + "']").prop("checked", true);
			$("input[name='508_edit_txtPregunta9'][value='" + respuesta["opt_508_pregunta9"] + "']").prop("checked", true);
			$("input[name='508_edit_txtPregunta10'][value='" + respuesta["opt_508_pregunta10"] + "']").prop("checked", true); 
			$("input[name='508_edit_txtPregunta11'][value='" + respuesta["opt_508_pregunta11"] + "']").prop("checked", true); 
			$("input[name='508_edit_txtPregunta12'][value='" + respuesta["opt_508_pregunta12"] + "']").prop("checked", true); 
			$("input[name='508_edit_txtPregunta13'][value='" + respuesta["opt_508_pregunta13"] + "']").prop("checked", true);  
			$("textarea[name='508_edit_txtOtros']").val(respuesta["opt_508_otros"]);

			//509 TSG LIMA Y PROVINCIAS - LIMA GAS
			$("input[name='509_edit_txtPregunta1'][value='" + respuesta["opt_509_pregunta1"] + "']").prop("checked", true);
			$("input[name='509_edit_txtPregunta2'][value='" + respuesta["opt_509_pregunta2"] + "']").prop("checked", true);
			$("input[name='509_edit_txtPregunta3'][value='" + respuesta["opt_509_pregunta3"] + "']").prop("checked", true);
			$("input[name='509_edit_txtPregunta4'][value='" + respuesta["opt_509_pregunta4"] + "']").prop("checked", true);
			$("input[name='509_edit_txtPregunta5'][value='" + respuesta["opt_509_pregunta5"] + "']").prop("checked", true);
			$("input[name='509_edit_txtPregunta6'][value='" + respuesta["opt_509_pregunta6"] + "']").prop("checked", true);
			$("input[name='509_edit_txtPregunta7'][value='" + respuesta["opt_509_pregunta7"] + "']").prop("checked", true);
			$("input[name='509_edit_txtPregunta8'][value='" + respuesta["opt_509_pregunta8"] + "']").prop("checked", true);
			$("input[name='509_edit_txtPregunta9'][value='" + respuesta["opt_509_pregunta9"] + "']").prop("checked", true);
			$("input[name='509_edit_txtPregunta10'][value='" + respuesta["opt_509_pregunta10"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta11'][value='" + respuesta["opt_509_pregunta11"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta12'][value='" + respuesta["opt_509_pregunta12"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta13'][value='" + respuesta["opt_509_pregunta13"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta14'][value='" + respuesta["opt_509_pregunta14"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta15'][value='" + respuesta["opt_509_pregunta15"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta16'][value='" + respuesta["opt_509_pregunta16"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta17'][value='" + respuesta["opt_509_pregunta17"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta18'][value='" + respuesta["opt_509_pregunta18"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta19'][value='" + respuesta["opt_509_pregunta19"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta20'][value='" + respuesta["opt_509_pregunta20"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta21'][value='" + respuesta["opt_509_pregunta21"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta22'][value='" + respuesta["opt_509_pregunta22"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta23'][value='" + respuesta["opt_509_pregunta23"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta24'][value='" + respuesta["opt_509_pregunta24"] + "']").prop("checked", true); 
			$("input[name='509_edit_txtPregunta25'][value='" + respuesta["opt_509_pregunta25"] + "']").prop("checked", true); 
			$("textarea[name='509_edit_txtOtros']").val(respuesta["opt_509_otros"]);

			//511 TSG LIMA - PRIMAX
			$("input[name='511_edit_txtPregunta1'][value='" + respuesta["opt_511_pregunta1"] + "']").prop("checked", true);
			$("input[name='511_edit_txtPregunta2'][value='" + respuesta["opt_511_pregunta2"] + "']").prop("checked", true);
			$("input[name='511_edit_txtPregunta3'][value='" + respuesta["opt_511_pregunta3"] + "']").prop("checked", true);
			$("input[name='511_edit_txtPregunta4'][value='" + respuesta["opt_511_pregunta4"] + "']").prop("checked", true);
			$("input[name='511_edit_txtPregunta5'][value='" + respuesta["opt_511_pregunta5"] + "']").prop("checked", true);
			$("input[name='511_edit_txtPregunta6'][value='" + respuesta["opt_511_pregunta6"] + "']").prop("checked", true);
			$("input[name='511_edit_txtPregunta7'][value='" + respuesta["opt_511_pregunta7"] + "']").prop("checked", true);
			$("input[name='511_edit_txtPregunta8'][value='" + respuesta["opt_511_pregunta8"] + "']").prop("checked", true);
			$("input[name='511_edit_txtPregunta9'][value='" + respuesta["opt_511_pregunta9"] + "']").prop("checked", true);
			$("input[name='511_edit_txtPregunta10'][value='" + respuesta["opt_511_pregunta10"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta11'][value='" + respuesta["opt_511_pregunta11"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta12'][value='" + respuesta["opt_511_pregunta12"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta13'][value='" + respuesta["opt_511_pregunta13"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta14'][value='" + respuesta["opt_511_pregunta14"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta15'][value='" + respuesta["opt_511_pregunta15"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta16'][value='" + respuesta["opt_511_pregunta16"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta17'][value='" + respuesta["opt_511_pregunta17"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta18'][value='" + respuesta["opt_511_pregunta18"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta19'][value='" + respuesta["opt_511_pregunta19"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta20'][value='" + respuesta["opt_511_pregunta20"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta21'][value='" + respuesta["opt_511_pregunta21"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta22'][value='" + respuesta["opt_511_pregunta22"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta23'][value='" + respuesta["opt_511_pregunta23"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta24'][value='" + respuesta["opt_511_pregunta24"] + "']").prop("checked", true); 
			$("input[name='511_edit_txtPregunta25'][value='" + respuesta["opt_511_pregunta25"] + "']").prop("checked", true); 
			$("textarea[name='511_edit_txtOtros']").val(respuesta["opt_511_otros"]);


			var datosVehiculo = new FormData();
			datosVehiculo.append("idVehiculo", respuesta["opt_vehiculo_id"]);
			$.ajax({
			  url: "ajax/vehiculos.ajax.php",
			  method: "POST",
			  data: datosVehiculo,
			  cache: false,
			  contentType: false,
			  processData: false,
			  dataType: "json",
			  success: function (respuesta) {
				$("#inputEditarPlaca").val(respuesta["vehic_id"]).trigger('change');
			  },
			});
			
			$("#inputEditarCliente").val(respuesta["opt_cliente"]);
			$("#inputEditarLugar").val(respuesta["opt_lugar"]);
			$("#inputEditarFecha").val(respuesta["opt_fecha"]);
			$("#inputEditarObservado").val(respuesta["opt_observado"]);
			$("#inputEditarObservador").val(respuesta["opt_observador"]);
			$("#inputEditarBuenasPracticas").val(respuesta["opt_bps_encontrada"]);		
			$("#inputEditarDescripcionObservacion").val(respuesta["opt_decripcion_observacion"]);
			$("#inputEditarDescripcionAdicional").val(respuesta["opt_decripcion_adicional"]);
			$("#inputEditarTipoHallazgo").val(respuesta["opt_tipo_hallazgo"]);
			$("#inputEditarRelacionado").val(respuesta["opt_relacionado"]);
			$("#inputEditarCorreccion").val(respuesta["opt_correccion"]);		

			$("#fotoActual1").val(respuesta["opt_evidencia1"]); 
			if (respuesta["opt_evidencia1"] != "") {
				$(".previsualizar1").attr("src",respuesta["opt_evidencia1"]);				
			} 	

			$("#fotoActual2").val(respuesta["opt_evidencia2"]); 
			if (respuesta["opt_evidencia2"] != "") {
				$(".previsualizar2").attr("src",respuesta["opt_evidencia2"]);				
			} 	
			
			$("#inputEditarIdOpt").val(respuesta["opt_id"]);
			 
			//$("#inputEditarUser").val(respuesta["opt_id_usuario"]); 
		},
	});
});

/*=============================================
ELIMINAR OPT
=============================================*/ 
$(document).on("click", ".btnEliminarOpt", function () {
	var idOpt = $(this).attr("idOpt");
	var nombreOpt = $(this).attr("nombreOpt");

	swal({
		title: "Esta seguro de eliminar la OPT?",
		text: "Esta accion enviara el registro a la papelera (eliminacion logica).",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		cancelButtonText: "Cancelar",
		confirmButtonText: "Si, enviar a papelera",
	}).then(function (result) {
		if (result.value) {
			window.location = "index.php?ruta=sig-opt&idOpt=" + idOpt;
		}
	});
});

$(document).on("click", ".btnRestaurarOpt", function () {
	var idOpt = $(this).attr("idOpt");
	var nombreOpt = $(this).attr("nombreOpt");

	swal({
		title: "Restaurar OPT?",
		text: 'El registro "' + nombreOpt + '" volvera al listado principal.',
		type: "question",
		showCancelButton: true,
		confirmButtonColor: "#28a745",
		cancelButtonColor: "#6c757d",
		cancelButtonText: "Cancelar",
		confirmButtonText: "Si, restaurar"
	}).then(function (result) {
		if (result.value) {
			$.ajax({
				url: "ajax/opts.ajax.php",
				method: "POST",
				data: { restaurarOptId: idOpt },
				dataType: "json",
				success: function (respuesta) {
					if (respuesta && respuesta.status === "ok") {
						swal({
							title: "Restaurado",
							text: "El registro fue restaurado correctamente.",
							type: "success",
							confirmButtonText: "Cerrar"
						}).then(function (r) {
							if (r.value) {
								window.location = "sig-opt";
							}
						});
					} else {
						swal({
							title: "Error",
							text: respuesta && respuesta.message ? respuesta.message : "No se pudo restaurar el registro",
							type: "error",
							confirmButtonText: "Cerrar"
						});
					}
				},
				error: function () {
					swal({
						title: "Error",
						text: "No se pudo conectar para restaurar el registro.",
						type: "error",
						confirmButtonText: "Cerrar"
					});
				}
			});
		}
	});
});

$(document).on("click", ".btnDepurarOpt", function () {
	var idOpt = $(this).attr("idOpt");
	var nombreOpt = $(this).attr("nombreOpt");

	swal({
		title: "ELIMINACION DEFINITIVA",
		html: '<strong>' + nombreOpt + '</strong> sera eliminado permanentemente.<br><br>Esta accion no se puede deshacer.',
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#dc3545",
		cancelButtonColor: "#6c757d",
		cancelButtonText: "Cancelar",
		confirmButtonText: "Si, eliminar para siempre"
	}).then(function (result) {
		if (result.value) {
			$.ajax({
				url: "ajax/opts.ajax.php",
				method: "POST",
				data: { depurarOptId: idOpt },
				dataType: "json",
				success: function (respuesta) {
					if (respuesta && respuesta.status === "ok") {
						swal({
							title: "Eliminado",
							text: "El registro fue eliminado definitivamente.",
							type: "success",
							confirmButtonText: "Cerrar"
						}).then(function (r) {
							if (r.value) {
								window.location = "sig-opt";
							}
						});
					} else {
						swal({
							title: "Error",
							text: respuesta && respuesta.message ? respuesta.message : "No se pudo eliminar el registro",
							type: "error",
							confirmButtonText: "Cerrar"
						});
					}
				},
				error: function () {
					swal({
						title: "Error",
						text: "No se pudo conectar para eliminar el registro.",
						type: "error",
						confirmButtonText: "Cerrar"
					});
				}
			});
		}
	});
});


/*=============================================
IMPRIMIR OPT
=============================================*/

$(".tablas").on("click", ".btnImprimirOpt", function () {
	var codigoOpt = $(this).attr("codigoOpt");
  
	//window.open("extensiones/tcpdf/pdf/factura.php?codigo="+codigoVenta, "_blank");
	window.open("vistas/report/opt.php?codigo=" + codigoOpt, "_blank");
	//window.open("lib/fpdf/factura.php", "_blank");
	//window.open("vistas/modulos/factura.php", "_blank");
  });
  