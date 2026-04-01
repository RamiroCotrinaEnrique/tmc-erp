//-- Page specific script -->
$(document).ready(function () {
  $("#example1").DataTable({
    language: {
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      infoFiltered: "(filtrado de un total de _MAX_ registros)",
      sSearch: "Buscar:",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      sProcessing: "Procesando...",
    },
    //para usar los botones
    responsive: "true",
    dom: "Bfrtilp",
    buttons: [
      {
        extend: "copy",
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Copiar',
        titleAttr: "Copiar",
        className: "btn btn-dark",
      },
      {
        extend: "excelHtml5",
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: "Exportar a Excel",
        className: "btn btn-success",
      },
      {
        extend: "pdfHtml5",
        text: '<i class="fas fa-file-pdf"></i> PDF',
        titleAttr: "Exportar a PDF",
        className: "btn btn-danger",
      },
      {
        extend: "csv",
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> CSV',
        titleAttr: "Exportar a CSV",
        className: "btn btn-success",
      },
      {
        extend: "print",
        text: '<i class="fa fa-print"></i> Imprimir',
        titleAttr: "Imprimir",
        className: "btn btn-info",
      },
      {
        extend: "colvis",
        text: '<i class="fa fa-compress"></i> Visibilidad',
        titleAttr: "Visibilidad",
        className: "btn btn-light",
      },
    ],
  });
});


//Initialize Select2 Elements

$(".select2").select2();
//Initialize Select2 Elements
$(".select2bs4").select2({
  theme: "bootstrap4",
});

// Reinitialize Select2 controls inside any Bootstrap modal so search input can receive focus.
$(document).on("shown.bs.modal", ".modal", function () {
  var $modal = $(this);

  $modal.find("select.select2").each(function () {
    var $select = $(this);
    if ($select.hasClass("select2-hidden-accessible")) {
      $select.select2("destroy");
    }
    $select.select2({
      dropdownParent: $modal,
    });
  });

  $modal.find("select.select2bs4").each(function () {
    var $select = $(this);
    if ($select.hasClass("select2-hidden-accessible")) {
      $select.select2("destroy");
    }
    $select.select2({
      theme: "bootstrap4",
      dropdownParent: $modal,
    });
  });
});

//Date picker
$("#reservationdate").datetimepicker({
  //format: 'L'
  format: "YYYY-MM-DD",
});


//Date picker - Movimiento de caja
$("#fechaNacimienntoDatePicker").datetimepicker({
  format: "DD/MM/YYYY",
  locale: "es",
});

//Date picker - Movimiento de caja
$("#fechaDatePicker").datetimepicker({
  format: "DD/MM/YYYY",
  locale: "es",
});

//Date and time picker
$("#reservationdatetime").datetimepicker({ icons: { time: "far fa-clock" } });

//Date range picker
$("#reservation").daterangepicker();
//Date range picker with time picker
$("#reservationtime").daterangepicker({
  timePicker: true,
  timePickerIncrement: 30,
  locale: {
    format: "MM/DD/YYYY hh:mm A",
  },
});

/*=============================================
 //iCheck for checkbox and radio inputs
=============================================*/

$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
  checkboxClass: 'icheckbox_minimal-blue',
  radioClass   : 'iradio_minimal-blue'
})

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'yyyy/mm/dd' })
    $('#datemask2').inputmask('yyyy/mm/dd', { 'placeholder': 'yyyy/mm/dd' })
    //Datemask2 mm/dd/yyyy
    //$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

// =========================
// DataTables - Responsive y Textos en Español
// =========================

