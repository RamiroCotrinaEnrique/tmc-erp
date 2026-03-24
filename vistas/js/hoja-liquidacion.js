/*=============================================
CALCULO INMEDIATO DE TOTALES
=============================================*/
function toNumber(value){
    var number = parseFloat(value);
    return isNaN(number) ? 0 : number;
}

function calcularTotalesLiquidacion(isEdit){
    var prefix = isEdit ? '#inputEdit' : '#input';

    var montoRecibido = toNumber($(prefix + 'MontoRecibido').val());
    var peaje = toNumber($(prefix + 'Peaje').val());
    var boletasVarias = toNumber($(prefix + 'BoletasVarias').val());
    var boletasConsumo = toNumber($(prefix + 'BoletasConsumo').val());
    var planillaMovilidad = toNumber($(prefix + 'PlanillaMovilidad').val());
    var facturasVarios = toNumber($(prefix + 'FacturasVarios').val());
    var cargaDescargaLadrillo = toNumber($(prefix + 'CargaDescargaLadrillo').val());

    var sumaTotal = peaje + boletasVarias + boletasConsumo + planillaMovilidad + facturasVarios + cargaDescargaLadrillo;
    var diferencia = montoRecibido - sumaTotal;

    var vuelto = 0;
    var reintegro = 0;

    if (diferencia >= 0) {
        vuelto = diferencia;
    } else {
        reintegro = Math.abs(diferencia);
    }

    $(prefix + 'SumaTotal').val(sumaTotal.toFixed(2));
    $(prefix + 'Vuelto').val(vuelto.toFixed(2));
    $(prefix + 'Reintegro').val(reintegro.toFixed(2));
}

var camposCalculoCrear = [
    '#inputMontoRecibido',
    '#inputPeaje',
    '#inputBoletasVarias',
    '#inputBoletasConsumo',
    '#inputPlanillaMovilidad',
    '#inputFacturasVarios',
    '#inputCargaDescargaLadrillo'
];

var camposCalculoEditar = [
    '#inputEditMontoRecibido',
    '#inputEditPeaje',
    '#inputEditBoletasVarias',
    '#inputEditBoletasConsumo',
    '#inputEditPlanillaMovilidad',
    '#inputEditFacturasVarios',
    '#inputEditCargaDescargaLadrillo'
];

camposCalculoCrear.forEach(function(selector){
    $(document).on('input change', selector, function(){
        calcularTotalesLiquidacion(false);
    });
});

camposCalculoEditar.forEach(function(selector){
    $(document).on('input change', selector, function(){
        calcularTotalesLiquidacion(true);
    });
});

calcularTotalesLiquidacion(false);

/*=============================================
IMPRIMIR HOJA DE LIQUIDACION
=============================================*/
$('.tablas').on('click', '.btnImprimirHojaLiquidacion', function(){

    var idHojaLiquidacion = $(this).attr('idHojaLiquidacion');

    if(!idHojaLiquidacion){
        return;
    }

    window.open('vistas/report/hoja-liquidacion.php?codigo=' + idHojaLiquidacion, '_blank');
});

/*=============================================
EDITAR HOJA DE LIQUIDACION
=============================================*/
$('.tablas').on('click', '.btnEditarHojaLiquidacion', function(){

    var idHojaLiquidacion = $(this).attr('idHojaLiquidacion');
    var datos = new FormData();
    datos.append('idHojaLiquidacion', idHojaLiquidacion);

    $.ajax({
        url: 'ajax/hojaliquidacion.ajax.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(respuesta){
            if(!respuesta){
                return;
            }

            $('#inputEditId').val(respuesta['hoja_id']);
            $('#inputEditNumeroRegistro').val(respuesta['hoja_numero_registro']);
            $('#inputEditFechaSalida').val(respuesta['hoja_fecha_salida']);
            $('#inputEditFechaLlegada').val(respuesta['hoja_fecha_llegada']);
            $('#inputEditPlaca').val(respuesta['hoja_vehic_tracto_id']);
            $('#inputEditTolva').val(respuesta['hoja_vehic_tolva_id']);
            $('#inputEditOperacion').val(respuesta['hoja_operacion']);
            $('#inputEditMontoRecibido').val(respuesta['hoja_monto_recibido']);
            $('#inputEditEmpleado').val(respuesta['hoja_empleado_id']);
            $('#inputEditGRRProducto').val(respuesta['hoja_grr_producto']);
            $('#inputEditProducto').val(respuesta['hoja_producto']);
            $('#inputEditGRRServicioAdicional').val(respuesta['hoja_grr_servicio_adicional']);
            $('#inputEditSerAdicional').val(respuesta['hoja_servicio_adicional']);
            $('#inputEditGRTransportista').val(respuesta['hoja_gr_transportista']);
            $('#inputEditPeaje').val(respuesta['hoja_peaje']);
            $('#inputEditBoletasVarias').val(respuesta['hoja_boletas_varias']);
            $('#inputEditBoletasConsumo').val(respuesta['hoja_boletas_consumo']);
            $('#inputEditPlanillaMovilidad').val(respuesta['hoja_planilla_movilidad']);
            $('#inputEditFacturasVarios').val(respuesta['hoja_facturas_varios']);
            $('#inputEditCargaDescargaLadrillo').val(respuesta['hoja_carga_descarga_ladrillo']);
            $('#inputEditReintegro').val(respuesta['hoja_reintegro']);
            $('#inputEditVuelto').val(respuesta['hoja_vuelto']);
            $('#inputEditSumaTotal').val(respuesta['hoja_suma_total']);
            $('#inputEditObservaciones').val(respuesta['hoja_observaciones']);
            $('#inputEditKMSalida').val(respuesta['hoja_km_salida']);
            $('#inputEditKMLlegada').val(respuesta['hoja_km_llegada']);
            $('#inputEditCVGrifo').val(respuesta['hoja_cv_grifo']);
            $('#inputEditCVEQ').val(respuesta['hoja_cv_eq']);
            $('#inputEditTotalKM').val(respuesta['hoja_total_km']);
            $('#inputEditVariacion').val(respuesta['hoja_variacion']);

            var selects = ['#inputEditPlaca', '#inputEditTolva', '#inputEditOperacion', '#inputEditEmpleado'];
            selects.forEach(function(selector){
                if($(selector).hasClass('select2-hidden-accessible')){
                    $(selector).trigger('change.select2');
                }
            });

            calcularTotalesLiquidacion(true);
        }
    });
});

