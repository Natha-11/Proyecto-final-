<?php
header('Content-Type: application/json');
require_once 'n8n_send_data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!isset($data['nombre']) || !isset($data['mensaje']) || !isset($data['email'])) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit;
    }

    $nombre = htmlspecialchars($data['nombre']);
    $email = htmlspecialchars($data['email']);
    $mensaje = htmlspecialchars($data['mensaje']);

    $resultado = enviarAn8n('mensaje_usuario', [
        'nombre' => $nombre,
        'email' => $email,
        'mensaje' => $mensaje,
        'url_referencia' => $_SERVER['HTTP_REFERER']
    ]);

    echo json_encode($resultado);
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>