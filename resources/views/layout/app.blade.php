<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phaqchas - Campo Deportivo</title>
    <meta name="description" content="Campo deportivo las Phaqchas - Tu lugar para entrenar.">
    <meta name="keywords" content="deporte, fitness, Phaqchas, entrenamiento">
    <meta name="application-name" content="Phaqchas">
    <meta name="author" content="Tu Nombre">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://phaqchas.shop/">
    <meta property="og:title" content="Phaqchas - Campo Deportivo">
    <meta property="og:description" content="Campo deportivo las Phaqchas - Tu lugar para entrenar.">
    <meta property="og:site_name" content="Phaqchas">
    <meta property="og:image" content="/logo.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <link rel="icon" href="{{ asset('images/volleyball.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/volleyball.png') }}">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- @vite('resources/css/app.css') -->
     <link rel="stylesheet" href="{{ asset('build/assets/app-B3mP7iRK.css') }}">
     <script src="{{ asset('build/assets/app-CqflisoM.js') }}"></script>
    <style>
        #mobile-menu {
            position: fixed;
            top: 0;
            left: -100%;
            width: 250px;
            height: 100%;
            background-color: #111;
            transition: left 0.3s ease-in-out;
            z-index: 100;
            padding-top: 80px;
        }

        #mobile-menu ul {
            list-style-type: none;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        #mobile-menu ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2rem;
            display: block;
        }

        #mobile-menu.open {
            left: 0;
        }

        .menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 90;
            display: none;
        }

        .menu-overlay.active {
            display: block;
        }

        a {
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        .active-link {
            color: #1f9d1c;
            font-weight: bold;
        }
    </style>
</head>

<body class="min-h-svh bg-primary-">

    <x-header></x-header>
    <div id="menu-overlay" class="menu-overlay"></div>

    <div class="bg-gray-200">
        @yield('content')
    </div>

   <x-footer></x-footer>


</body>

</html>