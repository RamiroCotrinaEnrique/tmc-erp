<!DOCTYPE html>
<html>
<head>
    <title>Prueba Consulta RUC - API APISPERU</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 600px;
        }
        .form-group label {
            font-weight: 500;
            color: #333;
        }
        .spinner-border {
            width: 20px;
            height: 20px;
            color: #007bff;
        }
        .alert {
            margin-top: 20px;
        }
        .result-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #28a745;
            margin-top: 20px;
            border-radius: 4px;
        }
        .result-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .result-item:last-child {
            border-bottom: none;
        }
        .result-label {
            font-weight: 600;
            color: #555;
        }
        .result-value {
            color: #333;
            text-align: right;
            flex: 1;
            margin-left: 20px;
            word-break: break-word;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">
            <i class="fas fa-search"></i> Prueba de Consulta RUC
        </h1>
        <p class="text-muted">Sistema de consulta automática mediante API APISPERU</p>
        <hr>

        <div class="form-group">
            <label for="rucInput">Ingrese RUC (11 dígitos):</label>
            <div class="input-group">
                <input 
                    type="text" 
                    class="form-control" 
                    id="rucInput" 
                    placeholder="Ej: 20131312955"
                    maxlength="11"
                >
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="btnBuscar">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
            <small class="form-text text-muted">Solo se aceptan números. Presione Enter o haga clic en Buscar.</small>
        </div>

        <div id="loadingIndicator" style="display: none; margin-top: 15px;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
            <span class="ml-2">Consultando API APISPERU...</span>
        </div>

        <div id="alertBox"></div>

        <div id="resultBox" style="display: none;" class="result-box">
            <h5 class="mb-3">Datos obtenidos:</h5>
            <div id="resultContent"></div>
        </div>

        <div class="alert alert-info mt-4" role="alert">
            <h5>RUCs de Prueba:</h5>
            <ul class="mb-0">
                <li><strong>20131312955</strong> - REPARTO PERU S.A.C.</li>
                <li><strong>20369157099</strong> - TELEFONICA DEL PERU S.A.A.</li>
                <li><strong>20500000035</strong> - EMPRESA NACIONAL DE ELECTRICIDAD S.A.</li>
            </ul>
        </div>

        <div class="alert alert-warning mt-3">
            <strong>Nota:</strong> Esta es una página de prueba. En el sistema real, la consulta se ejecuta automáticamente cuando pierde el foco del campo RUC en el formulario de empresas.
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        // Filtrar solo números
        $('#rucInput').on('keyup', function(){
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Buscar al presionar Enter
        $('#rucInput').on('keypress', function(e){
            if(e.which == 13){
                buscarRuc();
            }
        });

        // Botón Buscar
        $('#btnBuscar').on('click', function(){
            buscarRuc();
        });

        function buscarRuc(){
            var ruc = $('#rucInput').val().trim();
            
            // Limpiar alertas previas
            $('#alertBox').html('');
            $('#resultBox').hide();
            
            // Validaciones
            if(!ruc){
                mostrarAlerta('error', 'Por favor ingrese un RUC');
                return;
            }
            
            if(ruc.length !== 11){
                mostrarAlerta('error', 'El RUC debe tener exactamente 11 dígitos');
                return;
            }
            
            if(!/^[0-9]+$/.test(ruc)){
                mostrarAlerta('error', 'El RUC solo puede contener números');
                return;
            }
            
            // Mostrar indicador de carga
            $('#loadingIndicator').show();
            
            // Realizar consulta AJAX
            $.ajax({
                url: 'ajax/consultar_ruc.ajax.php',
                method: 'POST',
                data: {
                    ruc: ruc
                },
                dataType: 'json',
                success: function(respuesta){
                    $('#loadingIndicator').hide();
                    
                    if(respuesta.success){
                        mostrarResultados(respuesta);
                        mostrarAlerta('success', 'Datos obtenidos correctamente');
                    } else {
                        mostrarAlerta('warning', respuesta.mensaje || 'No se encontraron datos');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    $('#loadingIndicator').hide();
                    mostrarAlerta('error', 'Error al consultar la API: ' + textStatus);
                    console.log(textStatus, errorThrown);
                }
            });
        }

        function mostrarAlerta(tipo, mensaje){
            var alertClass = 'alert-' + (tipo === 'success' ? 'success' : 
                                         tipo === 'error' ? 'danger' : 
                                         tipo === 'warning' ? 'warning' : 'info');
            
            var icono = tipo === 'success' ? 'check-circle' : 
                       tipo === 'error' ? 'times-circle' : 
                       tipo === 'warning' ? 'exclamation-circle' : 'info-circle';
            
            var html = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                       '<i class="fas fa-' + icono + '"></i> ' + mensaje +
                       '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>' +
                       '</div>';
            
            $('#alertBox').html(html);
        }

        function mostrarResultados(datos){
            var html = '';
            
            html += '<div class="result-item">';
            html += '<span class="result-label">RUC:</span>';
            html += '<span class="result-value">' + (datos.ruc || 'N/A') + '</span>';
            html += '</div>';
            
            html += '<div class="result-item">';
            html += '<span class="result-label">Razón Social:</span>';
            html += '<span class="result-value">' + (datos.razonSocial || 'N/A') + '</span>';
            html += '</div>';
            
            html += '<div class="result-item">';
            html += '<span class="result-label">Nombre Comercial:</span>';
            html += '<span class="result-value">' + (datos.nombreComercial || 'N/A') + '</span>';
            html += '</div>';
            
            html += '<div class="result-item">';
            html += '<span class="result-label">Domicilio:</span>';
            html += '<span class="result-value">' + (datos.domicilio || datos.direccion || 'N/A') + '</span>';
            html += '</div>';
            
            if(datos.telefonos && datos.telefonos.length > 0){
                html += '<div class="result-item">';
                html += '<span class="result-label">Teléfono:</span>';
                html += '<span class="result-value">' + datos.telefonos[0] + '</span>';
                html += '</div>';
            }
            
            if(datos.provincia){
                html += '<div class="result-item">';
                html += '<span class="result-label">Provincia:</span>';
                html += '<span class="result-value">' + datos.provincia + '</span>';
                html += '</div>';
            }
            
            if(datos.departamento){
                html += '<div class="result-item">';
                html += '<span class="result-label">Departamento:</span>';
                html += '<span class="result-value">' + datos.departamento + '</span>';
                html += '</div>';
            }
            
            $('#resultContent').html(html);
            $('#resultBox').show();
        }
    </script>
</body>
</html>
