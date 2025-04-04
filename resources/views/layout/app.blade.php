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
    
    <link rel="stylesheet" href="{{ asset('build/assets/app-CKXJyYSt.css') }}">

    <script type="module" src="{{ asset('build/assets/app-CqflisoM.js') }}" defer></script>

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
            color: #84cc16;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body class="min-h-svh bg-primary-">

    <header id="header"
        class="flex justify-between items-center p-4 h-20 fixed top-0 w-full shadow-xl z-50 transition-all duration-500">
        <a href="{{ route('home') }}" class="flex gap-x-2 items-center justify-center">
            <img src="{{ asset('images/volleyball.png') }}" alt="" class="h-10">
            <h2 class="uppercase font-bold text-lime-600 font-bungee text-2xl">phaqchas</h2>
        </a>
        @if (Request::is('/'))
            <nav class="hidden lg:flex gap-4 items-center">
                <ul class="flex gap-4">
                    <li><a href="#inicio"
                            class="font-semibold text-white hover:text-lime-600 hover:underline transition-all text-lg">Inicio</a>
                    </li>
                    <li><a href="#anuncios"
                            class="font-semibold text-white hover:text-lime-600 hover:underline transition-all text-lg">Anuncios</a>
                    </li>
                    <li><a href="#deportes"
                            class="font-semibold text-white hover:text-lime-600 hover:underline transition-all text-lg">Deportes</a>
                    </li>
                    <li><a href="#donde-estamos"
                            class="font-semibold text-white hover:text-lime-600 hover:underline transition-all text-lg">Donde
                            estamos</a></li>
                    <li><a href="{{ route('booking') }}"
                            class="font-semibold text-white hover:text-lime-600 hover:underline transition-all text-lg">Reservas</a>
                    </li>
                </ul>
            </nav>

            <button id="hamburger" class="lg:hidden text-white p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        @endif
    </header>

    <div id="mobile-menu" class="">
        <a href="{{ route('home') }}" class="flex gap-x-2 items-center justify-center">
            <img src="{{ asset('images/volleyball.png') }}" alt="" class="h-10">
            <h2 class="uppercase font-bold text-lime-600 font-bungee text-2xl">phaqchas</h2>
        </a>
        <ul>
            <li><a href="#inicio" class="hover:text-lime-600">Inicio</a></li>
            <li><a href="#anuncios" class="hover:text-lime-600">Anuncios</a></li>
            <li><a href="#deportes" class="hover:text-lime-600">Deportes</a></li>
            <li><a href="#donde-estamos" class="hover:text-lime-600">Donde estamos</a></li>
            <li><a href="{{ route('booking') }}" class="hover:text-lime-600">Reservas</a></li>
        </ul>
    </div>
    <div id="menu-overlay" class="menu-overlay"></div>

    <div class="bg-gray-200">
        @yield('content')
    </div>

    <footer class="bg-black/90 text-white pt-10 pb-6 mt-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
          
            <div>
                <img src="{{ asset('/images/logo.jpeg') }}" alt="Phaqchas logo" class="w-68 h-20 mb-4">
                <h2 class="text-xl font-semibold mb-2">Phaqchas</h2>
                <p class="text-sm text-gray-300">Campo deportivo Las Phaqchas - Tu lugar ideal para entrenar, competir y disfrutar en comunidad.</p>
            </div>
    
            <div>
                <h2 class="text-lg font-semibold mb-3">Contacto</h2>
                <p class="text-sm">📍 Prolongación arica, Apurimác, Perú</p>
                <p class="text-sm">📞 +51 987 654 321</p>
                <p class="text-sm">✉️ phaqchas@gmail.com</p>
                <a href="https://wa.me/51987654321" target="_blank" class="inline-block mt-3 hover:underline">💬 Escríbenos por WhatsApp</a>
            </div>
    
            <div>
                <h2 class="text-lg font-semibold mb-3">Síguenos</h2>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/p/Phaqchas-Campo-Deportivo-100071535564464/" target="_blank" aria-label="Facebook" class="text-white hover:text-blue-500">
                        <svg class="w-6 h-6 fill-current text-white hover:text-blue-500" viewBox="0 0 24 24">
                            <path d="M22 12A10 10 0 1 0 12 22v-7h-2v-3h2v-2c0-1.7 1-3 3-3h2v3h-2c-.4 0-1 .2-1 1v1h3l-.5 3h-2.5v7a10 10 0 0 0 10-10z"/>
                        </svg>
                    </a>
                    <a href="https://instagram.com/phaqchas" target="_blank" aria-label="Instagram" class="text-white hover:text-pink-400">
                        <svg class="w-6 h-6 fill-current text-white hover:text-pink-400" viewBox="0 0 24 24">
                            <path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.9.3 2.3.5.6.3 1.1.7 1.5 1.2.4.4.9.9 1.2 1.5.2.4.4 1.1.5 2.3.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.3 1.9-.5 2.3a4.4 4.4 0 0 1-2.7 2.7c-.4.2-1.1.4-2.3.5-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.9-.3-2.3-.5a4.4 4.4 0 0 1-2.7-2.7c-.2-.4-.4-1.1-.5-2.3C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.9c.1-1.2.3-1.9.5-2.3a4.4 4.4 0 0 1 2.7-2.7c.4-.2 1.1-.4 2.3-.5C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.1 0-3.5 0-4.7.1-1 .1-1.5.2-1.9.4-.5.2-.9.5-1.3.9-.4.4-.7.8-.9 1.3-.2.4-.3.9-.4 1.9C3.5 9.5 3.5 9.9 3.5 12s0 2.5.1 3.7c.1 1 .2 1.5.4 1.9.2.5.5.9.9 1.3.4.4.8.7 1.3.9.4.2.9.3 1.9.4 1.2.1 1.6.1 4.7.1s3.5 0 4.7-.1c1-.1 1.5-.2 1.9-.4.5-.2.9-.5 1.3-.9.4-.4.7-.8.9-1.3.2-.4.3-.9.4-1.9.1-1.2.1-1.6.1-4.7s0-3.5-.1-4.7c-.1-1-.2-1.5-.4-1.9a3 3 0 0 0-2.2-2.2c-.4-.2-.9-.3-1.9-.4C15.5 4 15.1 4 12 4zm0 3a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 1.8a3.2 3.2 0 1 0 0 6.4 3.2 3.2 0 0 0 0-6.4zm4.8-1a1.2 1.2 0 1 1-2.4 0 1.2 1.2 0 0 1 2.4 0z"/>
                        </svg>
                    </a>
                </div>
                
            </div>
        </div>
    
        <div class="border-t border-gray-700 mt-10 pt-4 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} Phaqchas. Todos los derechos reservados.
        </div>
    </footer>
    

    
</body>

</html>
