<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido | {{ config('app.name') }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Montserrat', sans-serif; 
            background-color: #f5f5f5; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
            margin: 0;
        }

        .container { 
            max-width: 1140px; 
            margin: 0 auto; 
            padding: 0 20px; 
            width: 100%; 
        }
        
        /* Banner */
        .chiapas-banner { 
            background-color: #000; 
            padding: 10px 0; 
            border-bottom: 3px solid #009887; 
        }
        .banner-flex { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
        }
        .banner-text { 
            color: white; 
            font-weight: 700; 
            font-size: 14px; 
            letter-spacing: 1px;
        }

        /* header */
        header { 
            background-color: white; 
            border-bottom: 2px solid #009887; 
            padding: 20px 0; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
        }
        .header-text h1 { 
            font-size: 26px; 
            color: #009887; 
            font-weight: 700; 
        }

        /* Cuerpo principal*/
        .main-content { 
            flex: 1; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            justify-content: flex-start; 
            padding-top: 50px; 
            padding-bottom: 80px;
        }

        .welcome-title {
            text-align: center;
            margin-bottom: 40px;
        }
        .welcome-title h2 { font-size: 32px; font-weight: 700; margin-bottom: 10px; }
        .welcome-title p { color: #666; font-size: 16px; }

        /* tarjeta de login */
        .auth-card { 
            background: white; 
            border-radius: 12px; 
            padding: 50px 40px; 
            width: 100%;
            max-width: 450px; 
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
        }

        /* icono de usuario */
        .user-avatar-circle {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #009887, #007d6f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: white;
            box-shadow: 0 5px 15px rgba(0, 152, 135, 0.3);
        }

        .auth-card h3 { font-size: 24px; font-weight: 700; margin-bottom: 10px; color: #333; }
        .auth-card p.instruction { color: #777; font-size: 14px; margin-bottom: 30px; line-height: 1.5; }

        /* boton magenta */
        .auth-button { 
            display: block; 
            width: 100%;
            padding: 15px; 
            background-color: #C90166; 
            color: white; 
            text-decoration: none; 
            border-radius: 6px; 
            font-weight: 700; 
            font-size: 16px;
            transition: background 0.3s ease;
        }
        .auth-button:hover { background-color: #a30152; }

        /* footer de registro */
        .register-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .register-footer p { font-size: 14px; color: #666; }
        .register-footer a { 
            color: #009887; 
            font-weight: 700; 
            text-decoration: none; 
        }
        .register-footer a:hover { text-decoration: underline; }
        
        footer { 
            background-color: #222; 
            color: #999; 
            padding: 30px 0; 
            text-align: center; 
            font-size: 13px; 
        }
    </style>
</head>
<body>

    <div class="chiapas-banner">
        <div class="container banner-flex">
            <img src="{{ asset('images/escudo-icono.png') }}" alt="Escudo Chiapas" style="height: 45px;">
            <div class="banner-text">CHIAPAS.GOB.MX</div>
        </div>
    </div>

    <header>
        <div class="container">
            <div class="header-text">
                <h1>Portal de Empleados</h1>
            </div>
        </div>
    </header>

    <div class="main-content">
        <div class="welcome-title">
        </div>

        <div class="auth-card">
            <div class="user-avatar-circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                </svg>
            </div>

            <h3>Bienvenido</h3>
            <p class="instruction">Inicie sesión para acceder al portal</p>
            
            <a href="{{ route('login') }}" class="auth-button">Iniciar Sesión</a>
            
            @if (Route::has('register'))
                <div class="register-footer">
                    <p>
                        ¿Todavía no tienes cuenta? <br>
                        <a href="{{ route('register') }}">regístrate aquí</a>
                    </p>
                </div>
            @endif
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Gobierno del Estado de Chiapas</p>
        </div>
    </footer>

</body>
</html>