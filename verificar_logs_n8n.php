<?php
/**
 * Verificar Logs de n8n
 * Consulta los logs almacenados en la tabla n8n_logs
 */

header('Content-Type: application/json');
include 'conexion.php';

try {
    $sql = "SELECT * FROM n8n_logs ORDER BY fecha_hora DESC LIMIT 10";
    $result = $conexion->query($sql);

    if ($result) {
        $logs = [];
        while ($row = $result->fetch_assoc()) {
            $logs[] = [
                'id' => $row['id'],
                'evento' => $row['evento'],
                'datos_enviados' => json_decode($row['datos_enviados'], true),
                'respuesta' => $row['respuesta'],
                'estado' => $row['estado'],
                'fecha_hora' => $row['fecha_hora']
            ];
        }

        echo json_encode([
            'success' => true,
            'total' => count($logs),
            'logs' => $logs
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'No se pudo consultar la tabla n8n_logs. ¿Ejecutaste setup_n8n_tables.php?'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

$conexion->close();
?>