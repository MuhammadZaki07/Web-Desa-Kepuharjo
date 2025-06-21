@extends('layouts.app')

@section('title', 'Destinasi Wisata | Eksplorasi Tempat Menarik di Daerah Anda')
@section('description', 'Temukan berbagai destinasi wisata menarik dengan informasi lengkap, mulai dari harga tiket, lokasi, hingga kategori wisata.')

@section('content')
    <div class="lg:px-20 px-5 lg:py-10 py-5">
        <section class="mb-8">
            <div class="border-b-2 py-5 border-gray-300">
                <form method="GET" action="{{ route('wisata.page') }}" class="flex flex-col lg:flex-row gap-4 items-end">
                    <div class="w-full ">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <i class="bi bi-search text-green-500"></i>
                            Cari Wisata
                        </label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 outline-none rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gray-50 hover:bg-white"
                                placeholder="Cari nama wisata, lokasi, atau deskripsi...">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                <i class="bi bi-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class=" w-full">
                        <label class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <i class="bi bi-grid text-green-500"></i>
                            Kategori
                        </label>
                        <select name="category"
                            class="w-full py-3 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gray-50 hover:bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class=" w-full">
                        <label class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <i class="bi bi-sort-down text-green-500"></i>
                            Urutkan
                        </label>
                        <select name="sort"
                            class="w-full py-3 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gray-50 hover:bg-white">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                        </select>
                    </div>

                    <div class="flex gap-2 w-full lg:w-auto">
                        <button type="submit"
                            class="bg-gradient-to-r cursor-pointer from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 flex items-center gap-2">
                            <i class="bi bi-funnel"></i>
                            Filter
                        </button>

                        @if (request()->hasAny(['search', 'category', 'sort']))
                            <a href="{{ route('wisata.page') }}"
                                class="bg-gray-100 hover:bg-gray-200 cursor-pointer text-gray-700 font-semibold py-3 px-6 rounded-xl transition-all duration-200 flex items-center gap-2">
                                <i class="bi bi-arrow-clockwise"></i>
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </section>

        @if ($wisataList->count() > 0)
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl">
                @foreach ($wisataList as $wisata)
                    <article class="bg-white rounded-xl overflow-hidden border border-slate-300 transition-all duration-300 group">
                        <a href="{{ route('wisata.show', $wisata->slug) }}" class="block">
                            <div class="relative">
                                <span style="background-color: {{ $wisata->category->color_code ?? '#3B82F6' }}; color: white;"
                                    class="absolute top-4 left-4 text-xs font-medium px-3 py-1 rounded-full z-10">
                                    {{ $wisata->category->name }}
                                </span>

                                @if ($wisata->is_featured)
                                    <span class="absolute top-4 right-4 bg-yellow-500 text-white text-xs font-medium px-2 py-1 rounded-full z-10">
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                @endif

                                <img src="{{ $wisata->main_image_url }}" alt="Foto destinasi wisata {{ $wisata->name }}"
                                    class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>

                            <div class="p-5">
                                <div class="flex items-center mb-3">
                                    <span style="background-color: {{ $wisata->category->color_code ?? '#DBEAFE' }}; color: {{ $wisata->category->color_code ?? '#1E40AF' }};"
                                        class="text-xs font-medium px-2.5 py-0.5 rounded">
                                        {{ $wisata->category->name }}
                                    </span>
                                    <div class="flex-1 h-0.5 bg-gray-100 ml-3"></div>
                                </div>

                                <h2 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                                    {{ $wisata->name }}
                                </h2>

                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                    {{ $wisata->description }}
                                </p>

                                @if ($wisata->views > 0)
                                    <div class="flex items-center mb-4 text-xs text-gray-500">
                                        <i class="bi bi-eye mr-1"></i>
                                        <span>{{ number_format($wisata->views) }} kali dilihat</span>
                                    </div>
                                @endif

                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-xs text-gray-500">Tiket Masuk</p>
                                        <p class="font-bold text-lg {{ $wisata->price === 0 ? 'text-green-600' : 'text-gray-800' }}">
                                            {{ $wisata->formatted_price }}
                                        </p>
                                    </div>
                                    <button
                                        style="background-color: {{ $wisata->category->color_code ?? '#EFF6FF' }};
                                               border-color: {{ $wisata->category->color_code ?? '#3B82F6' }};
                                               color: {{ $wisata->category->color_code ?? '#3B82F6' }};"
                                        onmouseover="this.style.backgroundColor='{{ $wisata->category->color_code ?? '#3B82F6' }}'; this.style.color='white'"
                                        onmouseout="this.style.backgroundColor='{{ $wisata->category->color_code ?? '#EFF6FF' }}'; this.style.color='{{ $wisata->category->color_code ?? '#3B82F6' }}';"
                                        class="border font-medium rounded-lg px-4 py-2 transition-colors duration-300 flex items-center gap-2 cursor-pointer">
                                        <i class="bi bi-ticket-detailed"></i>
                                        <span>Detail</span>
                                    </button>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </section>

            <div class="mt-10 flex justify-center">
                {{ $wisataList->links('pagination::tailwind') }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="bi bi-search text-6xl"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-600 mb-2">Tidak ada destinasi wisata ditemukan</h2>
                <p class="text-gray-500 mb-4">
                    @if (request()->hasAny(['search', 'category']))
                        Coba ubah kata kunci pencarian atau filter yang digunakan
                    @else
                        Belum ada destinasi wisata yang tersedia saat ini
                    @endif
                </p>
                @if (request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route('wisata.page') }}"
                        class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="bi bi-arrow-clockwise"></i>
                        Lihat Semua Wisata
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection
