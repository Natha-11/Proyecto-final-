<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validar que los campos no vengan vacíos
    $nombre = $_POST['nombre'];
    $email_cliente = $_POST['email'];
    $servicio = $_POST['servicio'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Comprobar si el usuario ha iniciado sesión para el ID del cliente (mejora opcional)
    session_start();
    $cliente_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    // Verificar disponibilidad antes de insertar (Doble comprobación en el backend)
    $check_sql = "SELECT id FROM reservas WHERE fecha = ? AND hora = ?";
    $stmt_check = $conexion->prepare($check_sql);
    $stmt_check->bind_param("ss", $fecha, $hora);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<script>
            alert('Lo sentimos, esa hora ya está reservada. Por favor elige otra.');
            window.location.href = 'index.php#booking';
          </script>";
        $stmt_check->close();
        exit();
    }
    $stmt_check->close();

    // Insertar en reservas
    $sql = "INSERT INTO reservas (cliente_id, nombre_cliente, servicio, fecha, hora) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issss", $cliente_id, $nombre, $servicio, $fecha, $hora);

        if ($stmt->execute()) {
            $reserva_id = $stmt->insert_id;

            // INTEGRACIÓN N8N - Enviar notificación de nueva reserva
            include_once 'n8n_send_data.php';
            $resultado_n8n = enviarAn8n('nueva_reserva', [
                'reserva_id' => $reserva_id,
                'nombre' => $nombre,
                'email' => $email_cliente,
                'servicio' => $servicio,
                'fecha' => $fecha,
                'hora' => $hora,
                'codigo_confirmacion' => 'RES-' . str_pad($reserva_id, 6, '0', STR_PAD_LEFT),
                'timestamp' => date('Y-m-d H:i:s')
            ]);

            echo "<script>
                    alert('¡Reserva confirmada con éxito!');
                    window.location.href = 'index.php';
                  </script>";

        } else {
            echo " Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo " Error en la preparación de la consulta: " . $conexion->error;
    }

    $conexion->close();
}
?>