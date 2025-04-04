<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
    <style>
        /* Estilos para el menú tipo "sheet" */
        #mobile-menu {
            position: fixed;
            top: 0;
            left: -100%;
            /* Inicialmente fuera de la pantalla */
            width: 250px;
            height: 100%;
            background-color: #111;
            transition: left 0.3s ease-in-out;
            z-index: 100;
            padding-top: 80px;
            /* Espacio para el header */
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
            /* Cuando el menú se abre */
        }

        /* Overlay para cuando el menú está abierto */
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

        /* Transición suave para los enlaces */
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
    class="flex justify-between items-center p-4 h-20 fixed top-0 w-full shadow-xl opacity-90 z-50 transition-all duration-500">
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

    <footer></footer>

    @if (Request::is('/'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const header = document.getElementById("header");
                const links = document.querySelectorAll("nav ul li a, #mobile-menu ul li a");
                const mobileMenu = document.getElementById("mobile-menu");
                const hamburger = document.getElementById("hamburger");
                const menuOverlay = document.getElementById("menu-overlay");

                function toggleMobileMenu() {
                    mobileMenu.classList.toggle("open");
                    menuOverlay.classList.toggle("active");
                }
                menuOverlay.addEventListener("click", toggleMobileMenu);

                links.forEach(link => {
                    link.addEventListener("click", function(event) {
                        if (this.getAttribute("href").startsWith('#')) {
                            event.preventDefault();
                            const targetId = this.getAttribute("href").substring(1);
                            const targetSection = document.getElementById(targetId);
                            if (targetSection) {
                                window.scrollTo({
                                    top: targetSection.offsetTop - 60,
                                    behavior: "smooth"
                                });
                            }
                        }
                        
                        if (mobileMenu.classList.contains("open")) {
                            toggleMobileMenu();
                        }
                    });
                });

                function updateActiveLink() {
                    let scrollPosition = window.scrollY + window.innerHeight / 2; 
                    links.forEach(link => {
                        const href = link.getAttribute("href");
                        if (href.startsWith('#')) {
                            const section = document.querySelector(href);
                            if (section && section.offsetTop <= scrollPosition && (section.offsetTop + section
                                    .offsetHeight) > scrollPosition) {
                                link.classList.add("active-link");
                            } else {
                                link.classList.remove("active-link"); 
                            }
                        }
                    });
                }

                window.addEventListener("scroll", function() {
                    if (window.scrollY > 50) {
                        header.classList.add("bg-white", "shadow-2xl", "opacity-none");
                        header.classList.remove("bg-transparent");
                        hamburger.classList.add("text-black");
                        hamburger.classList.remove("text-white");

                        links.forEach(link => {
                            link.classList.add("text-black");
                            link.classList.remove("text-white");
                        });
                    } else {
                        header.classList.remove("bg-white", "shadow-2xl", "opacity-none");
                        header.classList.add("bg-transparent");
                        hamburger.classList.remove("text-black");
                        hamburger.classList.add("text-white");

                        links.forEach(link => {
                            link.classList.remove("text-black");
                            link.classList.add("text-white");
                        });
                    }
                });

                window.addEventListener("scroll", updateActiveLink);
                updateActiveLink(); 

                hamburger.addEventListener("click", function(event) {
                    event.stopPropagation(); 
                    toggleMobileMenu();
                });
            });
        </script>
    @endif
</body>

</html>
