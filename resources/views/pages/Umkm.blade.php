@extends('layouts.app')
@section('content')
    <div class="lg:px-20 px-5 lg:py-10 py-5">
        <div class="mb-8">
            <div class="p-4 md:p-6">
                <!-- Search Bar -->
                <div class="relative mb-6">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                    <input type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-3 focus:ring-green-500 focus:border-green-500"
                        placeholder="Cari produk UMKM...">
                </div>

                <!-- Filter Options -->
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select id="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-green-500 focus:border-green-500">
                            <option value="" selected>Semua Kategori</option>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                            <option value="pertanian">Pertanian</option>
                            <option value="kerajinan">Kerajinan</option>
                            <option value="kuliner">Kuliner</option>
                        </select>
                    </div>

                    <div class="flex-1">
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select id="sort"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-green-500 focus:border-green-500">
                            <option value="newest" selected>Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="price_low">Harga Terendah</option>
                            <option value="price_high">Harga Tertinggi</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <a href="/detail-umkm">
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 group">
                    <!-- Badge Posisi Absolut -->
                    <div class="relative">
                        <span
                            class="absolute top-4 left-4 bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full z-10">Makanan</span>
                        <img src="{{ asset('assets/UMKM/food.jpg') }}" alt="Produk UMKM"
                            class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>

                    <div class="p-5">
                        <div class="flex items-center mb-3">
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Pertanian</span>
                            <div class="flex-1 h-0.5 bg-gray-100 ml-3"></div>
                        </div>

                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">Beras Organik Premium Hasil
                            Panen...
                        </h3>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">Beras organik berkualitas tinggi yang ditanam
                            dengan
                            metode ramah lingkungan oleh petani lokal kami.</p>

                        <div class="flex items-center mb-4">
                            <div class="flex items-center text-gray-500 text-sm mr-4">
                                <i class="bi bi-geo-alt mr-1"></i>
                                <span>Desa Sejahtera</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs text-gray-500">Harga</p>
                                <p class="text-green-600 font-bold">Rp 85.000</p>
                            </div>
                            <button
                                class="bg-green-50 border border-green-500 hover:bg-green-500 hover:text-white text-green-600 font-medium rounded-lg px-4 py-2 transition-colors duration-300 flex items-center gap-2">
                                <i class="bi bi-whatsapp"></i>
                                <span>Hubungi</span>
                            </button>
                        </div>
                    </div>
                </div>
            </a>
            <a href="/detail-umkm">
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 group">
                    <div class="relative">
                        <span
                            class="absolute top-4 left-4 bg-blue-500 text-white text-xs font-medium px-3 py-1 rounded-full z-10">Minuman</span>
                        <img src="{{ asset('assets/UMKM/foto_produk9.png') }}" alt="Produk UMKM"
                            class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>

                    <div class="p-5">
                        <div class="flex items-center mb-3">
                            <span
                                class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Kerajinan</span>
                            <div class="flex-1 h-0.5 bg-gray-100 ml-3"></div>
                        </div>

                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">Anyaman Bambu Tradisional Handmade
                        </h3>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">Kerajinan tangan berkualitas tinggi yang
                            dibuat
                            oleh
                            pengrajin lokal dengan teknik tradisional.</p>

                        <div class="flex items-center mb-4">
                            <div class="flex items-center text-gray-500 text-sm mr-4">
                                <i class="bi bi-geo-alt mr-1"></i>
                                <span>Desa Kreatif</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs text-gray-500">Harga</p>
                                <p class="text-blue-600 font-bold">Rp 150.000</p>
                            </div>
                            <button
                                class="bg-blue-50 border border-blue-500 hover:bg-blue-500 hover:text-white text-blue-600 font-medium rounded-lg px-4 py-2 transition-colors duration-300 flex items-center gap-2">
                                <i class="bi bi-whatsapp"></i>
                                <span>Hubungi</span>
                            </button>
                        </div>
                    </div>
                </div>
            </a>
            <a href="/detail-umkm">
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 group">
                    <div class="relative">
                        <span
                            class="absolute top-4 left-4 bg-amber-500 text-white text-xs font-medium px-3 py-1 rounded-full z-10">Pertanian</span>
                        <img src="{{ asset('assets/UMKM/pupuk.jpg') }}" alt="Produk UMKM"
                            class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>

                    <div class="p-5">
                        <div class="flex items-center mb-3">
                            <span
                                class="bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded">Kuliner</span>
                            <div class="flex-1 h-0.5 bg-gray-100 ml-3"></div>
                        </div>

                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">Kue Tradisional Lapis Legit
                            Special
                        </h3>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">Kue tradisional dengan cita rasa autentik,
                            dibuat
                            dengan bahan-bahan berkualitas dan resep turun-temurun.</p>

                        <div class="flex items-center mb-4">
                            <div class="flex items-center text-gray-500 text-sm mr-4">
                                <i class="bi bi-geo-alt mr-1"></i>
                                <span>Desa Lestari</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs text-gray-500">Harga</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-amber-600 font-bold">Rp 99.000</p>
                                </div>
                            </div>
                            <button
                                class="bg-amber-50 border border-amber-500 hover:bg-amber-500 hover:text-white text-amber-600 font-medium rounded-lg px-4 py-2 transition-colors duration-300 flex items-center gap-2">
                                <i class="bi bi-whatsapp"></i>
                                <span>Hubungi</span>
                            </button>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="mt-10 flex flex-col md:flex-row justify-between items-center max-w-6xl mx-auto">
            <p class="text-sm text-gray-600 mb-4 md:mb-0">Menampilkan 6 dari 42 produk</p>
            <div class="flex items-center space-x-1">
                <a href="#"
                    class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-500 hover:bg-gray-50">
                    <i class="bi bi-chevron-left"></i>
                </a>
                <a href="#" class="px-3 py-2 rounded-md bg-green-500 text-white hover:bg-green-600">1</a>
                <a href="#"
                    class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                <a href="#"
                    class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                <a href="#"
                    class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">4</a>
                <a href="#"
                    class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">5</a>
                <span class="px-3 py-2 text-gray-500">...</span>
                <a href="#"
                    class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">7</a>
                <a href="#"
                    class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-500 hover:bg-gray-50">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
