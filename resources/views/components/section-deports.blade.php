<section id="deportes" class="flex flex-col gap-y-4 px-4 py-10">
    <x-section-header
        title="Deportes"
        description="Descubre los deportes que ofrecemos: Fútsall, Voleibol, etc." />

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-16">
        @forelse ($sports as $item)
        <div class="flex flex-col gap-y-8 rounded-xl shadow-black shadow-2xl min-h-60">
            <div>
                <img src="{{ asset($item->image) }}" alt="" class="w-full rounded-t-lg object-cover h-[25rem] ">
            </div>
            <div class="flex flex-col gap-y-2 items-center w-full">
                <h2 class="mayus font-bold text-xl text-cinnabar-600">{{ $item->name }}</h2>
                <p class="mayus truncate-text text-justify text-black/80">{{ $item->description }}</p>
            </div>
            <div class="h-32 bg-cinnabar-600 text-gray-300 p-2 grid grid-cols-2 rounded-b-lg">
                <div class="flex items-center justify-center gap-x-6 font-semibold w-full">
                    <i class="fas fa-sun text-5xl"></i> 
                    <div class="flex flex-col items-center gap-y-2">
                        <span>Mañana</span>
                        <span class="font-mono">S/{{ $item->price_morning }}</span>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-x-6 font-semibold w-full">
                    <i class="fas fa-moon text-5xl"></i> 
                    <div class="flex flex-col items-center gap-y-2">
                        <span>Mañana</span>
                        <span class="font-mono">S/{{ $item->price_evening }}</span>
                    </div>
                </div>
            </div>

        </div>
        @empty
        <div>No hay deportes</div>
        @endforelse
    </div>
</section>