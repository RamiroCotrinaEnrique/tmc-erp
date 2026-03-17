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

/*var table = new DataTable('#example1', {
  "responsive": true, "lengthChange": false, "autoWidth": false,
  //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"], 
  "buttons": ["Copiar", "PDF", "Imprimir", "Visibilidad"], 
  language: {
      url: '../vistas/plugins/datatables/es-ES.json',
  },
}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
*/
/*
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });*/


//Initialize Select2 Elements

$(".select2").select2();
//Initialize Select2 Elements
$(".select2bs4").select2({
  theme: "bootstrap4",
});

//Date picker
$("#reservationdate").datetimepicker({
  //format: 'L'
  format: "YYYY-MM-DD",
});


//Date picker
$("#editarFNacimiento").datetimepicker({
  //format: 'L'
  format: "YYYY-MM-DD",
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