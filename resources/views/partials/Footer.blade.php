<footer class="bg-gray-50 text-gray-800 py-10 mt-16 relative">
    <a href="#top"
        class="absolute lg:right-38 right-10 cursor-pointer -top-7 z-20 w-13 h-13 lg:w-14 lg:h-14 rounded-full bg-green-600 flex justify-center items-center shadow-sm">
        <i class="bi bi-chevron-up text-white font-bold text-2xl"></i>
    </a>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-0 w-full">
            <div class="flex-2">
                <h2 class="text-lg font-bold uppercase mb-3">Tentang Desa</h2>
                <div class="w-16 h-1 bg-emerald-600 mb-4"></div>
                @if (!empty($ProfileDesa?->logo_desa))
                    <img src="{{ asset('storage/' . $ProfileDesa->logo_desa) }}" alt="Logo Desa" class="w-20 mb-4" />
                @else
                    <img src="{{ asset('assets/logo/Logo_Kabupaten_Malang.png') }}" alt="Logo Default"
                        class="w-20 mb-4" />
                @endif


                <p class="font-semibold mb-2">Desa {{ $ProfileDesa->name ?? "Kepuharjo" }}</p>
                <div class="flex items-center gap-2 mb-2">
                    <div class="bg-emerald-100 p-2 lg:w-10 lg:h-10 lg:flex justify-center items-center rounded-full">
                        <i class="bi bi-telephone-fill text-emerald-600"></i>
                    </div>
                    <span>{{ $ProfileDesa->no_tlp ?? "nomor tlp desa" }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="bg-emerald-100 p-2 lg:w-10 lg:h-10 lg:flex justify-center items-center rounded-full">
                        <i class="bi bi-envelope-fill text-emerald-600"></i>
                    </div>
                    <span>{{ $ProfileDesa->email ?? "email desa"}}</span>
                </div>
            </div>
            <div class="flex lg:flex-3 flex-col sm:flex-row lg:gap-60 gap-10">
                <div>
                    <h2 class="text-lg font-bold uppercase mb-3">Akses Cepat</h2>
                    <div class="w-16 h-1 bg-emerald-600 mb-4"></div>
                    <ul class="space-y-2">
                        <li class="hover:text-green-500 cursor-pointer">
                            <a href="#top" class="flex items-center gap-2">
                                <span class="text-emerald-600">●</span> Beranda
                            </a>
                        </li>
                        <li class="hover:text-green-500 cursor-pointer">
                            <a href="/profile-data-penduduk" class="flex items-center gap-2">
                                <span class="text-emerald-600">●</span> Profile Data Penduduk
                            </a>
                        </li>
                        <li class="hover:text-green-500 cursor-pointer">
                            <a href="/berita" class="flex items-center gap-2">
                                <span class="text-emerald-600">●</span> Artikel
                            </a>
                        </li>
                        <li class="hover:text-green-500 cursor-pointer">
                            <a href="/pemerintahan" class="flex items-center gap-2">
                                <span class="text-emerald-600">●</span> Pemerintahan
                            </a>
                        </li>
                        <li class="hover:text-green-500 cursor-pointer">
                            <a href="/gallery" class="flex items-center gap-2">
                                <span class="text-emerald-600">●</span> Galeri
                            </a>
                        </li>
                        <li class="hover:text-green-500 cursor-pointer">
                            <a href="/umkm" class="flex items-center gap-2">
                                <span class="text-emerald-600">●</span> UMKM
                            </a>
                        </li>
                    </ul>

                </div>

                <div>
                    <h2 class="text-lg font-bold uppercase mb-3">Bidang Prioritas Desa</h2>
                    <div class="w-16 h-1 bg-emerald-600 mb-4"></div>
                    <ul class="space-y-2">
                        <li class="hover:text-green-500 cursor-pointer">
                            <a href="/wisata" class="flex items-center gap-2">
                                <span class="text-emerald-600">●</span> Pariwisata
                            </a>
                        </li>
                        <li class="hover:text-green-500 cursor-pointer">
                            <a href="/berita" class="flex items-center gap-2">
                                <span class="text-emerald-600">●</span> Berita
                            </a>
                        </li>
                        <li class="hover:text-green-500 cursor-pointer">
                            <a href="/umkm" class="flex items-center gap-2">
                                <span class="text-emerald-600">●</span> Usaha Mikro, Kecil, dan Menengah
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div
            class="border-t border-gray-200 mt-10 pt-6 flex flex-col md:flex-row items-center justify-center text-sm text-gray-500">
            <p>© 2025 Desa Kepuharjo. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>