/*=============================================
ELIMINAR HOJA DE LIQUIDACION
=============================================*/
$('.tablas').on('click', '.btnEliminarHojaLiquidacion', function(){

    var idHojaLiquidacion = $(this).attr('idHojaLiquidacion');

    swal({
        title: '¿Está seguro de eliminar el registro?',
        text: 'El registro no se borrará físicamente. Primero será enviado a la papelera.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, enviar a papelera'
    }).then(function(result){
        if(result.value){
            window.location = 'index.php?ruta=hoja-liquidacion&idHojaLiquidacion=' + idHojaLiquidacion;
        }
    });
});

/*=============================================
RESTAURAR HOJA DE LIQUIDACION
=============================================*/
$(document).on('click', '.btnRestaurarHojaLiquidacion', function(){

    var idHojaLiquidacion = $(this).attr('idHojaLiquidacion');
    var nombreRegistro = $(this).attr('nombreRegistro');

    swal({
        title: '¿Restaurar registro?',
        text: 'El registro "' + nombreRegistro + '" volverá al listado principal.',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, restaurar'
    }).then(function(result){
        if(result.value){
            var datos = new FormData();
            datos.append('restaurarHojaLiquidacionId', idHojaLiquidacion);

            $.ajax({
                url: 'ajax/hojaliquidacion.ajax.php',
                method: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(respuesta){
                    if(respuesta && respuesta.status === 'ok'){
                        swal({
                            title: 'Restaurado',
                            text: 'El registro fue restaurado correctamente.',
                            type: 'success',
                            confirmButtonText: 'Cerrar'
                        }).then(function(r){ if(r.value){ window.location = 'hoja-liquidacion'; } });
                    }else{
                        swal({
                            title: 'Error',
                            text: (respuesta && respuesta.message) ? respuesta.message : 'No se pudo restaurar el registro',
                            type: 'error',
                            confirmButtonText: 'Cerrar'
                        });
                    }
                }
            });
        }
    });
});

/*=============================================
DEPURAR HOJA DE LIQUIDACION
=============================================*/
$(document).on('click', '.btnDepurarHojaLiquidacion', function(){

    var idHojaLiquidacion = $(this).attr('idHojaLiquidacion');
    var nombreRegistro = $(this).attr('nombreRegistro');

    swal({
        title: 'ELIMINACIÓN DEFINITIVA',
        html: '<strong>' + nombreRegistro + '</strong> será eliminado permanentemente de la base de datos.<br><br>Esta acción no se puede deshacer.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, eliminar para siempre'
    }).then(function(result){
        if(result.value){
            var datos = new FormData();
            datos.append('depurarHojaLiquidacionId', idHojaLiquidacion);

            $.ajax({
                url: 'ajax/hojaliquidacion.ajax.php',
                method: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(respuesta){
                    if(respuesta && respuesta.status === 'ok'){
                        swal({
                            title: 'Eliminado',
                            text: 'El registro fue eliminado definitivamente.',
                            type: 'success',
                            confirmButtonText: 'Cerrar'
                        }).then(function(r){ if(r.value){ window.location = 'hoja-liquidacion'; } });
                    }else{
                        swal({
                            title: 'Error',
                            text: (respuesta && respuesta.message) ? respuesta.message : 'No se pudo eliminar el registro',
                            type: 'error',
                            confirmButtonText: 'Cerrar'
                        });
                    }
                }
            });
        }
    });
});
