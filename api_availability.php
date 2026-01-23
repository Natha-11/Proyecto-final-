<?php
include 'conexion.php';

header('Content-Type: application/json');

if (isset($_GET['fecha'])) {
    $fecha = $_GET['fecha'];

    // Obtener horas ya reservadas para esa fecha
    $sql = "SELECT bora FROM reservas WHERE fecha = ?"; // Typo check: column name 'hora'
    // I will use 'hora' as defined in setup_db.php
    $sql = "SELECT bora FROM reservas WHERE fecha = ?";
    // Wait, let's double check setup_db.php. It says 'hora'.
    $sql = "SELECT hora FROM reservas WHERE fecha = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $fecha);
    $stmt->execute();
    $result = $stmt->get_result();

    $reserved_hours = [];
    while ($row = $result->fetch_assoc()) {
        $reserved_hours[] = $row['hora']; // e.g. "10:00"
    }

    echo json_encode(['reserved' => $reserved_hours]);
    $stmt->close();
} else {
    echo json_encode(['error' => 'Fecha no proporcionada']);
}

$conexion->close();
?>