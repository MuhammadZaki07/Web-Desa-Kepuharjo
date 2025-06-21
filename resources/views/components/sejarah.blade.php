<div id="sejarah" class="tab-content hidden w-full py-3">
    <x-badge class="py-2 lg:flex mx-auto hidden">Sejarah Desa</x-badge>
    <p class="text-center text-slate-500 font-semibold mt-5 hidden lg:block">Sejarah desa Kepuharjo, Karangploso,
        Kabupaten
        Malang, Jawa Timur</p>
    <div
        class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl overflow-hidden p-8 md:p-12 flex flex-col md:flex-row gap-10 items-center transition-all duration-500 hover:shadow-3xl mt-5">
        <div class="w-full md:w-5/12 relative overflow-hidden rounded-2xl">
            @if (!empty($sejarah->image_sejarah))
                <img src="{{ asset('storage/' . $sejarah->image_sejarah) }}" alt="Foto Sejarah Desa"
                    class="object-cover w-full h-72 md:h-96 scale-100 transition-all duration-500 rounded-2xl filter grayscale">
            @else
                <div class="w-full h-72 bg-slate-300 rounded-xl"></div>
            @endif
        </div>

        <div class="flex-1 flex flex-col justify-center gap-6">
            <div class="flex flex-col gap-2">
                <h2
                    class="text-4xl md:text-5xl font-extrabold text-slate-800 leading-tight tracking-tight hover:text-green-600 transition-all duration-300">
                    Sejarah <span class="text-green-600">Desa Kepuharjo</span>
                </h2>
                <div class="text-slate-500 text-base leading-relaxed max-w-2xl">
                    {!! Str::limit($sejarah->sejarah_desa ?? "No data", 200) !!}
                </div>
            </div>

            <div>
                <a href="/sejarah"
                    class="inline-flex items-center px-5 py-2 rounded-full bg-green-500 hover:bg-green-600 text-white text-sm font-semibold shadow-md transition-all duration-300">
                    Baca Selengkapnya →
                </a>
            </div>
        </div>
    </div>

</div>
