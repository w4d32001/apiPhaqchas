<section id="anuncios" class="py-10 flex flex-col items-center w-full gap-y-4">
    <x-section-header
        title="Anuncios y comunicados"
        description="Mantente informado sobre nuestras últimas novedades, eventos y comunicados importantes." />

    <div class="relative w-full overflow-hidden mt-6 py-4">
        <div id="carousel" class="flex gap-x-4 transition-transform duration-500 ease-in-out">
            @foreach ($announcements as $item)
            <div class="flex flex-col items-center p-2 border-2 bg-cinnabar-950/80 rounded-lg shadow-lg shadow-black flex-shrink-0 w-full sm:w-[calc(50%-0.5rem)] lg:w-[calc(100%/3.5-0.75rem)]">
                <h2 class="text-[30px] text-center font-bungee uppercase text-saratoga-200 break-words whitespace-normal px-4">
                    {{ $item->title }}
                </h2>
                <img src="{{ asset($item->image) }}" alt="" class="w-auto h-[500px] rounded-lg my-4 object-cover">
                <div class="h-60 max-h-40 md:max-h-60 w-full max-w-[450px] xl:max-w-[600px] overflow-y-auto flex items-center justify-center bg-white p-4 rounded-b-lg">
                    <p class="text-sm md:text-lg text-justify text-gray-700 w-full break-words font-sans">
                        {{ $item->description }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script src="{{ asset('js/carrousel.js') }}"></script>