$(document).ready(function () {
    
    // Esta sección inicializa y mantiene responsivas las tablas:
    // - Papelera 
    // - Auditoría  
    if (!$.fn.DataTable) {
        return;
    }

    // Textos de DataTables en español.
    var idiomaDataTable = {
        lengthMenu: "Mostrar _MENU_ registros",
        zeroRecords: "No se encontraron resultados",
        info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        infoFiltered: "(filtrado de un total de _MAX_ registros)",
        sSearch: "Buscar:",
        oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior"
        },
        sProcessing: "Procesando..."
    };

    // Recalcula anchos y responsive cuando una tabla cambia de visibilidad.
    function recalcularTablasVisibles() {
        if (!$.fn.dataTable) {
            return;
        }

        var apiTablas = $.fn.dataTable.tables({ visible: true, api: true });
        if (apiTablas && typeof apiTablas.columns === "function") {
            apiTablas.columns.adjust();
            if (apiTablas.responsive && typeof apiTablas.responsive.recalc === "function") {
                apiTablas.responsive.recalc();
            }
        }
    }

    // Inicializa una tabla con comportamiento responsive por columna.
    function inicializarTablaExpandible(selector) {
        var $tabla = $(selector);

        if (!$tabla.length || $.fn.DataTable.isDataTable($tabla)) {
            return;
        }

        // Evita errores _DT_CellIndex cuando exista una fila placeholder con colspan.
        $tabla.find("tbody tr").each(function () {
            var $celdas = $(this).children("td, th");
            if ($celdas.length === 1) {
                var colspan = parseInt($celdas.eq(0).attr("colspan") || "1", 10);
                if (colspan > 1) {
                    $(this).remove();
                }
            }
        });

        $tabla.addClass("nowrap");

        // Configuración enfocada en autoajuste y expansión en móviles.
        $tabla.DataTable({
            language: idiomaDataTable,
            responsive: {
                details: {
                    type: "column",
                    target: 0
                }
            },
            autoWidth: false,
            dom: "frtip",
            columnDefs: [
                {
                    className: "dtr-control",
                    orderable: false,
                    targets: 0
                },
                {
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 2,
                    targets: -1
                }
            ]
        });
    }

    // Inicialización de tablas del módulo Empleados.
    inicializarTablaExpandible("#tablaPapeleraEmpleados");
    inicializarTablaExpandible("#tablaAuditoriaEmpleados");

    // Inicialización de tablas del módulo Áreas.
    inicializarTablaExpandible("#tablaPapeleraAreas");
    inicializarTablaExpandible("#tablaAuditoriaAreas");

    // Inicialización de tablas del módulo Cargos.
    inicializarTablaExpandible("#tablaPapeleraCargos");
    inicializarTablaExpandible("#tablaAuditoriaCargos");

    // Inicialización de tablas del módulo Centro de Costo.
    inicializarTablaExpandible("#tablaPapeleraCentroCosto");
    inicializarTablaExpandible("#tablaAuditoriaCentroCostos");

    // Inicialización de tablas del módulo Empresas.
    inicializarTablaExpandible("#tablaPapeleraEmpresas");
    inicializarTablaExpandible("#tablaAuditoriaEmpresas");

    // Inicialización de tablas del módulo Movimiento de Caja.
    inicializarTablaExpandible("#tablaPapeleraHojaLiquidacion");
    inicializarTablaExpandible("#tablaAuditoriaHojaLiquidacion");

    // Inicialización de tablas del módulo Movimiento de Caja.
    inicializarTablaExpandible("#tablaPapeleraMovimientos");
    inicializarTablaExpandible("#tablaAuditoriaMovimientoCaja");

     // Inicialización de tablas del módulo Opt.
    inicializarTablaExpandible("#tablaPapeleraOpt");
    inicializarTablaExpandible("#tablaAuditoriaOpts");

     // Inicialización de tablas del módulo Usuarios.
    inicializarTablaExpandible("#tablaPapelera");

    // Cuando se expande/colapsa un card, DataTables debe recalcular columnas.
    $(document).on("click", '[data-card-widget="collapse"]', function () {
        setTimeout(function () {
            recalcularTablasVisibles();
        }, 350);
    });
});