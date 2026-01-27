<?php
/**
 * Prueba de Integración de n8n
 * Archivo de prueba para verificar la integración con n8n
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test n8n Integration</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
            color: #fff;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            color: #d4af37;
            margin-bottom: 30px;
            font-size: 2.5rem;
            text-align: center;
            border-bottom: 3px solid #d4af37;
            padding-bottom: 15px;
        }

        .test-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .test-section h2 {
            color: #d4af37;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .test-button {
            background: linear-gradient(135deg, #d4af37 0%, #b8941f 100%);
            color: #1a1a1a;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            margin-right: 10px;
            margin-bottom: 10px;
            transition: all 0.3s;
        }

        .test-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
        }

        .result {
            background: rgba(0, 0, 0, 0.3);
            border-left: 4px solid #d4af37;
            padding: 15px;
            margin-top: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }

        .result.show {
            display: block;
        }

        .success {
            border-left-color: #28a745;
            background: rgba(40, 167, 69, 0.1);
        }

        .error {
            border-left-color: #dc3545;
            background: rgba(220, 53, 69, 0.1);
        }

        .info {
            background: rgba(23, 162, 184, 0.1);
            border-left: 4px solid #17a2b8;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        code {
            background: rgba(0, 0, 0, 0.3);
            padding: 2px 6px;
            border-radius: 3px;
            color: #d4af37;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(212, 175, 55, 0.3);
            border-radius: 50%;
            border-top-color: #d4af37;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🧪 Test de Integración n8n</h1>

        <div class="info">
            <strong>ℹ️ Información:</strong> Este panel te permite probar todos los endpoints de integración con n8n.
            Asegúrate de haber ejecutado <code>setup_n8n_tables.php</code> primero.
        </div>

        <!-- Test 1: Endpoint Local -->
        <div class="test-section">
            <h2>1️⃣ Test: Endpoint Receptor Local</h2>
            <p>Prueba el endpoint <code>n8n_webhook_handler.php</code> para crear una reserva de prueba.</p>
            <button class="test-button" onclick="testEndpointLocal()">🚀 Probar Endpoint Local</button>
            <div class="result" id="result1"></div>
        </div>

        <!-- Test 2: Envío a n8n -->
        <div class="test-section">
            <h2>2️⃣ Test: Envío a Webhook n8n</h2>
            <p>Envía datos de prueba directamente al webhook de n8n.</p>
            <button class="test-button" onclick="testEnvioN8n()">📤 Enviar a n8n</button>
            <div class="result" id="result2"></div>
        </div>

        <!-- Test 3: Consultar Disponibilidad -->
        <div class="test-section">
            <h2>3️⃣ Test: Consultar Disponibilidad</h2>
            <p>Consulta las horas disponibles para una fecha específica.</p>
            <input type="date" id="fechaDisponibilidad"
                style="padding: 10px; margin-right: 10px; border-radius: 5px; border: 1px solid #d4af37; background: rgba(0,0,0,0.3); color: #fff;">
            <button class="test-button" onclick="testDisponibilidad()">📅 Consultar</button>
            <div class="result" id="result3"></div>
        </div>

        <!-- Test 4: Listar Reservas -->
        <div class="test-section">
            <h2>4️⃣ Test: Listar Reservas</h2>
            <p>Obtiene todas las reservas desde hoy en adelante.</p>
            <button class="test-button" onclick="testListarReservas()">📋 Listar Reservas</button>
            <div class="result" id="result4"></div>
        </div>

        <!-- Test 5: Estadísticas -->
        <div class="test-section">
            <h2>5️⃣ Test: Obtener Estadísticas</h2>
            <p>Obtiene estadísticas del mes actual.</p>
            <button class="test-button" onclick="testEstadisticas()">📊 Ver Estadísticas</button>
            <div class="result" id="result5"></div>
        </div>

        <!-- Test 6: Verificar Logs -->
        <div class="test-section">
            <h2>6️⃣ Test: Verificar Logs de n8n</h2>
            <p>Consulta los últimos registros en la tabla <code>n8n_logs</code>.</p>
            <button class="test-button" onclick="testVerificarLogs()">🔍 Ver Logs</button>
            <div class="result" id="result6"></div>
        </div>
    </div>

    <script>
        function showResult(id, content, type = 'info') {
            const result = document.getElementById(id);
            result.className = 'result show ' + type;
            result.innerHTML = content;
        }

        function showLoading(id) {
            const result = document.getElementById(id);
            result.className = 'result show';
            result.innerHTML = '<div class="loading"></div> Procesando...';
        }

        async function testEndpointLocal() {
            showLoading('result1');
            try {
                const response = await fetch('n8n_webhook_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        accion: 'crear_reserva',
                        nombre: 'Cliente Test',
                        servicio: 'natural',
                        fecha: '2026-01-30',
                        hora: '14:00'
                    })
                });
                const data = await response.json();
                showResult('result1', `<pre>${JSON.stringify(data, null, 2)}</pre>`, data.success ? 'success' : 'error');
            } catch (error) {
                showResult('result1', `Error: ${error.message}`, 'error');
            }
        }

        async function testEnvioN8n() {
            showLoading('result2');
            try {
                const response = await fetch('n8n_send_data.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        evento: 'test_manual',
                        datos: {
                            mensaje: 'Prueba desde panel de testing',
                            timestamp: new Date().toISOString()
                        }
                    })
                });
                const data = await response.json();
                showResult('result2', `<pre>${JSON.stringify(data, null, 2)}</pre>`, data.success ? 'success' : 'error');
            } catch (error) {
                showResult('result2', `Error: ${error.message}`, 'error');
            }
        }

        async function testDisponibilidad() {
            const fecha = document.getElementById('fechaDisponibilidad').value;
            if (!fecha) {
                showResult('result3', 'Por favor selecciona una fecha', 'error');
                return;
            }
            showLoading('result3');
            try {
                const response = await fetch('n8n_webhook_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        accion: 'consultar_disponibilidad',
                        fecha: fecha
                    })
                });
                const data = await response.json();
                showResult('result3', `<pre>${JSON.stringify(data, null, 2)}</pre>`, data.success ? 'success' : 'error');
            } catch (error) {
                showResult('result3', `Error: ${error.message}`, 'error');
            }
        }

        async function testListarReservas() {
            showLoading('result4');
            try {
                const response = await fetch('n8n_webhook_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        accion: 'listar_reservas',
                        limite: 10
                    })
                });
                const data = await response.json();
                showResult('result4', `<pre>${JSON.stringify(data, null, 2)}</pre>`, data.success ? 'success' : 'error');
            } catch (error) {
                showResult('result4', `Error: ${error.message}`, 'error');
            }
        }

        async function testEstadisticas() {
            showLoading('result5');
            const hoy = new Date();
            const inicio = new Date(hoy.getFullYear(), hoy.getMonth(), 1).toISOString().split('T')[0];
            const fin = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0).toISOString().split('T')[0];

            try {
                const response = await fetch('n8n_webhook_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        accion: 'estadisticas',
                        fecha_inicio: inicio,
                        fecha_fin: fin
                    })
                });
                const data = await response.json();
                showResult('result5', `<pre>${JSON.stringify(data, null, 2)}</pre>`, data.success ? 'success' : 'error');
            } catch (error) {
                showResult('result5', `Error: ${error.message}`, 'error');
            }
        }

        async function testVerificarLogs() {
            showLoading('result6');
            try {
                const response = await fetch('verificar_logs_n8n.php');
                const data = await response.json();
                showResult('result6', `<pre>${JSON.stringify(data, null, 2)}</pre>`, 'success');
            } catch (error) {
                showResult('result6', `Error: ${error.message}`, 'error');
            }
        }

        // Set default date to today
        document.getElementById('fechaDisponibilidad').valueAsDate = new Date();
    </script>
</body>

</html>