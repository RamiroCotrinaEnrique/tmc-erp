$(document).ready(function () {
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

  function inicializarTablaExpandible(selector, conBotones) {
    if (!$.fn.DataTable) {
      return;
    }

    var $tabla = $(selector);
    if (!$tabla.length || $.fn.DataTable.isDataTable($tabla)) {
      return;
    }

    // DataTables no soporta filas de datos con colspan en tbody.
    // Si existen placeholders de "sin datos", se eliminan para evitar _DT_CellIndex.
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

    var configuracion = {
      language: idiomaDataTable,
      responsive: {
        details: {
          type: "column",
          target: 0
        }
      },
      autoWidth: false,
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
      ],
      dom: conBotones ? "Bfrtilp" : "frtip"
    };

    if (conBotones) {
      configuracion.buttons = [
        {
          extend: "copy",
          text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Copiar',
          titleAttr: "Copiar",
          className: "btn btn-dark"
        },
        {
          extend: "excelHtml5",
          text: '<i class="fas fa-file-excel"></i> Excel',
          titleAttr: "Exportar a Excel",
          className: "btn btn-success"
        },
        {
          extend: "pdfHtml5",
          text: '<i class="fas fa-file-pdf"></i> PDF',
          titleAttr: "Exportar a PDF",
          className: "btn btn-danger"
        },
        {
          extend: "csv",
          text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> CSV',
          titleAttr: "Exportar a CSV",
          className: "btn btn-success"
        },
        {
          extend: "print",
          text: '<i class="fa fa-print"></i> Imprimir',
          titleAttr: "Imprimir",
          className: "btn btn-info"
        },
        {
          extend: "colvis",
          text: '<i class="fa fa-compress"></i> Visibilidad',
          titleAttr: "Visibilidad",
          className: "btn btn-light"
        }
      ];
    }

    $tabla.DataTable(configuracion);
  }

  function inicializarTablasPorSerie() {
    if (!$.fn.DataTable) {
      return;
    }

    $(".tablaMovimientoSerie").each(function () {
      var $tabla = $(this);

      if ($.fn.DataTable.isDataTable($tabla)) {
        return;
      }

      inicializarTablaExpandible($tabla, true);
    });

    $('a[data-toggle="tab"][href^="#serie-panel-"]').on("shown.bs.tab", function () {
      recalcularTablasVisibles();
    });
  }

  inicializarTablasPorSerie();
  inicializarTablaExpandible("#tablaPapeleraMovimientos", false);
  inicializarTablaExpandible("#tablaAuditoriaMovimientoCaja", false);

  $(document).on("click", '[data-card-widget="collapse"]', function () {
    setTimeout(function () {
      recalcularTablasVisibles();
    }, 350);
  });

  var $tablaDetalle = $("#detalleMovimiento");
  var $btnAgregarDetalle = $("#btnAgregarDetalle");
  var $totalDetalleReferencial = $("#totalDetalleReferencial");
  var $formMovimiento = $("#formAgregarMovimientoCaja");
  var $inputTipo = $("#inputTipo");
  var $inputSerie = $("#inputSerie");
  var $inputMoneda = $("#inputMoneda");
  var $inputEmpleado = $("#inputEmpleado");
  var $formEditarMovimiento = $("#formEditarMovimientoCaja");
  var $inputEditId = $("#inputEditId");
  var $inputEditTipo = $("#inputEditTipo");
  var $inputEditMoneda = $("#inputEditMoneda");
  var $inputEditSerie = $("#inputEditSerie");
  var $inputEditEmpleado = $("#inputEditEmpleado");
  var $inputEditFecha = $("#inputEditFecha");
  var $inputEditNumero = $("#inputEditNumero");
  var $inputEditTotal = $("#inputEditTotal");
  var $btnAgregarDetalleEdit = $("#btnAgregarDetalleEdit");
  var $tablaDetalleEdit = $("#detalleMovimientoEdit");

  if (!$tablaDetalle.length || !$btnAgregarDetalle.length) {
    return;
  }

  function parseImporte(valor) {
    if (!valor) return 0;
    var normalizado = String(valor).replace(",", ".");
    var numero = parseFloat(normalizado);
    return Number.isNaN(numero) ? 0 : numero;
  }

  function actualizarDetalle() {
    var total = 0;

    $tablaDetalle.find("tr").each(function (index) {
      $(this).find(".input-detalle-item").val(index + 1);
      total += parseImporte($(this).find(".input-detalle-importe").val());
    });

    if ($totalDetalleReferencial.length) {
      $totalDetalleReferencial.val(total.toFixed(2));
    }
  }

  function agregarFilaDetalle() {
    var fila = [
      '<tr>',
      '  <td style="width: 90px;">',
      '    <input type="text" class="form-control form-control-sm input-detalle-item" name="detalle_item[]" readonly>',
      '  </td>',
      '  <td>',
      '    <input type="text" class="form-control form-control-sm" name="detalle_descripcion[]" placeholder="Ingrese descripción" required>',
      '  </td>',
      '  <td style="width: 180px;">',
      '    <input type="number" class="form-control form-control-sm input-detalle-importe" name="detalle_importe[]" min="0" step="0.01" placeholder="0.00" required>',
      '  </td>',
      '  <td style="width: 80px;" class="text-center">',
      '    <button type="button" class="btn btn-danger btn-sm btnEliminarDetalle">Eliminar</button>',
      '  </td>',
      '</tr>'
    ].join("\n");

    $tablaDetalle.append(fila);
    actualizarDetalle();
  }

  function actualizarDetalleEdit() {
    var total = 0;

    $tablaDetalleEdit.find("tr").each(function (index) {
      $(this).find(".input-edit-detalle-item").val(index + 1);
      total += parseImporte($(this).find(".input-edit-detalle-importe").val());
    });

    $inputEditTotal.val(total.toFixed(2));
  }

  function agregarFilaDetalleEdit(descripcion, importe) {
    var fila = [
      '<tr>',
      '  <td style="width: 90px;">',
      '    <input type="text" class="form-control form-control-sm input-edit-detalle-item" name="inputEditDetalleItem[]" readonly>',
      '  </td>',
      '  <td>',
      '    <input type="text" class="form-control form-control-sm" name="inputEditDetalleDescripcion[]" placeholder="Ingrese descripcion" required>',
      '  </td>',
      '  <td style="width: 180px;">',
      '    <input type="number" class="form-control form-control-sm input-edit-detalle-importe" name="inputEditDetalleImporte[]" min="0" step="0.01" placeholder="0.00" required>',
      '  </td>',
      '  <td style="width: 80px;" class="text-center">',
      '    <button type="button" class="btn btn-danger btn-sm btnEliminarDetalleEdit">Eliminar</button>',
      '  </td>',
      '</tr>'
    ].join("\n");

    $tablaDetalleEdit.append(fila);

    var $ultimaFila = $tablaDetalleEdit.find("tr:last");
    if (typeof descripcion !== "undefined") {
      $ultimaFila.find('input[name="inputEditDetalleDescripcion[]"]').val(descripcion);
    }
    if (typeof importe !== "undefined") {
      $ultimaFila.find('input[name="inputEditDetalleImporte[]"]').val(parseFloat(importe).toFixed(2));
    }

    actualizarDetalleEdit();
  }

  function resetSeries(mensaje) {
    var texto = mensaje || "Seleccione...";
    $inputSerie.html('<option value="">' + texto + "</option>");
  }

  function cargarSeriesEnSelect(tipo, moneda, $select, serieSeleccionada) {
    if (!tipo || !moneda) {
      $select.html('<option value="">Seleccione...</option>');
      return;
    }

    $select.html('<option value="">Cargando...</option>');

    var datos = new FormData();
    datos.append("listarSeries", "1");
    datos.append("tipo", tipo);
    datos.append("moneda", moneda);

    $.ajax({
      url: "ajax/movimientocaja.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        if (!Array.isArray(respuesta) || respuesta.length === 0) {
          $select.html('<option value="">Sin series configuradas</option>');
          return;
        }

        var options = ['<option value="">Seleccione...</option>'];

        respuesta.forEach(function (item) {
          if (item && item.conf_seri_serie) {
            var selected = serieSeleccionada && item.conf_seri_serie === serieSeleccionada ? ' selected' : "";
            options.push(
              '<option value="' + item.conf_seri_serie + '"' + selected + '>' + item.conf_seri_serie + "</option>"
            );
          }
        });

        $select.html(options.join(""));
      },
      error: function () {
        $select.html('<option value="">Error al cargar</option>');
      }
    });
  }

  function cargarSeriesConfiguradas() {
    var tipo = ($inputTipo.val() || "").trim();
    var moneda = ($inputMoneda.val() || "").trim();

    if (!tipo || !moneda) {
      resetSeries("Seleccione...");
      return;
    }

    cargarSeriesEnSelect(tipo, moneda, $inputSerie, "");
  }

  $btnAgregarDetalle.on("click", function (e) {
    e.preventDefault();
    agregarFilaDetalle();
  });

  $btnAgregarDetalleEdit.on("click", function (e) {
    e.preventDefault();
    agregarFilaDetalleEdit("", "");
  });

  $inputTipo.on("change", cargarSeriesConfiguradas);
  $inputMoneda.on("change", cargarSeriesConfiguradas);
  $(document).on("click", ".btnEditarMovimientoCaja", function () {
    var idMovimientoCaja = $(this).attr("idMovimientoCaja");
    var datos = new FormData();

    datos.append("idMovimientoCaja", idMovimientoCaja);

    $.ajax({
      url: "ajax/movimientocaja.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        if (!respuesta || !respuesta.movi_id) {
          swal({
            type: "error",
            title: "No se pudo cargar el movimiento seleccionado.",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
          });
          return;
        }

        $inputEditId.val(respuesta.movi_id);
        $inputEditTipo.val(respuesta.movi_tipo);
        $inputEditMoneda.val(respuesta.movi_moneda);
        $inputEditFecha.val(respuesta.movi_fecha);
        $inputEditNumero.val(respuesta.movi_numero);
        $inputEditTotal.val(respuesta.movi_total);
        $inputEditEmpleado.val(respuesta.movi_emple_id).trigger("change");

        $inputEditSerie.val((respuesta.movi_serie || "").trim());

        $tablaDetalleEdit.html("");

        var datosDetalle = new FormData();
        datosDetalle.append("idMovimientoCajaDetalle", respuesta.movi_id);

        $.ajax({
          url: "ajax/movimientocaja.ajax.php",
          method: "POST",
          data: datosDetalle,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (detalles) {
            if (Array.isArray(detalles) && detalles.length > 0) {
              detalles.forEach(function (detalle) {
                agregarFilaDetalleEdit(detalle.deta_movi_descripcion, detalle.deta_movi_importe);
              });
            } else {
              agregarFilaDetalleEdit("", "");
            }
          },
          error: function () {
            agregarFilaDetalleEdit("", "");
          }
        });
      },
      error: function () {
        swal({
          type: "error",
          title: "Error al cargar datos del movimiento.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        });
      }
    });
  });

  $(".tablas").on("click", ".btnEliminarMovimientoCaja", function () {
    var idMovimientoCaja = $(this).attr("idMovimientoCaja");

    swal({
      title: "Esta seguro de eliminar el movimiento?",
      text: "Esta accion enviara el movimiento a la papelera (eliminacion logica).",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, enviar a papelera"
    }).then(function (result) {
      if (result.value) {
        window.location = "index.php?ruta=movimiento-caja&idMovimientoCaja=" + idMovimientoCaja;
      }
    });
  });

  $(document).on("click", ".btnRestaurarMovimientoCaja", function () {
    var idMovimientoCaja = $(this).attr("idMovimientoCaja");
    var nombreMovimiento = $(this).attr("nombreMovimiento");

    swal({
      title: "Restaurar movimiento?",
      text: 'El movimiento "' + nombreMovimiento + '" volvera al listado principal.',
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#6c757d",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, restaurar"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: "ajax/movimientocaja.ajax.php",
          method: "POST",
          data: { restaurarMovimientoCajaId: idMovimientoCaja },
          dataType: "json",
          success: function (respuesta) {
            if (respuesta && respuesta.status === "ok") {
              swal({
                title: "Restaurado",
                text: "El movimiento fue restaurado correctamente.",
                type: "success",
                confirmButtonText: "Cerrar"
              }).then(function (r) {
                if (r.value) {
                  window.location = "movimiento-caja";
                }
              });
            } else {
              swal({
                title: "Error",
                text: respuesta && respuesta.message ? respuesta.message : "No se pudo restaurar el movimiento",
                type: "error",
                confirmButtonText: "Cerrar"
              });
            }
          },
          error: function () {
            swal({
              title: "Error",
              text: "No se pudo conectar para restaurar el movimiento.",
              type: "error",
              confirmButtonText: "Cerrar"
            });
          }
        });
      }
    });
  });

  $(document).on("click", ".btnDepurarMovimientoCaja", function () {
    var idMovimientoCaja = $(this).attr("idMovimientoCaja");
    var nombreMovimiento = $(this).attr("nombreMovimiento");

    swal({
      title: "ELIMINACION DEFINITIVA",
      html: '<strong>' + nombreMovimiento + '</strong> sera eliminado permanentemente de la base de datos.<br><br>Esta accion no se puede deshacer.',
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#dc3545",
      cancelButtonColor: "#6c757d",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, eliminar para siempre"
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          url: "ajax/movimientocaja.ajax.php",
          method: "POST",
          data: { depurarMovimientoCajaId: idMovimientoCaja },
          dataType: "json",
          success: function (respuesta) {
            if (respuesta && respuesta.status === "ok") {
              swal({
                title: "Eliminado",
                text: "El movimiento fue eliminado definitivamente.",
                type: "success",
                confirmButtonText: "Cerrar"
              }).then(function (r) {
                if (r.value) {
                  window.location = "movimiento-caja";
                }
              });
            } else {
              swal({
                title: "Error",
                text: respuesta && respuesta.message ? respuesta.message : "No se pudo eliminar el movimiento",
                type: "error",
                confirmButtonText: "Cerrar"
              });
            }
          },
          error: function () {
            swal({
              title: "Error",
              text: "No se pudo conectar para eliminar el movimiento.",
              type: "error",
              confirmButtonText: "Cerrar"
            });
          }
        });
      }
    });
  });

  $tablaDetalle.on("input", ".input-detalle-importe", function () {
    actualizarDetalle();
  });

  $tablaDetalle.on("click", ".btnEliminarDetalle", function () {
    $(this).closest("tr").remove();
    actualizarDetalle();
  });

  $tablaDetalleEdit.on("input", ".input-edit-detalle-importe", function () {
    actualizarDetalleEdit();
  });

  $tablaDetalleEdit.on("click", ".btnEliminarDetalleEdit", function () {
    $(this).closest("tr").remove();
    actualizarDetalleEdit();
  });

  if ($formMovimiento.length) {
    $formMovimiento.on("submit", function (e) {
      var tipo = ($inputTipo.val() || "").trim();
      var serie = ($inputSerie.val() || "").trim();
      var moneda = ($inputMoneda.val() || "").trim();
      var empleado = ($inputEmpleado.val() || "").trim();
      var total = parseImporte($totalDetalleReferencial.val());
      var filas = $tablaDetalle.find("tr").length;
      var hayDetalleInvalido = false;

      $tablaDetalle.find("tr").each(function () {
        var descripcion = $(this).find('input[name="detalle_descripcion[]"]').val();
        var importe = parseImporte($(this).find('input[name="detalle_importe[]"]').val());

        if (!descripcion || !String(descripcion).trim() || importe <= 0) {
          hayDetalleInvalido = true;
          return false;
        }
      });

      if (!tipo || !serie || !moneda || !empleado) {
        e.preventDefault();
        swal({
          type: "error",
          title: "Complete tipo, serie, moneda y empleado.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        });
        return;
      }

      if ($inputSerie.find("option").length <= 1) {
        e.preventDefault();
        swal({
          type: "error",
          title: "No hay series configuradas para el tipo y moneda seleccionados.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        });
        return;
      }

      if (filas === 0) {
        e.preventDefault();
        swal({
          type: "error",
          title: "Debe agregar al menos un detalle.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        });
        return;
      }

      if (hayDetalleInvalido || total <= 0) {
        e.preventDefault();
        swal({
          type: "error",
          title: "Verifique el detalle: descripcion obligatoria e importe mayor a cero.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        });
      }
    });
  }

  if ($formEditarMovimiento.length) {
    $formEditarMovimiento.on("submit", function (e) {
      var id = ($inputEditId.val() || "").trim();
      var tipo = ($inputEditTipo.val() || "").trim();
      var moneda = ($inputEditMoneda.val() || "").trim();
      var serie = ($inputEditSerie.val() || "").trim();
      var fecha = ($inputEditFecha.val() || "").trim();
      var empleado = ($inputEditEmpleado.val() || "").trim();
      var filasDetalle = $tablaDetalleEdit.find("tr").length;
      var totalDetalleEdit = parseImporte($inputEditTotal.val());
      var hayDetalleInvalido = false;

      if (!id || !tipo || !moneda || !serie || !fecha || !empleado) {
        e.preventDefault();
        swal({
          type: "error",
          title: "Complete todos los campos obligatorios de edicion.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        });
        return;
      }

      $tablaDetalleEdit.find("tr").each(function () {
        var descripcion = $(this).find('input[name="inputEditDetalleDescripcion[]"]').val();
        var importe = parseImporte($(this).find('input[name="inputEditDetalleImporte[]"]').val());

        if (!descripcion || !String(descripcion).trim() || importe <= 0) {
          hayDetalleInvalido = true;
          return false;
        }
      });

      if (filasDetalle === 0) {
        e.preventDefault();
        swal({
          type: "error",
          title: "Debe agregar al menos un detalle en la edicion.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        });
        return;
      }

      if (hayDetalleInvalido || totalDetalleEdit <= 0) {
        e.preventDefault();
        swal({
          type: "error",
          title: "Verifique el detalle de edicion: descripcion obligatoria e importe mayor a cero.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        });
      }
    });
  }

  resetSeries("Seleccione...");
});

/*=============================================
IMPRIMIR MOVIMIENTO DE CAJA
=============================================*/

$(".tablas").on("click", ".btnImprimirMovimientoCaja", function () {
	var codigoMovimientoCaja = $(this).attr("idMovimientoCaja");
	window.open("vistas/report/report-caja.php?codigo=" + codigoMovimientoCaja, "_blank");
  });
  