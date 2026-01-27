<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>glow belleza | Makeup Artistry</title>
    <link rel="stylesheet" href="style.css?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,400&family=Montserrat:wght@200;400;500&display=swap"
        rel="stylesheet">
    <meta name="description"
        content="Descubre la belleza atemporal con glow belleza. Maquillaje de alta gama para la mujer moderna.">
</head>

<body>
    <div class="cursor-dot" id="cursor-dot"></div>
    <div class="cursor-outline" id="cursor-outline"></div>

    <header id="navbar">
        <div class="logo-container">
            <a href="#hero">
                <img src="logo_estudio.jpg" alt="Glow Belleza Logo" class="logo-img-circular">
            </a>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="#hero">Inicio</a></li>
                <li><a href="#collection">Colección</a></li>
                <li><a href="#about">Sobre Nosotros</a></li>
                <li><a href="#contact">Contacto</a></li>
                <li><a href="#booking" class="nav-cta">Citas</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="#" style="color: var(--primary-color);">Hola,
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </a></li>
                    <li><a href="logout.php" style="font-size: 0.8rem;">Salir</a></li>
                <?php else: ?>
                    <li><a href="login.php">Iniciar Sesión</a></li>
                    <li><a href="login.php?mode=register" style="font-weight: 500;">Registrar</a></li>
                <?php endif; ?>
                <li>
                    <button id="cart-btn" class="cart-trigger">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4H6zM3 6h18M16 10a4 4 0 01-8 0"></path>
                        </svg>
                        <span id="cart-count">0</span>
                    </button>
                </li>
            </ul>
        </nav>
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </header>

    <section id="hero" class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="fade-in">Redefine tu <span class="highlight">Esencia</span></h1>
            <p class="fade-in delay-1">Lujo, arte y belleza en cada trazo.</p>
            <a href="#collection" class="cta-button fade-in delay-2">Descubrir Colección</a>
        </div>
    </section>

    <section id="collection" class="section-padding">
        <div class="container">
            <h2 class="section-title">Colección</h2>
            <div class="product-grid">
                <div class="product-card">
                    <img src="imagen1.jpg" alt="Velvet Matte Lipstick" class="product-img">
                    <h3>NATURAL</h3>
                    <p class="price">$500</p>
                    <button class="add-cart">Añadir</button>
                </div>
                <div class="product-card">
                    <img src="imagen2.jpg" alt="Luminous Foundation" class="product-img">
                    <h3>SOFT GLAM</h3>
                    <p class="price">$600</p>
                    <button class="add-cart">Añadir</button>
                </div>
                <div class="product-card">
                    <img src="imagen3.jpg" alt="Radiant Glow Palette" class="product-img">
                    <h3>SMOHEY EYES</h3>
                    <p class="price">$1200</p>
                    <button class="add-cart">Añadir</button>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="section-padding philosophy-section">
        <div class="container split-layout">
            <div class="text-content">
                <h2 class="section-title">Sobre Nosotros</h2>
                <p>En Glow Belleza, nuestra <strong>Fortaleza</strong> reside en la combinación de técnica avanzada y un
                    profundo entendimiento de la belleza individual. Nos dedicamos a resaltar lo mejor de cada persona
                    con un toque de lujo y exclusividad.</p>
                <div class="fortalezas-grid">
                    <div class="fortaleza-item">
                        <h4>Atención Personalizada</h4>
                        <p>Cada servicio es diseñado a medida para tus rasgos y estilo.</p>
                    </div>
                    <div class="fortaleza-item">
                        <h4>Productos Premium</h4>
                        <p>Utilizamos solo las mejores marcas de la industria.</p>
                    </div>
                </div>
                <a href="#contact" class="text-link">Contáctanos</a>
            </div>
            <img src="imagen4.jpg" alt="Filosofía LUMIÈRE" class="philosophy-img">
        </div>
    </section>

    <section id="booking" class="section-padding booking-section">
        <div class="container">
            <h2 class="section-title">Reserva tu Cita</h2>
            <form class="booking-form" action="registro.php" method="POST" id="bookingForm">
                <input type="hidden" name="hora" id="selectedHora" required>

                <div class="form-group">
                    <input type="text" name="nombre" placeholder="Nombre Completo"
                        value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>"
                        required>
                    <!-- Eliminado telefono ya que no está en la tabla reservas nueva, o podemos dejarlo si se requiere -->
                    <!-- Si el usuario lo pidió, podemos agregarlo, pero por ahora nos ceñimos a lo básico funcional -->
                </div>

                <div class="form-group">
                    <select name="servicio" required>
                        <option value="" disabled selected>Selecciona Servicio</option>
                        <option value="natural">Natural - $500</option>
                        <option value="soft-glam">Soft Glam - $600</option>
                        <option value="smokey-eyes">Smokey Eyes - $1200</option>
                    </select>
                </div>

                <!-- Wrapper oculto para el input de fecha (para enviar con el form) -->
                <input type="hidden" name="fecha" id="bookingDateInput" required>

                <div class="booking-layout">
                    <!-- Sección del Calendario -->
                    <div class="calendar-section">
                        <div class="calendar-container">
                            <div class="calendar-header">
                                <button type="button" class="calendar-nav-btn" id="prevMonth">&lt;</button>
                                <h3 id="calendarMonthYear">Mes Año</h3>
                                <button type="button" class="calendar-nav-btn" id="nextMonth">&gt;</button>
                            </div>
                            <div class="calendar-grid-header">
                                <div>Dom</div>
                                <div>Lun</div>
                                <div>Mar</div>
                                <div>Mié</div>
                                <div>Jue</div>
                                <div>Vie</div>
                                <div>Sáb</div>
                            </div>
                            <div class="calendar-grid" id="calendarGrid">
                                <!-- JS generará los días aquí -->
                            </div>
                        </div>

                        <!-- Time Slots (Debajo del calendario) -->
                        <div class="hours-container" id="hoursGrid" style="display: none;">
                            <p style="color: #666; margin-bottom: 1rem; text-align: center; font-size: 0.9rem;">
                                HORAS DISPONIBLES PARA <span id="selectedDateDisplay"
                                    style="color:#fff; font-weight: 500;"></span>
                            </p>
                            <div class="hours-grid" id="hoursGridContainer">
                                <!-- JS generará las horas -->
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Citas (Debajo del calendario en desktop también) -->
                    <div class="appointments-section">
                        <h4 class="list-header">Citas Agendadas</h4>
                        <div id="appointmentList" class="appointment-list-grid">
                            <p style="color: #444; text-align: center; grid-column: 1/-1;">Cargando...</p>
                        </div>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 3rem;">
                    <button type="submit" class="cta-button" style="width: 100%; max-width: 400px;">Confirmar
                        Reserva</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Cajón del Carrito -->
    <div id="cart-drawer" class="cart-drawer">
        <div class="cart-header">
            <h3>Tu Carrito</h3>
            <button id="close-cart">&times;</button>
        </div>
        <div id="cart-items" class="cart-items">
            <!-- Los artículos se añaden aquí -->
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="total-price">$0</span>
            </div>
            <button class="checkout-btn">Finalizar Compra</button>
        </div>
    </div>
    <div id="cart-overlay" class="cart-overlay"></div>

    <!-- Sección de Mensaje n8n -->
    <section id="n8n-message" class="section-padding">
        <div class="container">
            <h2 class="section-title">Enviar Mensaje Directo</h2>
            <div class="message-form-container">
                <form id="n8n-form">
                    <div class="form-group">
                        <input type="text" id="msg-nombre" placeholder="Tu Nombre" required>
                    </div>
                    <div class="form-group">
                        <textarea id="msg-contenido" placeholder="Escribe tu mensaje aquí..." required></textarea>
                    </div>
                    <button type="submit" class="cta-button">Enviar a n8n</button>
                </form>
                <div id="n8n-status" class="status-msg"></div>
            </div>
        </div>
    </section>

    <!-- ... Pie de página ... -->

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const calendarGrid = document.getElementById('calendarGrid');
            const monthYearTitle = document.getElementById('calendarMonthYear');
            const prevBtn = document.getElementById('prevMonth');
            const nextBtn = document.getElementById('nextMonth');
            const bookingDateInput = document.getElementById('bookingDateInput');
            const selectedDateDisplay = document.getElementById('selectedDateDisplay');
            const hoursGrid = document.getElementById('hoursGrid');
            const hoursGridContainer = document.getElementById('hoursGridContainer');
            const selectedHoraInput = document.getElementById('selectedHora');
            const appointmentList = document.getElementById('appointmentList');

            let currentDate = new Date();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();
            let reservations = [];

            // Horas de trabajo
            const businessHours = [
                "09:00", "10:00", "11:00", "12:00", "13:00",
                "14:00", "15:00", "16:00", "17:00", "18:00"
            ];

            // 1. Obtener Reservas
            async function fetchReservations() {
                try {
                    const res = await fetch('api_reservations.php');
                    reservations = await res.json();
                    renderAppointmentList();
                    renderCalendar(currentMonth, currentYear);
                } catch (err) {
                    console.error("Error loading reservations:", err);
                    appointmentList.innerHTML = '<p style="color:red; font-size:0.8rem;">Error cargando citas.</p>';
                }
            }

            // 2. Renderizar Lista de Citas (Minimalista, Enfocado en la Privacidad)
            function renderAppointmentList() {
                appointmentList.innerHTML = '';

                // Filtrar solo las futuras (desde hoy en adelante)
                const todayStr = new Date().toISOString().split('T')[0];
                const upcoming = reservations.filter(r => r.fecha >= todayStr).slice(0, 12); // Mostrar hasta 12

                if (upcoming.length === 0) {
                    appointmentList.innerHTML = '<p style="color:#444; font-style:italic; grid-column: 1/-1; text-align:center;">No hay citas próximas.</p>';
                    return;
                }

                upcoming.forEach(res => {
                    const item = document.createElement('div');
                    item.className = 'appointment-item';

                    // Formato de Fecha: "22 Ene"
                    // Corregir el desplazamiento de la zona horaria para la visualización
                    const dateParts = res.fecha.split('-');
                    const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                    const dateStr = dateObj.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });

                    // Limpiar Hora: "14:00" (eliminar segundos si están presentes)
                    const timeStr = res.hora.substring(0, 5);

                    // NO SE MUESTRA EL NOMBRE DEL CLIENTE
                    item.innerHTML = `
                        <div class="appt-date">${dateStr}</div>
                        <div class="appt-time">${timeStr}</div>
                    `;
                    appointmentList.appendChild(item);
                });
            }

            // 3. Renderizar Calendario
            function renderCalendar(month, year) {
                calendarGrid.innerHTML = '';

                // Título
                const monthName = new Date(year, month).toLocaleDateString('es-ES', { month: 'long' });
                monthYearTitle.textContent = `${monthName.charAt(0).toUpperCase() + monthName.slice(1)} ${year}`;

                const firstDay = new Date(year, month, 1).getDay(); // 0 es Domingo
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Espacios vacíos para el mes anterior
                for (let i = 0; i < firstDay; i++) {
                    const empty = document.createElement('div');
                    empty.className = 'calendar-day empty';
                    calendarGrid.appendChild(empty);
                }

                // Días
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayCell = document.createElement('div');
                    dayCell.className = 'calendar-day';

                    // Formato AAAA-MM-DD
                    const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                    // Comprobar si es hoy
                    const todayStr = new Date().toISOString().split('T')[0];
                    if (dateString === todayStr) dayCell.classList.add('today');

                    // Comprobar reservas (Indicador de punto minimalista)
                    const dayReservations = reservations.filter(r => r.fecha === dateString);
                    const hasReservation = dayReservations.length > 0;

                    let html = `<span class="day-number">${day}</span>`;

                    if (hasReservation) {
                        html += `<div class="day-marker"></div>`;
                    }

                    dayCell.innerHTML = html;

                    // Evento de Clic
                    dayCell.addEventListener('click', () => {
                        // Lógica de selección
                        document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('selected'));
                        dayCell.classList.add('selected');

                        bookingDateInput.value = dateString;

                        // Formato de fecha de visualización
                        const dateParts = dateString.split('-');
                        const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                        selectedDateDisplay.textContent = dateObj.toLocaleDateString('es-ES', { weekday: 'long', day: 'numeric', month: 'long' });

                        loadHours(dateString);
                    });

                    calendarGrid.appendChild(dayCell);
                }
            }

            // 4. Lógica de Carga de Horas
            async function loadHours(fecha) {
                hoursGrid.style.display = 'block';
                hoursGridContainer.innerHTML = '<p style="color:#666; font-size:0.8rem;">Cargando...</p>';
                selectedHoraInput.value = "";

                try {
                    const response = await fetch(`api_availability.php?fecha=${fecha}`);
                    const data = await response.json();
                    const reserved = data.reserved || [];

                    hoursGridContainer.innerHTML = '';

                    // Comprobar fecha pasada
                    const dateParts = fecha.split('-');
                    const checkDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (checkDate < today) {
                        hoursGridContainer.innerHTML = '<p style="color:#444; text-align:center; width:100%;">No disponible</p>';
                        return;
                    }

                    businessHours.forEach(hora => {
                        const btn = document.createElement('div');
                        btn.classList.add('time-slot');

                        // Comprobar disponibilidad
                        // Nota: el backend suele devolver H:i:s, o H:i. Vamos a hacer una coincidencia difusa para estar seguros o asumiendo que el formato coincide
                        const isReserved = reserved.some(r => r.startsWith(hora));

                        if (isReserved) {
                            btn.classList.add('reserved');
                            btn.textContent = hora; // Just time, crossed out via CSS
                        } else {
                            btn.classList.add('available');
                            btn.textContent = hora;
                            btn.addEventListener('click', () => {
                                document.querySelectorAll('.time-slot.selected').forEach(el => el.classList.remove('selected'));
                                btn.classList.add('selected');
                                selectedHoraInput.value = hora;
                            });
                        }
                        hoursGridContainer.appendChild(btn);
                    });

                } catch (error) {
                    console.error(error);
                    hoursGridContainer.innerHTML = '<p style="color:red">Error.</p>';
                }
            }

            // Navegación
            prevBtn.addEventListener('click', () => {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar(currentMonth, currentYear);
            });

            nextBtn.addEventListener('click', () => {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar(currentMonth, currentYear);
            });

            // Enviar
            document.getElementById('bookingForm').addEventListener('submit', (e) => {
                if (!bookingDateInput.value || !selectedHoraInput.value) {
                    e.preventDefault();
                    alert('Por favor selecciona una fecha y una hora.');
                }
            });

            // --- Lógica del Carrito de Compras ---
            const cartBtn = document.getElementById('cart-btn');
            const cartDrawer = document.getElementById('cart-drawer');
            const cartOverlay = document.getElementById('cart-overlay');
            const closeCart = document.getElementById('close-cart');
            const cartItemsContainer = document.getElementById('cart-items');
            const cartCount = document.getElementById('cart-count');
            const totalPriceEl = document.getElementById('total-price');

            let cart = JSON.parse(localStorage.getItem('glow_cart') || '[]');

            function updateCartUI() {
                cartItemsContainer.innerHTML = '';
                let total = 0;

                cart.forEach((item, index) => {
                    total += item.price;
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'cart-item';
                    itemDiv.innerHTML = `
                        <div class="cart-item-info">
                            <h5>${item.name}</h5>
                            <span class="price">$${item.price}</span>
                        </div>
                        <button class="remove-item" onclick="removeFromCart(${index})">Eliminar</button>
                    `;
                    cartItemsContainer.appendChild(itemDiv);
                });

                cartCount.textContent = cart.length;
                totalPriceEl.textContent = `$${total}`;
                localStorage.setItem('glow_cart', JSON.stringify(cart));
            }

            window.addToCart = (name, price) => {
                cart.push({ name, price });
                updateCartUI();
                openCartDrawer();
            };

            window.removeFromCart = (index) => {
                cart.splice(index, 1);
                updateCartUI();
            };

            function openCartDrawer() {
                cartDrawer.classList.add('open');
                cartOverlay.classList.add('open');
            }

            function closeCartDrawer() {
                cartDrawer.classList.remove('open');
                cartOverlay.classList.remove('open');
            }

            cartBtn.addEventListener('click', openCartDrawer);
            closeCart.addEventListener('click', closeCartDrawer);
            cartOverlay.addEventListener('click', closeCartDrawer);

            // Añadir eventos de clic a los botones "Añadir" en los productos
            document.querySelectorAll('.product-card').forEach(card => {
                const btn = card.querySelector('.add-cart');
                const name = card.querySelector('h3').textContent;
                const price = parseInt(card.querySelector('.price').textContent.replace('$', ''));

                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    addToCart(name, price);
                });
            });

            updateCartUI();

            // --- Lógica del Formulario de Mensaje n8n ---
            const n8nForm = document.getElementById('n8n-form');
            const n8nStatus = document.getElementById('n8n-status');

            n8nForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const nombre = document.getElementById('msg-nombre').value;
                const mensaje = document.getElementById('msg-contenido').value;

                n8nStatus.textContent = 'Enviando...';
                n8nStatus.className = 'status-msg';

                try {
                    const response = await fetch('ajax_send_n8n.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ nombre, mensaje })
                    });
                    const result = await response.json();

                    if (result.success) {
                        n8nStatus.textContent = '¡Mensaje enviado con éxito!';
                        n8nStatus.classList.add('success');
                        n8nForm.reset();
                    } else {
                        n8nStatus.textContent = 'Error: ' + (result.message || 'No se pudo enviar.');
                        n8nStatus.classList.add('error');
                    }
                } catch (err) {
                    n8nStatus.textContent = 'Error de conexión.';
                    n8nStatus.classList.add('error');
                }
            });

            // Inicio
            await fetchReservations();
        });
    </script>

    <footer id="contact">
        <div class="footer-content">
            <div class="footer-col">
                <h4>Maquillaje Profesional</h4>
                <p>Arte y belleza.</p>
            </div>
            <div class="footer-col">
                <h4>Explorar</h4>
                <a href="#hero">Inicio</a>
                <a href="#collection">Colección</a>
                <a href="#philosophy">Filosofía</a>
                <a href="#booking">Reserva</a>
            </div>
            <div class="footer-col">
                <h4>Contacto</h4>
                <p>info@lumiere.com</p>
                <p><img src="phone-icon.svg" alt="Teléfono"
                        style="width: 1rem; vertical-align: middle; margin-right: 5px;"> 123 456 7890</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 LUMIÈRE Cosmetics. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>