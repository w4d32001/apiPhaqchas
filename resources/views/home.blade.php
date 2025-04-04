@extends('layout.app')
@section('content')
    <section id="inicio" class="flex h-svh md:pt-20 px-2 fondo w-full justify-center items-start"
        style="background-image: url('{{ asset('images/fondo.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent"></div>
        <div class="relative z-10 flex flex-col gap-y-4 h-full justify-start pt-24 lg:max-w-screen-md">
            <div class="flex items-center justify-center">
                <img src="{{ asset('images/logo.jpeg') }}" alt="" class="w-[400px] md:w-[500px] rounded-lg">
            </div>
            <div class="flex flex-col gap-y-4 justify-center">
                <h1 class="text-[45px] text-center font-bungee uppercase text-[#B99E2A] text-shadow-heavy">Phaqchas</h1>
                <p class="text-center font-medium text-sm md:text-lg text-white">El lugar ideal para los amantes del
                    deporte. Contamos
                    con canchas modernas y equipadas para voleibol, futsal
                    y otras disciplinas, ofreciendo un espacio perfecto para entrenar, competir y disfrutar. Únete a nuestra
                    comunidad deportiva y vive la pasión del deporte en Phaqchas.</p>
            </div>
            <div class="w-full flex flex-col md:flex-row items-center justify-center gap-y-4 md:gap-x-4">
                <a href="{{ route('booking') }}" class="bg-lime-600 py-2 px-4 rounded-lg text-white font-bold text-xl">Reservas</a>
                <a href="#anuncios"
                    class="py-2 px-4 border-2 border-lime-600 rounded-lg font-semibold text-lime-600 hover:bg-lime-600 hover:text-white transition-all duration-300">Visualize
                    todos nuetros anuncios y comunicados</a>
            </div>
        </div>

    </section>
    <section id="anuncios" class=" py-10 flex flex-col items-center w-full gap-y-4">
        <h1 class="text-3xl md:text-[45px] text-center font-bungee uppercase text-[#B99E2A]">
            Anuncios y comunicados
        </h1>
        <p class="text-center font-medium text-lg text-black/80 max-w-2xl ">
            Mantente informado sobre nuestras últimas novedades, eventos y comunicados importantes.
        </p>

        <div class="relative w-full max-w-[1400px] overflow-hidden mt-6">
            <div id="carousel" class="flex gap-x-4 transition-transform duration-500 ease-in-out w-full">
                @foreach ($announcements as $item)
                    <div
                        class="flex flex-col items-center px-4 border shadow-2xl shadow-black flex-shrink-0 w-full sm:w-[50%] lg:w-[calc(100%/2.5)]">
                        <h2 class="text-[30px] text-center font-bungee uppercase text-[#B99E2A]">
                            {{ $item->title }}
                        </h2>
                        <img src="https://api.dev.phaqchas.shop/apiPhaqchas/public{{ $item->image }}" alt="" class="w-auto h-[450px] rounded-lg mt-4 object-cover">
                        <p
                            class="font-medium text-lg text-white mayus text-justify break-words overflow-y-auto max-h-60 p-4 bg-black/50 rounded-md w-full mt-4 max-w-[450px]">
                            {{ $item->description }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Botones -->
            <button id="prev"
                class="absolute left-2 md:left-6 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-70 text-white p-3 rounded-full shadow-md z-10 hover:bg-opacity-90 transition">
                ◀
            </button>
            <button id="next"
                class="absolute right-2 md:right-6 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-70 text-white p-3 rounded-full shadow-md z-10 hover:bg-opacity-90 transition">
                ▶
            </button>
        </div>

    </section>
    <section id="deportes" class="flex flex-col gap-y-4 p-4">
        <h1 class="text-[45px] text-center font-bungee uppercase text-[#B99E2A]">
            Deportes y campos
        </h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-16">
            @forelse ($sports as $item)
                <div class="flex justify-between border rounded-xl shadow-[#B99E2A] shadow-2xl min-h-60">
                    <div class="p-3 h-full flex flex-col justify-between w-1/2">
                        <div class="flex flex-col gap-y-2">
                            <h2 class="mayus font-bold text-xl text-black/90">{{ $item->name }}</h2>
                            <p class="mayus truncate-text text-justify text-black/80">{{ $item->description }}</p>
                        </div>
                        <div class="bg-lime-600 text-white p-2 flex items-center justify-between rounded-lg">
                            <div class="flex flex-col items-center gap-y-2 font-semibold">
                                <span>Mañana</span>
                                <span>S/{{ $item->price_morning }}</span>
                            </div>
                            <span class="text-xl">|</span>
                            <div class="flex flex-col items-center gap-y-2 font-semibold">
                                <span>Tarde</span>
                                <span>S/{{ $item->price_evening }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img src="https://api.dev.phaqchas.shop/apiPhaqchas/public{{ $item->image }}" alt="" class="w-auto rounded-r-lg object-cover h-full ">
                    </div>
                </div>
            @empty
                <div>No hay deportes</div>
            @endforelse
        </div>
        <h1 class="text-[45px] text-center font-bungee uppercase text-[#B99E2A]">
            Campos
        </h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-16 ">
            @forelse ($fields as $item)
                <div class="flex justify-between border rounded-xl shadow-[#B99E2A] shadow-2xl min-h-60">
                    <div>
                        <img src="https://api.dev.phaqchas.shop/apiPhaqchas/public{{ $item->image }}" alt="" class="w-auto rounded-l-lg object-cover h-full ">
                    </div>
                    <div class="p-3 h-full flex flex-col justify-between w-1/2">
                        <div class="flex flex-col gap-y-2">
                            <h2 class="mayus text-xl font-bold text-black/90">{{ $item->name }}</h2>
                            <p class="mayus truncate-text text-justify text-black/80">{{ $item->description }}</p>
                        </div>
                    </div>

                </div>
            @empty
                <div>No hay campos</div>
            @endforelse
        </div>

    </section>

    <section id="donde-estamos" class="flex flex-col gap-y-4 p-4">
        <h1 class="text-[45px] text-center font-bungee uppercase text-[#B99E2A]">
            Donde estamos
        </h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-16 p-4">
            <!-- Info -->
            <div class="bg-white text-black/90 col-span-1 p-4 rounded-xl h-full flex flex-col justify-around">
                <h2 class=" text-center text-3xl font-bold uppercase">Ubicación</h2>
                <p class="text-justify text-sm font-semibold">
                    Nos encontramos en la provincia de Abancay, en la intersección
                    de Prolongación Arica con la calle Horacio Zeballos, a 5 minutos del parque Señor de la Caída.
                </p>
                <div class="flex items-center justify-center mt-4">
                    <a href="https://www.google.com/maps/@-13.6300254,-72.8793525,19z/data=!5m2!1e4!1e1?entry=ttu"
                       class="bg-lime-500 rounded-xl font-bold text-whit/90 py-3 px-5 hover:bg-lime-500/90 transition-colors text-gray-100"
                       target="_blank">
                        Abrir en Google Maps
                    </a>
                </div>
            </div>
    
            <div class="col-span-2">
                <div class="w-full h-[300px] md:h-[350px] lg:h-[450px] rounded-xl overflow-hidden shadow-lg">
                    <iframe
                        class="w-full h-full"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d864.601923035708!2d-72.8793525!3d-13.6300254!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x916d03211e390697%3A0xf70e6f08ff6afe89!2sCampo%20Deportivo%20Las%20Facchas%2C%20Abancay%2003001!5e1!3m2!1ses-419!2spe!4v1738687223850!5m2!1ses-419!2spe"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>
    
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const carousel = document.getElementById("carousel");
        const slides = document.querySelectorAll("#carousel > div");
        const prevButton = document.getElementById("prev");
        const nextButton = document.getElementById("next");

        let currentIndex = 0;
        let slidesPerView = getSlidesPerView();

        function getSlidesPerView() {
            if (window.innerWidth >= 1024) return 2.5;
            if (window.innerWidth >= 768) return 2;
            return 1; // En pantallas pequeñas solo se muestra 1
        }

        function updateCarousel() {
            slidesPerView = getSlidesPerView();
            const percentage = (100 / slidesPerView) * currentIndex;
            carousel.style.transform = `translateX(-${percentage}%)`;
        }

        nextButton.addEventListener("click", function() {
            currentIndex = (currentIndex < slides.length - slidesPerView) ? currentIndex + 1 : 0;
            updateCarousel();
        });

        prevButton.addEventListener("click", function() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : slides.length - slidesPerView;
            updateCarousel();
        });

        setInterval(() => {
            nextButton.click();
        }, 5000);

        window.addEventListener("resize", function() {
            updateCarousel();
        });

        updateCarousel();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const header = document.getElementById("header");
        const links = document.querySelectorAll("nav ul li a, #mobile-menu ul li a, a");
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