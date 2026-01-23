<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | glow belleza</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,400&family=Montserrat:wght@200;400;500&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="cursor-dot" id="cursor-dot"></div>
    <div class="cursor-outline" id="cursor-outline"></div>

    <header id="navbar">
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Volver al Inicio</a></li>
            </ul>
        </nav>
    </header>

    <section class="login-section">
        <div class="login-container">
            <div class="form-box login" style="display: none;">
                <h2>Iniciar Sesión</h2>
                <form action="auth_login.php" method="POST">
                    <div class="input-box">
                        <input type="email" name="email" required placeholder="Correo Electrónico">
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" required placeholder="Contraseña">
                    </div>
                    <button type="submit" class="cta-button">Entrar</button>
                    <div class="switch-link">
                        <p>¿No tienes cuenta? <a href="#" id="show-register">Regístrate</a></p>
                    </div>
                </form>
            </div>

            <div class="form-box register">
                <h2>Crear Cuenta</h2>
                <form action="auth_register.php" method="POST">
                    <div class="input-box">
                        <input type="text" name="nombre" required placeholder="Nombre Completo">
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" required placeholder="Correo Electrónico">
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" required placeholder="Contraseña">
                    </div>
                    <button type="submit" class="cta-button">Registrarse</button>
                    <div class="switch-link">
                        <p>¿Ya tienes cuenta? <a href="#" id="show-login">Inicia Sesión</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
    <script>
        const loginForm = document.querySelector('.form-box.login');
        const registerForm = document.querySelector('.form-box.register');
        const showRegister = document.getElementById('show-register');
        const showLogin = document.getElementById('show-login');

        showRegister.addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        });

        showLogin.addEventListener('click', (e) => {
            e.preventDefault();
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
        });
    </script>
</body>

</html>