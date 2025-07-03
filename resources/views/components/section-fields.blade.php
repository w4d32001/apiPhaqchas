<div class="flex flex-col gap-y-4 p-4">
    <x-section-header
        title="Nuestros Campos Deportivos"
        description="Contamos con instalaciones profesionales para:" />
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-16 ">
        @forelse ($fields as $item)
        <div class="flex flex-col justify-between border rounded-xl shadow-black shadow-2xl min-h-60">
            <div>
                <img src="{{ asset($item->image) }}" alt="" class="w-auto rounded-t-lg object-cover h-[400px] ">
            </div>
            <div class="p-3 h-full flex flex-col justify-between ">
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

</div>