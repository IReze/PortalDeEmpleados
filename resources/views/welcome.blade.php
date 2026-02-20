<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal de Empleados</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            html, body {
                height: 100%;
                width: 100%;
            }

            body {
                font-family: 'Roboto', sans-serif;
                background-color: #f5f5f5;
                color: #0C0206;
                line-height: 1.428;
                font-size: 16px;
                display: flex;
                flex-direction: column;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
                width: 100%;
            }

            /* BANNER CHIAPAS */
            .chiapas-banner {
                background-color: #000000;
                padding: 15px 0;
                border-bottom: 2px solid #009887;
            }

            .banner-flex {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
            }

            .banner-logo-space {
                height: 50px;
                display: flex;
                align-items: center;
                min-width: 150px;
            }

            .banner-logo-space img {
                max-height: 50px;
                max-width: 150px;
                object-fit: contain;
            }

            .banner-text {
                color: white;
                font-size: 18px;
                font-weight: 700;
                letter-spacing: 1px;
            }

            /* ACCESSIBILITY TOOLBAR */
            .accessibility-bar {
                background-color: #009887;
                color: white;
                padding: 12px 20px;
                text-align: right;
                font-size: 13px;
            }

            .accessibility-bar a {
                color: white;
                text-decoration: none;
                margin-left: 25px;
                padding: 5px 10px;
                border: 1px solid rgba(255,255,255,0.3);
                border-radius: 3px;
                transition: all 0.3s ease;
            }

            .accessibility-bar a:hover {
                background-color: rgba(255,255,255,0.2);
            }

            /* HEADER / BANNER */
            header {
                background-color: white;
                border-bottom: 4px solid #009887;
                padding: 25px 0;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }

            .header-content {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 30px;
            }

            .logo-section {
                display: flex;
                align-items: center;
                gap: 20px;
                flex: 1;
            }

            .logo-placeholder {
                width: 80px;
                height: 80px;
                background-color: #f0f0f0;
                border: 2px solid #ddd;
                border-radius: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #999;
                font-size: 12px;
                font-weight: 500;
                text-align: center;
            }

            .header-text h1 {
                font-size: 26px;
                font-weight: 700;
                color: #009887;
                margin: 0 0 5px 0;
            }

            .header-text p {
                font-size: 14px;
                color: #666;
                margin: 0;
            }

            /* MAIN CONTENT */
            .main-content {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 60px 20px;
                background-color: #f5f5f5;
                width: 100%;
                min-height: calc(100vh - 180px);
            }

            .auth-container {
                width: 100%;
                max-width: 1000px;
            }

            .auth-title {
                text-align: center;
                margin-bottom: 60px;
            }

            .auth-title h2 {
                font-size: 32px;
                font-weight: 700;
                color: #0C0206;
                margin-bottom: 10px;
            }

            .auth-title p {
                font-size: 16px;
                color: #666;
            }

            .auth-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 40px;
            }

            .auth-card {
                background: white;
                border-radius: 4px;
                padding: 50px 35px;
                text-align: center;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                border: 1px solid #e0e0e0;
                transition: all 0.3s ease;
            }

            .auth-card:hover {
                box-shadow: 0 4px 16px rgba(0,0,0,0.12);
                border-color: #009887;
            }

            .auth-icon {
                width: 80px;
                height: 80px;
                background-color: #009887;
                border-radius: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 30px;
            }

            .auth-icon svg {
                width: 44px;
                height: 44px;
                color: white;
                stroke-width: 2;
            }

            .auth-card h3 {
                font-size: 24px;
                font-weight: 700;
                color: #0C0206;
                margin-bottom: 15px;
            }

            .auth-card p {
                color: #666;
                font-size: 15px;
                line-height: 1.6;
                margin-bottom: 30px;
            }

            .auth-button {
                display: inline-block;
                padding: 14px 50px;
                background-color: #C90166;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                font-weight: 600;
                font-size: 15px;
                transition: all 0.3s ease;
                border: 2px solid #C90166;
                cursor: pointer;
            }

            .auth-button:hover {
                background-color: #a80151;
                border-color: #a80151;
            }

            .auth-button:active {
                transform: scale(0.98);
            }

            /* FOOTER */
            footer {
                background-color: #0C0206;
                color: white;
                padding: 30px 0;
                text-align: center;
                font-size: 13px;
                margin-top: auto;
            }

            footer p {
                margin: 5px 0;
            }

            footer a {
                color: #009887;
                text-decoration: none;
            }

            footer a:hover {
                text-decoration: underline;
            }

            /* RESPONSIVE */
            @media (max-width: 768px) {
                .auth-grid {
                    grid-template-columns: 1fr;
                    gap: 30px;
                }

                .header-content {
                    flex-direction: column;
                    gap: 15px;
                }

                .logo-placeholder {
                    width: 70px;
                    height: 70px;
                }

                .header-text h1 {
                    font-size: 22px;
                }

                .auth-title h2 {
                    font-size: 26px;
                }

                .auth-card {
                    padding: 40px 25px;
                }

                .auth-card h3 {
                    font-size: 20px;
                }

                .main-content {
                    padding: 50px 20px;
                }
            }

            @media (max-width: 480px) {
                .accessibility-bar {
                    padding: 10px 15px;
                }

                .accessibility-bar a {
                    display: block;
                    margin: 8px 0;
                    margin-left: 0;
                }

                header {
                    padding: 15px 0;
                }

                .logo-placeholder {
                    width: 60px;
                    height: 60px;
                    font-size: 11px;
                }

                .header-text h1 {
                    font-size: 18px;
                }

                .auth-title h2 {
                    font-size: 22px;
                }

                .auth-card {
                    padding: 30px 20px;
                }

                .auth-card h3 {
                    font-size: 18px;
                }

                .auth-button {
                    padding: 12px 30px;
                    font-size: 14px;
                }

                .auth-icon {
                    width: 70px;
                    height: 70px;
                }

                .auth-icon svg {
                    width: 36px;
                    height: 36px;
                }
            }
        </style>
    </head>
    <body>
        <!-- BANNER CHIAPAS NEGRO -->
        <div class="chiapas-banner">
            <div class="container">
                <div class="banner-flex">
                    <div class="banner-logo-space">
                        <img src="../images/escudo-icono.png" alt="Logo Chiapas">
                    </div>
                    <div class="banner-text">
                        CHIAPAS.GOB.MX
                    </div>
                </div>
            </div>
        </div>

        <!-- HEADER -->
        <header>
            <div class="container">
                <div class="header-content">
                        <div class="header-text">
                            <h1>Portal de Empleados</h1>
                           
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container">
                <div class="auth-container">
                    <div class="auth-title">
                        <h2>Bienvenido</h2>
                        <p>Selecciona una opción para continuar</p>
                    </div>

                    <div class="auth-grid">
                        <!-- TARJETA INICIAR SESIÓN -->
                        <div class="auth-card">
                            <div class="auth-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                            </div>
                            <h3>Iniciar Sesión</h3>
                            <p>Accede a tu cuenta con tu correo corporativo y contraseña</p>
                            <a href="{{ route('login') }}" class="auth-button">Entrar</a>
                        </div>

                        <!-- TARJETA REGISTRARSE -->
                        @if (Route::has('register'))
                        <div class="auth-card">
                            <div class="auth-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                            </div>
                            <h3>Registrarse</h3>
                            <p>Crea tu cuenta (Necesitas ser un empleado activo)</p>
                            <a href="{{ route('register') }}" class="auth-button">Registrarse</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer>
            <div class="container">
                <p>&copy; 2026 Gobierno del Estado - Todos los derechos reservados</p>
                <p><a href="#">Privacidad</a> | <a href="#">Términos de uso</a> | <a href="#">Contacto</a></p>
            </div>
        </footer>
    </body>
</html>
