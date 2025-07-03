@extends('layout.app')
@section('content')
<section id="inicio" class="flex  h-svh md:pt-20 px-2 fondo w-full justify-center items-start bg-white" style="background-image: url('{{ asset('images/voleyfondo.jpg') }}'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black opacity-85"></div>
    <div class="relative z-10 flex flex-col gap-y-32 h-full justify-center max-w-3xl">
        <div class="flex flex-col gap-y-20 justify-center">
            <div class="flex items-center justify-center"><img src="{{ asset('images/logo.jpeg') }}" alt="" class="w-[500px]"></div>
            <p class="text-center font-medium text-sm md:text-lg text-white">El lugar ideal para los amantes del
                deporte. Contamos
                con canchas modernas y equipadas para voleibol, futsal
                y otras disciplinas, ofreciendo un espacio perfecto para entrenar, competir y disfrutar. Únete a nuestra
                comunidad deportiva y vive la pasión del deporte en Phaqchas.</p>
        </div>
        <div class="w-full flex flex-col md:flex-row items-center justify-center gap-y-4 md:gap-x-4">
            <a href="{{ route('booking') }}"
                class="bg-cinnabar-700 py-2 px-16 rounded text-white transition-all text-xl font-semibold">Reservas</a>
            <a href="#anuncios"
                class="py-2 px-4 border-2 border-cinnabar-700 rounded-lg font-semibold text-cinnabar-700 hover:bg-cinnabar-700 hover:text-white transition-all duration-300">Visualize
                todos nuestros anuncios y comunicados</a>
        </div>
    </div>

</section>

<x-announcements-carousel :announcements="$announcements"></x-announcements-carousel>
<x-section-deports :sports="$sports"></x-section-deports>
<x-section-fields :fields="$fields"></x-section-fields>
<x-where-are-we></x-where-are-we>

@endsection

<script src="{{ asset('js/scroll.js') }}"></script>