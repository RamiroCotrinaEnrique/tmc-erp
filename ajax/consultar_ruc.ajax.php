<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

if(isset($_POST["ruc"]) && !empty($_POST["ruc"])){
    $ruc = trim($_POST["ruc"]);
    
    // Validar que sea numérico
    if(!preg_match('/^[0-9]+$/', $ruc)){
        echo json_encode([
            'success' => false,
            'mensaje' => 'El RUC debe contener solo números'
        ]);
        exit;
    }
    
    // Validar que tenga 11 dígitos
    if(strlen($ruc) != 11){
        echo json_encode([
            'success' => false,
            'mensaje' => 'El RUC debe tener 11 dígitos'
        ]);
        exit;
    }
    
    // Consultar API de APISPERU
    $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNvdHJpbmFyYW1pcm9AZ21haWwuY29tIn0.uPGK2zSx7XlSQYNLaOjjJ6IP6QPUR5kV4QDwC9yjDJA";
    $url = "https://dniruc.apisperu.com/api/v1/ruc/" . $ruc . "?token=" . $token;
    
    $contexto = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 10,
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false
        ]
    ]);
    
    try {
        $respuesta = @file_get_contents($url, false, $contexto);
        
        if($respuesta === false){
            echo json_encode([
                'success' => false,
                'mensaje' => 'No se pudo conectar con el API de APISPERU. Llene los datos manualmente.'
            ]);
            exit;
        }
        
        $datos = json_decode($respuesta, true);
        
        // Verificar si la respuesta tiene error o si no contiene datos
        if(!is_array($datos) || isset($datos['error']) || empty($datos['razonSocial'])){
            echo json_encode([
                'success' => false,
                'mensaje' => 'RUC no encontrado en el sistema.'
            ]);
            exit;
        }
        
        // Mapear los datos de la API a los campos del formulario
        $resultado = [
            'success' => true,
            'ruc' => $datos['ruc'] ?? '',
            'razonSocial' => $datos['razonSocial'] ?? '',
            'nombreComercial' => $datos['nombreComercial'] ?? '',
            'telefonos' => $datos['telefonos'] ?? [],
            'domicilio' => $datos['domicilio'] ?? '',
            'distrito' => $datos['distrito'] ?? '',
            'provincia' => $datos['provincia'] ?? '',
            'departamento' => $datos['departamento'] ?? '',
            'direccion' => $datos['direccion'] ?? ''
        ];
        
        echo json_encode($resultado);
        exit;
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'mensaje' => 'Error al procesar la solicitud. Llene los datos manualmente.'
        ]);
        exit;
    }
} else {
    echo json_encode([
        'success' => false,
        'mensaje' => 'RUC requerido'
    ]);
    exit;
}
?>
