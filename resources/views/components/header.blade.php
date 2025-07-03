<header id="header"
    class="flex justify-between items-center p-4 h-20 fixed top-0 w-full shadow-xl z-50 transition-all duration-500">
    @if (Request::is('booking'))
        <a href="{{ route('home') }}" class="flex gap-x-2 items-center justify-center w-full">
            <x-logo></x-logo>
        </a>
    @endif
    @if (Request::is('/'))
    <a href="{{ route('home') }}" class="flex gap-x-2 items-center justify-center">
        <x-logo></x-logo>
    </a>
    <nav class="hidden lg:flex gap-4 items-center w-full">
        <ul class="grid md:grid-cols-11 w-full items-center justify-between">
            <div class="flex gap-x-20 col-span-10 justify-center">
                <x-navigation-item href="#inicio" text="Inicio" />
                <x-navigation-item href="#anuncios" text="Anuncios" />
                <x-navigation-item href="#deportes" text="Deportes" />
                <x-navigation-item href="#donde-estamos" text="Donde estamos" />
            </div>
            <div class="col-span-1 flex justify-end ">
                <a href="{{ route('booking') }}"
                    class="bg-cinnabar-700 py-2 px-16 rounded text-white transition-all text-xl font-semibold">Reservas</a>
            </div>
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
    <a href="{{ route('home') }}">
        <x-logo></x-logo>
    </a>
    <ul>
        <li><a href="#inicio" class="hover:text-lime-600">Inicio</a></li>
        <li><a href="#anuncios" class="hover:text-lime-600">Anuncios</a></li>
        <li><a href="#deportes" class="hover:text-lime-600">Deportes</a></li>
        <li><a href="#donde-estamos" class="hover:text-lime-600">Donde estamos</a></li>
        <li><a href="{{ route('booking') }}" class="hover:text-lime-600">Reservas</a></li>
    </ul>
</div>