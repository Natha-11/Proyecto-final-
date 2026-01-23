<?php
/**
 * Cleanup y Re-crear Tabla Notificaciones
 * Este script elimina y recrea la tabla notificaciones sin FK constraint
 */

include 'conexion.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Fix Notificaciones Table</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #d4af37; }
        .success { background: #d4edda; border-left: 4px solid #28a745; padding: 15px; margin: 15px 0; }
        .error { background: #f8d7da; border-left: 4px solid #dc3545; padding: 15px; margin: 15px 0; }
        .info { background: #d1ecf1; border-left: 4px solid #17a2b8; padding: 15px; margin: 15px 0; }
    </style>
</head>
<body>
<div class='container'>
<h1>🔧 Reparar Tabla Notificaciones</h1>";

// Paso 1: Eliminar tabla si existe
echo "<div class='info'><strong>Paso 1:</strong> Eliminando tabla antigua...</div>";
$drop_sql = "DROP TABLE IF EXISTS notificaciones";
if ($conexion->query($drop_sql) === TRUE) {
    echo "<div class='success'>✅ Tabla antigua eliminada (si existía)</div>";
} else {
    echo "<div class='error'>❌ Error: " . $conexion->error . "</div>";
}

// Paso 2: Crear tabla nueva SIN foreign key
echo "<div class='info'><strong>Paso 2:</strong> Creando tabla nueva...</div>";
$create_sql = "CREATE TABLE notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT NULL,
    tipo VARCHAR(50) NOT NULL,
    destinatario VARCHAR(100),
    mensaje TEXT,
    estado VARCHAR(20) DEFAULT 'pendiente',
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_entregado TIMESTAMP NULL,
    error_mensaje TEXT,
    INDEX idx_reserva (reserva_id),
    INDEX idx_tipo (tipo),
    INDEX idx_estado (estado),
    INDEX idx_fecha (fecha_envio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conexion->query($create_sql) === TRUE) {
    echo "<div class='success'>✅ Tabla 'notificaciones' creada exitosamente</div>";
    echo "<div class='info'>
        <h3>Estructura de la tabla:</h3>
        <ul>
            <li><strong>id</strong>: INT AUTO_INCREMENT PRIMARY KEY</li>
            <li><strong>reserva_id</strong>: INT NULL (sin FK constraint)</li>
            <li><strong>tipo</strong>: VARCHAR(50) NOT NULL</li>
            <li><strong>destinatario</strong>: VARCHAR(100)</li>
            <li><strong>mensaje</strong>: TEXT</li>
            <li><strong>estado</strong>: VARCHAR(20) DEFAULT 'pendiente'</li>
            <li><strong>fecha_envio</strong>: TIMESTAMP</li>
            <li><strong>fecha_entregado</strong>: TIMESTAMP NULL</li>
            <li><strong>error_mensaje</strong>: TEXT</li>
        </ul>
    </div>";
} else {
    echo "<div class='error'>❌ Error al crear tabla: " . $conexion->error . "</div>";
}

// Paso 3: Verificar
echo "<h2>📊 Verificación</h2>";
$verify = $conexion->query("SHOW TABLES LIKE 'notificaciones'");
if ($verify && $verify->num_rows > 0) {
    echo "<div class='success'>✅ La tabla 'notificaciones' existe y está lista para usar</div>";

    // Mostrar estructura
    $structure = $conexion->query("DESCRIBE notificaciones");
    if ($structure) {
        echo "<h3>Estructura actual:</h3>";
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr style='background: #f0f0f0;'><th style='padding: 10px; border: 1px solid #ddd;'>Campo</th><th style='padding: 10px; border: 1px solid #ddd;'>Tipo</th><th style='padding: 10px; border: 1px solid #ddd;'>Null</th><th style='padding: 10px; border: 1px solid #ddd;'>Clave</th></tr>";
        while ($row = $structure->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row['Field'] . "</td>";
            echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row['Type'] . "</td>";
            echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row['Null'] . "</td>";
            echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row['Key'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    echo "<div style='margin-top: 30px; padding: 20px; background: #e8f5e9; border-radius: 5px;'>
        <h3 style='color: #2e7d32; margin-top: 0;'>✅ ¡Problema Resuelto!</h3>
        <p>La tabla 'notificaciones' ha sido creada correctamente <strong>sin restricciones de clave foránea</strong>.</p>
        <p><strong>Siguiente paso:</strong> Ejecuta ahora <code>setup_n8n_tables.php</code> para verificar todas las tablas.</p>
        <p>O continúa directamente con las pruebas en <code>test_n8n_integration.php</code></p>
    </div>";
} else {
    echo "<div class='error'>❌ La tabla no se pudo crear correctamente</div>";
}

echo "</div>
</body>
</html>";

$conexion->close();
?>