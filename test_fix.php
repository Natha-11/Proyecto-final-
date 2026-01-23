<?php
// Mock $_POST for the test
$_POST['nombre'] = 'TestUserFinalFix';
$_POST['telefono'] = '123456789';
$_POST['servicio'] = 'natural';
$_POST['fecha'] = '2024-01-14';
$_POST['hora'] = '15:00'; // Coincide con el campo del formulario
$_SERVER["REQUEST_METHOD"] = "POST";

try {
    include 'registro.php';
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage();
}
?>