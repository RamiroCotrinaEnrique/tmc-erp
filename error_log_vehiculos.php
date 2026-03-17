<?php
// Script para ver los últimos errores de actualización de vehículos
if(file_exists('../error_log')) {
    $contenido = file_get_contents('../error_log');
    $lineas = explode("\n", $contenido);
    
    // Mostrar las últimas 50 líneas
    $ultimas = array_slice($lineas, -50);
    
    echo "<pre>";
    echo "=== ÚLTIMOS ERRORES ===\n\n";
    foreach($ultimas as $linea) {
        if(strpos($linea, 'vehiculo') !== false || strpos($linea, 'UPDATE') !== false) {
            echo $linea . "\n";
        }
    }
    echo "</pre>";
} else {
    echo "No hay archivo de errores";
}
?>
