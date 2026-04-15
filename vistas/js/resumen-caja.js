
(function () {
    var diasPorMes = {
        1: 31, 2: 29, 3: 31, 4: 30,
        5: 31, 6: 30, 7: 31, 8: 31,
        9: 30, 10: 31, 11: 30, 12: 31
    };

    var inputAnio = document.getElementById('inputAnioResumen');
    var selectMes = document.getElementById('selectMesNuevo');
    var inputDia = document.getElementById('inputDiaNuevo');
    var feedback = document.getElementById('feedbackDiaNuevo');
    var detalleCaja = document.getElementById('detalleCaja');
    var inputSaldoFondoFijo = document.getElementById('inputSaldoFondoFijo');
    var inputDniResumenCaja = document.getElementById('inputDniResumenCaja');
    var inputResponsableResumenCaja = document.getElementById('inputResponsableResumenCaja');
    var helpDniResumenCaja = document.getElementById('helpDniResumenCaja');
    var inputTotalIngresos = document.getElementById('inputTotalIngresos');
    var inputTotalGastos = document.getElementById('inputTotalGastos');
    var inputNuevoSaldo = document.getElementById('inputNuevoSaldo');
    var formAgregarResumenCaja = document.getElementById('formAgregarResumenCaja');
    var detalleResumenGuardado = document.getElementById('detalleResumenGuardado');
    var alertaEstadoCierre = document.getElementById('alertaEstadoCierre');
    var btnGuardarCierreCaja = document.getElementById('btnGuardarCierreCaja');

    var detallesActuales = [];
    var totalIngresos = 0;
    var totalEgresos = 0;
    var fechaYaCerrada = false;
    var timeoutBuscarDni = null;
    var ultimoDniConsultado = '';
    var nombreAutocompletadoPorDni = false;
    var timeoutMensajeDni = null;

    if (!selectMes || !inputDia || !feedback || !detalleCaja) {
        return;
    }

    function escaparHtml(valor) {
        return String(valor || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatearMonto(valor) {
        var numero = parseFloat(valor || 0);
        return isNaN(numero) ? '0.00' : numero.toFixed(2);
    }

    function actualizarSaldos() {
        var saldoFondo = parseFloat(inputSaldoFondoFijo && inputSaldoFondoFijo.value ? inputSaldoFondoFijo.value : 0);
        if (isNaN(saldoFondo)) {
            saldoFondo = 0;
        }

        var nuevoSaldo = saldoFondo + totalIngresos - totalEgresos;

        if (inputTotalIngresos) {
            inputTotalIngresos.value = formatearMonto(totalIngresos);
        }

        if (inputTotalGastos) {
            inputTotalGastos.value = formatearMonto(totalEgresos);
        }

        if (inputNuevoSaldo) {
            inputNuevoSaldo.value = formatearMonto(nuevoSaldo);
        }
    }

    function mostrarSinDatos(texto) {
        detallesActuales = [];
        totalIngresos = 0;
        totalEgresos = 0;
        detalleCaja.innerHTML = '<tr><td colspan="8" class="text-center text-muted">' + escaparHtml(texto) + '</td></tr>';
        actualizarSaldos();
    }

    function actualizarEstadoGuardado() {
        if (btnGuardarCierreCaja) {
            btnGuardarCierreCaja.disabled = fechaYaCerrada;
        }
    }

    function mostrarAlertaEstado(mensaje, tipo) {
        if (!alertaEstadoCierre) {
            return;
        }

        if (!mensaje) {
            alertaEstadoCierre.style.display = 'none';
            alertaEstadoCierre.className = 'alert mb-0';
            alertaEstadoCierre.textContent = '';
            return;
        }

        var clase = tipo === 'info' ? 'alert alert-info mb-0' : 'alert alert-warning mb-0';
        alertaEstadoCierre.className = clase;
        alertaEstadoCierre.textContent = mensaje;
        alertaEstadoCierre.style.display = 'block';
    }

    function aplicarEstadoFecha(estado) {
        fechaYaCerrada = !!(estado && estado.cerrado);
        actualizarEstadoGuardado();

        if (inputSaldoFondoFijo) {
            var saldoSugerido = estado && typeof estado.saldo_inicial_sugerido !== 'undefined'
                ? parseFloat(estado.saldo_inicial_sugerido)
                : 0;

            if (isNaN(saldoSugerido)) {
                saldoSugerido = 0;
            }

            inputSaldoFondoFijo.value = formatearMonto(saldoSugerido);
        }

        if (fechaYaCerrada) {
            var saldoFinal = estado && estado.resumen_actual ? formatearMonto(estado.resumen_actual.resc_saldo_final) : '0.00';
            var mensajeCierre = 'Ya existe un cierre para esta fecha. Saldo final registrado: S/ ' + saldoFinal + '.';
            mostrarAlertaEstado(mensajeCierre, 'warning');
            mostrarSinDatos('La fecha seleccionada ya tiene un cierre registrado.');
            return true;
        }

        if (estado && estado.cierre_anterior && estado.cierre_anterior.resc_fecha) {
            var mensajeSaldo = 'Saldo inicial sugerido desde el cierre anterior (' + estado.cierre_anterior.resc_fecha + '): S/ ' + formatearMonto(estado.saldo_inicial_sugerido) + '.';
            mostrarAlertaEstado(mensajeSaldo, 'info');
        } else {
            mostrarAlertaEstado('', 'info');
        }

        actualizarSaldos();
        return false;
    }

    function renderizarDetalle(respuesta) {
        detallesActuales = Array.isArray(respuesta) ? respuesta : [];

        if (detallesActuales.length === 0) {
            mostrarSinDatos('No hay movimientos para la fecha seleccionada.');
            return;
        }

        totalIngresos = 0;
        totalEgresos = 0;

        var html = '';
        detallesActuales.forEach(function (fila, index) {
            var importe = parseFloat(fila.deta_movi_importe || 0);
            var tipo = String(fila.movi_tipo || '').toUpperCase();
            var ingreso = '';
            var egreso = '';

            if (tipo === 'INGRESO') {
                ingreso = formatearMonto(importe);
                totalIngresos += importe;
            } else {
                egreso = formatearMonto(importe);
                totalEgresos += importe;
            }

            html += '<tr>' +
                '<td>' + (index + 1) + '</td>' +
                '<td>' + escaparHtml(fila.movi_fecha) + '</td>' +
                '<td>' + escaparHtml(fila.deta_movi_tipo_doc || fila.movi_serie || '') + '</td>' +
                '<td>' + escaparHtml(fila.deta_movi_nro_doc || fila.movi_numero || '') + '</td>' +
                '<td>' + escaparHtml(fila.deta_movi_razon_social || fila.movi_empleado_nombre || '-') + '</td>' +
                '<td>' + escaparHtml(fila.deta_movi_descripcion || '') + '</td>' +
                '<td>' + ingreso + '</td>' +
                '<td>' + egreso + '</td>' +
            '</tr>';
        });

        detalleCaja.innerHTML = html;
        actualizarSaldos();
    }

    function obtenerFechaSeleccionada() {
        return {
            anio: parseInt(inputAnio && inputAnio.value ? inputAnio.value : 0, 10),
            mes: parseInt(selectMes.value || 0, 10),
            dia: parseInt(inputDia.value || 0, 10)
        };
    }

    function cargarDetalleResumen() {
        var fecha = obtenerFechaSeleccionada();

        if (!fecha.anio || !fecha.mes || !fecha.dia || inputDia.classList.contains('is-invalid')) {
            fechaYaCerrada = false;
            actualizarEstadoGuardado();
            mostrarAlertaEstado('', 'info');
            mostrarSinDatos('Seleccione un año, mes y día válidos para cargar el detalle.');
            return;
        }

        if (typeof $ === 'undefined' || !$.ajax) {
            return;
        }

        detalleCaja.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Cargando detalle...</td></tr>';

        var datosEstado = new FormData();
        datosEstado.append('estadoFechaResumen', '1');
        datosEstado.append('anio', String(fecha.anio));
        datosEstado.append('mes', String(fecha.mes));
        datosEstado.append('dia', String(fecha.dia));

        $.ajax({
            url: 'ajax/resumencaja.ajax.php',
            method: 'POST',
            data: datosEstado,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (estado) {
                if (estado && estado.valido === false) {
                    fechaYaCerrada = false;
                    actualizarEstadoGuardado();
                    mostrarAlertaEstado(estado.mensaje || 'La fecha del cierre no es válida.', 'warning');
                    mostrarSinDatos('Seleccione un año, mes y día válidos para cargar el detalle.');
                    return;
                }

                if (aplicarEstadoFecha(estado || {})) {
                    return;
                }

                var datos = new FormData();
                datos.append('listarDetalleResumen', '1');
                datos.append('anio', String(fecha.anio));
                datos.append('mes', String(fecha.mes));
                datos.append('dia', String(fecha.dia));

                $.ajax({
                    url: 'ajax/resumencaja.ajax.php',
                    method: 'POST',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (respuesta) {
                        renderizarDetalle(respuesta);
                    },
                    error: function () {
                        mostrarSinDatos('No se pudo cargar el detalle de movimientos.');
                    }
                });
            },
            error: function () {
                fechaYaCerrada = false;
                actualizarEstadoGuardado();
                mostrarAlertaEstado('', 'info');

                var datos = new FormData();
                datos.append('listarDetalleResumen', '1');
                datos.append('anio', String(fecha.anio));
                datos.append('mes', String(fecha.mes));
                datos.append('dia', String(fecha.dia));

                $.ajax({
                    url: 'ajax/resumencaja.ajax.php',
                    method: 'POST',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (respuesta) {
                        renderizarDetalle(respuesta);
                    },
                    error: function () {
                        mostrarSinDatos('No se pudo cargar el detalle de movimientos.');
                    }
                });
            }
        });
    }

    function actualizarMaxDia() {
        var mes = parseInt(selectMes.value || 0, 10);
        var max = diasPorMes[mes] || 31;
        inputDia.max = max;
        validarDia(max);
        cargarDetalleResumen();
    }

    function mostrarAyudaDni(texto, clase) {
        if (!helpDniResumenCaja) {
            return;
        }

        if (timeoutMensajeDni) {
            clearTimeout(timeoutMensajeDni);
            timeoutMensajeDni = null;
        }

        if (!texto) {
            helpDniResumenCaja.style.display = 'none';
            helpDniResumenCaja.className = 'form-text text-muted';
            helpDniResumenCaja.textContent = '';
            return;
        }

        helpDniResumenCaja.style.display = 'block';
        helpDniResumenCaja.className = 'form-text ' + (clase || 'text-muted');
        helpDniResumenCaja.textContent = texto;

        // Mensajes de resultado se ocultan solos; el estado de "buscando" permanece visible.
        if (texto !== 'Buscando empleado...') {
            timeoutMensajeDni = setTimeout(function () {
                if (!helpDniResumenCaja) {
                    return;
                }
                helpDniResumenCaja.style.display = 'none';
                helpDniResumenCaja.className = 'form-text text-muted';
                helpDniResumenCaja.textContent = '';
            }, 2800);
        }
    }

    function buscarEmpleadoPorDni() {
        if (!inputDniResumenCaja || typeof $ === 'undefined' || !$.ajax) {
            return;
        }

        var dni = String(inputDniResumenCaja.value || '').trim();
        if (dni === '' || !/^\d{8,20}$/.test(dni)) {
            ultimoDniConsultado = '';
            if (inputResponsableResumenCaja) {
                if (nombreAutocompletadoPorDni) {
                    inputResponsableResumenCaja.value = '';
                }
                inputResponsableResumenCaja.readOnly = false;
            }
            nombreAutocompletadoPorDni = false;
            mostrarAyudaDni('', 'text-muted');
            return;
        }

        if (dni === ultimoDniConsultado) {
            return;
        }

        ultimoDniConsultado = dni;
        mostrarAyudaDni('Buscando empleado...', 'text-muted');

        var datos = new FormData();
        datos.append('buscarEmpleadoPorDni', '1');
        datos.append('dni', dni);

        $.ajax({
            url: 'ajax/resumencaja.ajax.php',
            method: 'POST',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (respuesta) {
                if (String(inputDniResumenCaja.value || '').trim() !== dni) {
                    return;
                }

                if (respuesta && respuesta.status === 'ok') {
                    if (inputResponsableResumenCaja) {
                        inputResponsableResumenCaja.value = respuesta.nombre || '';
                        inputResponsableResumenCaja.readOnly = true;
                    }
                    nombreAutocompletadoPorDni = true;
                    mostrarAyudaDni('Empleado encontrado. Responsable autocompletado y bloqueado.', 'text-success');
                    return;
                }

                if (respuesta && respuesta.status === 'not_found') {
                    if (inputResponsableResumenCaja) {
                        if (nombreAutocompletadoPorDni) {
                            inputResponsableResumenCaja.value = '';
                        }
                        inputResponsableResumenCaja.readOnly = false;
                    }
                    nombreAutocompletadoPorDni = false;
                    mostrarAyudaDni('No se encontró un empleado con ese DNI.', 'text-warning');
                    return;
                }

                if (inputResponsableResumenCaja) {
                    inputResponsableResumenCaja.readOnly = false;
                }
                nombreAutocompletadoPorDni = false;
                mostrarAyudaDni('No se pudo validar el DNI en este momento.', 'text-danger');
            },
            error: function () {
                if (String(inputDniResumenCaja.value || '').trim() !== dni) {
                    return;
                }
                if (inputResponsableResumenCaja) {
                    inputResponsableResumenCaja.readOnly = false;
                }
                nombreAutocompletadoPorDni = false;
                mostrarAyudaDni('Error al consultar empleados por DNI.', 'text-danger');
            }
        });
    }

    function validarDia(max) {
        max = max || parseInt(inputDia.max || '31', 10);
        var val = parseInt(inputDia.value, 10);

        if (inputDia.value === '') {
            inputDia.classList.remove('is-invalid');
            feedback.textContent = '';
            return;
        }

        if (isNaN(val) || val < 1) {
            inputDia.classList.add('is-invalid');
            feedback.textContent = 'El día mínimo es 1.';
        } else if (val > max) {
            inputDia.classList.add('is-invalid');
            feedback.textContent = 'El mes seleccionado solo tiene ' + max + ' días.';
        } else {
            inputDia.classList.remove('is-invalid');
            feedback.textContent = '';
        }
    }

    function llenarCabeceraResumen(resumen) {
        document.getElementById('verResumenFecha').textContent = resumen.resc_fecha || '-';
        document.getElementById('verResumenDni').textContent = resumen.resc_dni || '-';
        document.getElementById('verResumenResponsable').textContent = resumen.resc_responsable || '-';
        document.getElementById('verResumenItems').textContent = resumen.resc_total_items || '0';
        document.getElementById('verResumenSaldoInicial').textContent = 'S/ ' + formatearMonto(resumen.resc_saldo_inicial);
        document.getElementById('verResumenIngresos').textContent = 'S/ ' + formatearMonto(resumen.resc_total_ingresos);
        document.getElementById('verResumenEgresos').textContent = 'S/ ' + formatearMonto(resumen.resc_total_egresos);
        document.getElementById('verResumenSaldoFinal').textContent = 'S/ ' + formatearMonto(resumen.resc_saldo_final);
        document.getElementById('verResumenObservacion').textContent = resumen.resc_observacion || '-';
    }

    function renderizarDetalleGuardado(detalle) {
        if (!detalleResumenGuardado) {
            return;
        }

        if (!Array.isArray(detalle) || detalle.length === 0) {
            detalleResumenGuardado.innerHTML = '<tr><td colspan="8" class="text-center text-muted">No hay detalle guardado.</td></tr>';
            return;
        }

        var html = '';
        detalle.forEach(function (fila) {
            html += '<tr>' +
                '<td>' + escaparHtml(fila.rescd_item) + '</td>' +
                '<td>' + escaparHtml(fila.rescd_fecha_documento) + '</td>' +
                '<td>' + escaparHtml(fila.rescd_tipo_doc || fila.rescd_serie || '') + '</td>' +
                '<td>' + escaparHtml(fila.rescd_nro_doc || fila.rescd_numero || '') + '</td>' +
                '<td>' + escaparHtml(fila.rescd_razon_social || fila.rescd_responsable || '-') + '</td>' +
                '<td>' + escaparHtml(fila.rescd_concepto || '') + '</td>' +
                '<td>' + formatearMonto(fila.rescd_ingreso) + '</td>' +
                '<td>' + formatearMonto(fila.rescd_egreso) + '</td>' +
            '</tr>';
        });

        detalleResumenGuardado.innerHTML = html;
    }

    inputDia.addEventListener('input', function () {
        validarDia();
        cargarDetalleResumen();
    });

    if (inputDniResumenCaja) {
        inputDniResumenCaja.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');
            if (timeoutBuscarDni) {
                clearTimeout(timeoutBuscarDni);
            }
            timeoutBuscarDni = setTimeout(buscarEmpleadoPorDni, 350);
        });

        inputDniResumenCaja.addEventListener('blur', function () {
            if (timeoutBuscarDni) {
                clearTimeout(timeoutBuscarDni);
            }
            buscarEmpleadoPorDni();
        });
    }

    if (inputSaldoFondoFijo) {
        inputSaldoFondoFijo.addEventListener('input', actualizarSaldos);
    }

    if (inputAnio) {
        inputAnio.addEventListener('input', cargarDetalleResumen);
    }

    selectMes.addEventListener('change', actualizarMaxDia);

    if (formAgregarResumenCaja) {
        formAgregarResumenCaja.addEventListener('submit', function (event) {
            if (fechaYaCerrada) {
                event.preventDefault();
                if (typeof swal === 'function') {
                    swal({
                        type: 'warning',
                        title: 'Ya se registró el cierre para esta fecha.',
                        text: 'Seleccione otro día para registrar un nuevo cierre.',
                        showConfirmButton: true,
                        confirmButtonText: 'Cerrar'
                    });
                }
                return;
            }

            if (!detallesActuales.length) {
                event.preventDefault();
                if (typeof swal === 'function') {
                    swal({
                        type: 'error',
                        title: 'No hay movimientos para generar el cierre seleccionado.',
                        showConfirmButton: true,
                        confirmButtonText: 'Cerrar'
                    });
                }
            }
        });
    }

    if (typeof $ !== 'undefined') {
        $(document).on('click', '.btnImprimirResumenCaja', function () {
            var idResumenCaja = $(this).attr('idResumenCaja');
            if (!idResumenCaja) {
                return;
            }

            window.open('vistas/report/resumen-caja.php?codigo=' + idResumenCaja, '_blank');
        });

        $(document).on('click', '.btnExportarResumenCajaExcel', function () {
            var idResumenCaja = $(this).attr('idResumenCaja');
            if (!idResumenCaja) {
                return;
            }

            window.open('vistas/report/resumen-caja-excel.php?codigo=' + idResumenCaja + '&formato=xls', '_blank');
        });

        $(document).on('click', '.btnVerResumenCaja', function () {
            var idResumenCaja = $(this).attr('idResumenCaja');

            if (!idResumenCaja) {
                return;
            }

            if (detalleResumenGuardado) {
                detalleResumenGuardado.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Cargando detalle...</td></tr>';
            }

            var datosResumen = new FormData();
            datosResumen.append('idResumenCaja', idResumenCaja);

            $.ajax({
                url: 'ajax/resumencaja.ajax.php',
                method: 'POST',
                data: datosResumen,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (respuesta) {
                    llenarCabeceraResumen(respuesta || {});
                }
            });

            var datosDetalle = new FormData();
            datosDetalle.append('idResumenCajaDetalle', idResumenCaja);

            $.ajax({
                url: 'ajax/resumencaja.ajax.php',
                method: 'POST',
                data: datosDetalle,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (respuesta) {
                    renderizarDetalleGuardado(respuesta);
                },
                error: function () {
                    renderizarDetalleGuardado([]);
                }
            });
        });

        $(document).on('click', '.btnEditarResumenCaja', function () {
            var idResumenCaja = $(this).attr('idResumenCaja');

            if (!idResumenCaja) {
                return;
            }

            var datos = new FormData();
            datos.append('idResumenCaja', idResumenCaja);

            $.ajax({
                url: 'ajax/resumencaja.ajax.php',
                method: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (respuesta) {
                    $('#inputEditResumenCajaId').val(respuesta && respuesta.resc_id ? respuesta.resc_id : '');
                    $('#inputEditFechaResumenCaja').val(respuesta && respuesta.resc_fecha ? respuesta.resc_fecha : '');
                    $('#inputEditDniResumenCaja').val(respuesta && respuesta.resc_dni ? respuesta.resc_dni : '');
                    $('#inputEditResponsableResumenCaja').val(respuesta && respuesta.resc_responsable ? respuesta.resc_responsable : '');
                    $('#inputEditObservacionResumenCaja').val(respuesta && respuesta.resc_observacion ? respuesta.resc_observacion : '');
                }
            });
        });

        $(document).on('click', '.btnEliminarResumenCaja', function () {
            var idResumenCaja = $(this).attr('idResumenCaja');
            var fechaResumenCaja = $(this).attr('fechaResumenCaja') || '';

            if (!idResumenCaja) {
                return;
            }

            swal({
                title: '¿Está seguro de eliminar el cierre?',
                text: 'El cierre de fecha ' + fechaResumenCaja + ' se enviará a papelera.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, enviar a papelera'
            }).then(function (result) {
                if (result.value) {
                    window.location = 'index.php?ruta=resumen-caja&idResumenCaja=' + idResumenCaja;
                }
            });
        });

        $(document).on('click', '.btnRestaurarResumenCaja', function () {
            var idResumenCaja = $(this).attr('idResumenCaja');
            var fechaResumenCaja = $(this).attr('fechaResumenCaja') || '';

            if (!idResumenCaja) {
                return;
            }

            swal({
                title: '¿Restaurar cierre de caja?',
                text: 'El cierre de fecha ' + fechaResumenCaja + ' volverá al listado principal.',
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, restaurar'
            }).then(function (result) {
                if (!result.value) {
                    return;
                }

                var datos = new FormData();
                datos.append('restaurarResumenCajaId', idResumenCaja);

                $.ajax({
                    url: 'ajax/resumencaja.ajax.php',
                    method: 'POST',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (respuesta) {
                        if (respuesta && respuesta.status === 'ok') {
                            swal({
                                title: 'Restaurado',
                                text: 'El cierre fue restaurado correctamente.',
                                type: 'success',
                                confirmButtonText: 'Cerrar'
                            }).then(function (r) {
                                if (r.value) {
                                    window.location = 'resumen-caja';
                                }
                            });
                        } else {
                            swal({
                                title: 'Error',
                                text: (respuesta && respuesta.message) ? respuesta.message : 'No se pudo restaurar el cierre',
                                type: 'error',
                                confirmButtonText: 'Cerrar'
                            });
                        }
                    },
                    error: function () {
                        swal({
                            title: 'Error',
                            text: 'No se pudo conectar para restaurar el cierre.',
                            type: 'error',
                            confirmButtonText: 'Cerrar'
                        });
                    }
                });
            });
        });

        $(document).on('click', '.btnDepurarResumenCaja', function () {
            var idResumenCaja = $(this).attr('idResumenCaja');
            var fechaResumenCaja = $(this).attr('fechaResumenCaja') || '';

            if (!idResumenCaja) {
                return;
            }

            swal({
                title: 'ELIMINACIÓN DEFINITIVA',
                html: 'El cierre de fecha <strong>' + fechaResumenCaja + '</strong> será eliminado permanentemente.<br><br>Esta acción no se puede deshacer.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, eliminar para siempre'
            }).then(function (result) {
                if (!result.value) {
                    return;
                }

                var datos = new FormData();
                datos.append('depurarResumenCajaId', idResumenCaja);

                $.ajax({
                    url: 'ajax/resumencaja.ajax.php',
                    method: 'POST',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (respuesta) {
                        if (respuesta && respuesta.status === 'ok') {
                            swal({
                                title: 'Eliminado',
                                text: 'El cierre fue depurado correctamente.',
                                type: 'success',
                                confirmButtonText: 'Cerrar'
                            }).then(function (r) {
                                if (r.value) {
                                    window.location = 'resumen-caja';
                                }
                            });
                        } else {
                            swal({
                                title: 'Error',
                                text: (respuesta && respuesta.message) ? respuesta.message : 'No se pudo depurar el cierre',
                                type: 'error',
                                confirmButtonText: 'Cerrar'
                            });
                        }
                    },
                    error: function () {
                        swal({
                            title: 'Error',
                            text: 'No se pudo conectar para depurar el cierre.',
                            type: 'error',
                            confirmButtonText: 'Cerrar'
                        });
                    }
                });
            });
        });
    }

    actualizarMaxDia();
    actualizarEstadoGuardado();
    mostrarSinDatos('Seleccione un año, mes y día válidos para cargar el detalle.');
})();