<div id="banner-sejarah" class="flex overflow-hidden py-20 gap-1">
    @foreach ($menus as $menu)
        <div class="group relative cursor-pointer w-72 hover:w-1/2 h-[400px] bg-cover bg-center transition-all duration-700 ease-out overflow-hidden grayscale hover:grayscale-0"
            style="background-image: url('{{ asset('storage/' . $menu['image']) }}');">
            <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-transparent z-0"></div>
            <div class="absolute inset-0 group-hover:-translate-x-5 transition-transform duration-700 ease-out"></div>
            <h2
                class="absolute left-10 bottom-3 text-white text-4xl font-bold rotate-270 origin-left z-10 whitespace-nowrap group-hover:scale-0 transition-all duration-700">
                {{ $menu['title'] }}
            </h2>
        </div>
    @endforeach
</div>
