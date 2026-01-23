# 🌟 Guía de Integración  - Glow Belleza

Esta guía te ayudará a configurar e implementar la automatización completa del sistema de reservas utilizando .

## 📋 Tabla de Contenidos

1. [Requisitos Previos](#requisitos-previos)
2. [Configuración de Base de Datos](#configuración-de-base-de-datos)
3. [Configuración de ](#configuración-de-)
4. [Importar Workflows](#importar-workflows)
5. [Configurar Credenciales](#configurar-credenciales)
6. [Testing y Verificación](#testing-y-verificación)
7. [Solución de Problemas](#solución-de-problemas)

---

## 🔧 Requisitos Previos

### Software Necesario
- **XAMPP** con PHP 7.4+ y MySQL
- **cURL** habilitado en PHP
- **Cuenta **: https://nathacc18.app..cloud
- **Cuenta de email** (Gmail recomendado) para envío de notificaciones

### Archivos del Proyecto
Asegúrate de tener estos archivos en tu proyecto:
- `_webhook_handler.php` - Endpoint receptor
- `_send_data.php` - Helper para enviar datos
- `setup__tables.php` - Instalador de tablas
- `_workflow_reservas.json` - Workflow de reservas
- `_workflow_recordatorios.json` - Workflow de recordatorios

---

## 🗄️ Configuración de Base de Datos

### Paso 1: Ejecutar Setup de Tablas

1. Abre tu navegador y ve a:
   ```
   http://localhost/Proyecto_final6t0/nombre-proyecto/setup__tables.php
   ```

2. Verifica que veas mensajes de éxito para las siguientes tablas:
   - ✅ `_logs`
   - ✅ `notificaciones`
   - ✅ `estadisticas_cache`

### Tablas Creadas

#### **_logs**
Registra todas las interacciones con 
```sql
CREATE TABLE _logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    evento VARCHAR(100) NOT NULL,
    datos_enviados TEXT,
    respuesta TEXT,
    estado VARCHAR(20) DEFAULT 'pending',
    fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### **notificaciones**
Historial de notificaciones enviadas
```sql
CREATE TABLE notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT,
    tipo VARCHAR(50) NOT NULL,
    destinatario VARCHAR(100),
    mensaje TEXT,
    estado VARCHAR(20) DEFAULT 'pendiente',
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## ⚙️ Configuración de 

### Paso 1: Acceder a tu Cuenta 

1. Ve a: https://nathacc18.app..cloud
2. Inicia sesión con tus credenciales

### Paso 2: Verificar Webhook URL

Tu webhook ya está configurado:
```
https://nathacc18.app..cloud/webhook-test/24a76578-55f8-421c-b5c6-f754e82b3a53
```

**IMPORTANTE**: Este webhook está hardcodeado en `_send_data.php`. Si cambias la URL, actualiza también el archivo PHP.

---

## 📥 Importar Workflows

### Workflow 1: Procesamiento de Reservas

1. En , haz clic en **"+"** → **"Import from File"**
2. Selecciona: `_workflow_reservas.json`
3. El workflow incluye:
   - ✅ Webhook trigger (recepción de datos)
   - ✅ Validación de datos
   - ✅ Email de confirmación al cliente
   - ✅ Email de notificación al admin
   - ✅ Registro en base de datos

### Workflow 2: Recordatorios Automáticos

1. Importa: `_workflow_recordatorios.json`
2. El workflow incluye:
   - ✅ Cron trigger (diario a las 9:00 AM)
   - ✅ Consulta de reservas del día siguiente
   - ✅ Envío de recordatorios por email
   - ✅ Logging de notificaciones

---

## 🔐 Configurar Credenciales

### Email (Gmail SMTP)

1. En , ve a **Settings** → **Credentials** → **Add Credential**
2. Selecciona **"SMTP"**
3. Configura:
   ```
   Host: smtp.gmail.com
   Port: 587
   Security: TLS
   Usuario: tu-email@gmail.com
   Contraseña: [Contraseña de aplicación de Gmail]
   ```

#### Obtener Contraseña de Aplicación de Gmail

1. Ve a: https://myaccount.google.com/security
2. Habilita **"Verificación en 2 pasos"**
3. Ve a **"Contraseñas de aplicaciones"**
4. Genera una nueva contraseña para "" o "SMTP"
5. Copia la contraseña generada (sin espacios)
6. Úsala en la configuración SMTP de 

### Actualizar Emails en los Workflows

Edita los nodos de email y reemplaza:
- `noreply@glowbelleza.com` → Tu email real
- `admin@glowbelleza.com` → Email del administrador

---

## 🧪 Testing y Verificación

### Test 1: Endpoint Receptor

Verifica que el endpoint receptor funcione correctamente:

```bash
# Windows PowerShell
$headers = @{
    "Content-Type" = "application/json"
}
$body = @{
    accion = "crear_reserva"
    nombre = "Juan Pérez"
    servicio = "natural"
    fecha = "2026-01-25"
    hora = "10:00"
} | ConvertTo-Json

Invoke-WebRequest -Uri "http://localhost/Proyecto_final6t0/nombre-proyecto/_webhook_handler.php" -Method POST -Headers $headers -Body $body
```

**Respuesta Esperada:**
```json
{
  "success": true,
  "message": "Reserva creada exitosamente",
  "data": {
    "reserva_id": 1,
    "codigo": "RES-000001"
  }
}
```

### Test 2: Envío a 

Prueba el envío de datos al webhook de :

```bash
$body = @{
    evento = "test"
    datos = @{
        mensaje = "Prueba de conexión"
    }
} | ConvertTo-Json

Invoke-WebRequest -Uri "http://localhost/Proyecto_final6t0/nombre-proyecto/_send_data.php" -Method POST -Headers $headers -Body $body
```

### Test 3: Flujo Completo

1. Abre: `http://localhost/Proyecto_final6t0/nombre-proyecto/index.php`
2. Ve a la sección **"Reserva tu Cita"**
3. Completa el formulario y envía
4. Verifica en  que el workflow se ejecutó (**Executions** tab)
5. Revisa el email de confirmación en tu bandeja

### Test 4: Verificar Logs

Consulta la tabla de logs:

```sql
SELECT * FROM _logs ORDER BY fecha_hora DESC LIMIT 10;
```

Deberías ver registros de los eventos enviados.

---

## 🔄 Flujo de Datos Completo

### Cuando se Crea una Reserva:

```
Usuario → index.php (form)
    ↓
registro.php (procesa reserva)
    ↓
[INSERTA EN BD]
    ↓
_send_data.php (envía a )
    ↓
WEBHOOK 
    ↓
┌─────────────────────────┐
│ Workflow de Reservas    │
├─────────────────────────┤
│ 1. Validar datos        │
│ 2. Email → Cliente      │
│ 3. Email → Admin        │
│ 4. Log en BD            │
└─────────────────────────┘
```

### Recordatorios Diarios:

```
9:00 AM (Cron Trigger)
    ↓
Workflow Recordatorios
    ↓
api_reservations.php (consulta reservas)
    ↓
Filtrar reservas de mañana
    ↓
Loop por cada reserva
    ↓
Enviar email recordatorio
    ↓
Log en tabla notificaciones
```

---

## 🎨 Personalización de Emails

### Editar Templates

Los emails están en los workflows de . Para personalizarlos:

1. Abre el workflow en 
2. Haz clic en el nodo de email
3. Edita el campo **"Message"** (HTML)
4. Guarda y activa el workflow

### Variables Disponibles

En los templates de email puedes usar:

**Para Confirmación de Reserva:**
- `{{$json.datos.nombre}}` - Nombre del cliente
- `{{$json.datos.servicio}}` - Servicio reservado
- `{{$json.datos.fecha}}` - Fecha de la cita
- `{{$json.datos.hora}}` - Hora de la cita
- `{{$json.datos.codigo_confirmacion}}` - Código de reserva

**Para Recordatorios:**
- `{{$json.nombre_cliente}}`
- `{{$json.servicio}}`
- `{{$json.fecha_formateada}}`
- `{{$json.hora}}`

---

## 📊 Endpoints Disponibles

### _webhook_handler.php

Endpoint receptor que acepta POST con JSON.

**Acciones Soportadas:**

#### 1. Crear Reserva
```json
{
  "accion": "crear_reserva",
  "nombre": "María García",
  "servicio": "soft-glam",
  "fecha": "2026-01-26",
  "hora": "15:00"
}
```

#### 2. Consultar Disponibilidad
```json
{
  "accion": "consultar_disponibilidad",
  "fecha": "2026-01-26"
}
```

#### 3. Listar Reservas
```json
{
  "accion": "listar_reservas",
  "limite": 20,
  "fecha_desde": "2026-01-22"
}
```

#### 4. Estadísticas
```json
{
  "accion": "estadisticas",
  "fecha_inicio": "2026-01-01",
  "fecha_fin": "2026-01-31"
}
```

### _send_data.php

Helper function para enviar datos a .

**Uso en PHP:**

```php
include_once '_send_data.php';

$resultado = enviarA('nuevo_evento', [
    'campo1' => 'valor1',
    'campo2' => 'valor2'
]);

if ($resultado['success']) {
    echo "Enviado exitosamente";
} else {
    echo "Error: " . $resultado['message'];
}
```

---

## 🐛 Solución de Problemas

### Problema: "Error de conexión al enviar a "

**Solución:**
1. Verifica que cURL esté habilitado en PHP: `php -i | findstr curl`
2. Verifica la URL del webhook en `_send_data.php`
3. Asegúrate de que  esté accesible desde tu servidor

### Problema: "No se reciben emails"

**Solución:**
1. Verifica credenciales SMTP en 
2. Revisa que usaste una "contraseña de aplicación" de Gmail (no tu contraseña normal)
3. Verifica que el workflow esté **activo** en 
4. Revisa el log de ejecuciones en  para ver errores

### Problema: "Tabla _logs no existe"

**Solución:**
1. Ejecuta: `http://localhost/Proyecto_final6t0/nombre-proyecto/setup__tables.php`
2. Verifica que la base de datos "registro" exista
3. Revisa permisos de usuario MySQL

### Problema: "Workflow no se ejecuta automáticamente"

**Solución:**
1. Verifica que el workflow esté **activo** (botón switch ON)
2. Para el cron de recordatorios, confirma que el trigger esté configurado correctamente
3. Revisa el log de  para ver si hay errores

### Problema: "Datos no llegan al webhook"

**Solución:**
1. Prueba el endpoint directamente con cURL/Postman
2. Revisa los logs: `SELECT * FROM _logs ORDER BY id DESC LIMIT 5;`
3. Verifica que `allow_url_fopen` esté habilitado en php.ini

---

## 📞 URLs y Recursos Importantes

- **Proyecto Local**: http://localhost/Proyecto_final6t0/nombre-proyecto/
- **Setup Tables**: http://localhost/Proyecto_final6t0/nombre-proyecto/setup__tables.php
- **Webhook Handler**: http://localhost/Proyecto_final6t0/nombre-proyecto/_webhook_handler.php
- ** Dashboard**: https://nathacc18.app..cloud
- **Webhook URL**: https://nathacc18.app..cloud/webhook-test/24a76578-55f8-421c-b5c6-f754e82b3a53

---

## ✨ Próximas Mejoras Sugeridas

1. **Integración WhatsApp**: Usar WhatsApp Business API para recordatorios
2. **Google Calendar**: Sincronizar reservas con Google Calendar
3. **Dashboard de Métricas**: Crear dashboard en  con estadísticas en tiempo real
4. **SMS Notifications**: Integrar Twilio para confirmaciones por SMS
5. **Cancelación Automática**: Workflow para procesar cancelaciones
6. **Encuestas Post-Servicio**: Enviar encuestas de satisfacción automáticamente

---

## 📝 Notas de Seguridad

- ⚠️ El webhook está expuesto públicamente - considera agregar autenticación
- 🔒 Las contraseñas SMTP deben guardarse de forma segura
- 🔐 Valida siempre los datos de entrada en los endpoints
- 📊 Los logs pueden contener información sensible - limpia regularmente

---

**¡Listo!** Tu sistema de automatización con  está completamente configurado. 🎉
