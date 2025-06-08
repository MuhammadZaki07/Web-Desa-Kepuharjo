<div class="py-5">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 relative">
         <a href="/detail-blog">
            <div class="rounded-xl overflow-hidden relative group cursor-pointer">
                <img src="{{ asset('assets/images/foto_brawijaya 1.png') }}" alt=""
                    class="w-full h-full object-cover transition-opacity duration-500 group-hover:opacity-80">
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/50 group-hover:via-black/20 to-transparent z-10 transition-all duration-500 ease-in-out">
                </div>
                <div class="absolute inset-0 z-20 overflow-hidden pointer-events-none">
                    <div
                        class="absolute w-[50px] h-[500%] bg-white/50 transform rotate-45 translate-x-[-100%] translate-y-[-100%] group-hover:translate-x-[150%] group-hover:translate-y-[150%] transition-all duration-2000 ease-in-out">
                    </div>
                </div>
                <div class="absolute bottom-0 z-30 lg:px-5 lg:py-8 py-3 px-3 text-white">
                    <div class="flex gap-4 items-center">
                        <div class="py-1 px-2 text-white bg-green-700 font-semibold text-xs rounded">Berita</div>
                        <div class="space-x-2">
                            <i class="bi bi-clock"></i>
                            <span class="font-semibold text-white text-xs">3 Hari Yang Lalu</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5 mt-3">
                        <h1 class="font-bold text-white lg:text-xl text-xs">Segini Besaran Biaya UKT di Universitas,
                            Brawijaya Untuk Jalur SNBT Dan Mandiri </h1>
                        <p class="lg:text-sm text-xs text-slate-50">KepuhNews - KepuhNews Meskipun mahal banyak mahasiswa Unversitas Brawijaya,
                            yang memilih jalur mandiri dikarenakan persai...</p>
                    </div>
                </div>
            </div>
        </a>

        <div class="grid lg:grid-cols-2 grid-cols-1 gap-5">
            @for ($i = 0; $i < 4; $i++)
             <a href="/detail-blog">

                <div class="rounded-xl overflow-hidden relative group cursor-pointer">
                    <img src="{{ asset('assets/images/foto_brawijaya 1.png') }}" alt=""
                        class="w-full h-full object-cover transition-opacity duration-500 group-hover:opacity-80">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/50 group-hover:via-black/20 to-transparent z-10 transition-all duration-1000 ease-in-out">
                    </div>
                    <div class="absolute inset-0 z-20 overflow-hidden pointer-events-none">
                        <div
                            class="absolute w-[50px] h-[500%] bg-white/50 transform rotate-45 translate-x-[-100%] translate-y-[-100%] group-hover:translate-x-[150%] group-hover:translate-y-[150%] transition-all duration-2000 ease-in-out">
                        </div>
                    </div>
                    <div class="absolute bottom-0 z-30 lg:p-4 p-5 text-white">
                        <div class="flex gap-4 items-center">
                            <div class="py-0.5 px-2 text-white bg-green-700 font-semibold text-xs rounded">Berita</div>
                            <div class="space-x-2  text-[12px]">
                                <i class="bi bi-clock"></i>
                                <span class="font-semibold text-white">3 Hari Yang Lalu</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5 mt-3">
                            <h1 class="font-bold text-white lg:text-sm text-xl">Segini Besaran Biaya UKT di Universitas,
                                Brawijaya Untuk Jalur SNBT Dan Mandiri </h1>
                        </div>
                    </div>
                </div>
            </a>
            @endfor
        </div>
    </div>
</div>
