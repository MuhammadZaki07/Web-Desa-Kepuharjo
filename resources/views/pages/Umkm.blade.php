@extends('layouts.app')
@section('content')
    <div class="lg:px-20 px-5 lg:py-10 py-5">
        <div class="mb-8">
            <div class="border-b-2 py-5 border-gray-300">
                <form method="GET" action="{{ route('umkm.page') }}" class="flex flex-col lg:flex-row gap-4 items-end">
                    <div class="w-full">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <i class="bi bi-search text-green-500"></i>
                            Cari Produk
                        </label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full pl-12 pr-4 py-3 border outline-none border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gray-50 hover:bg-white"
                                placeholder="Cari produk UMKM...">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                <i class="bi bi-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="w-full">
                        <label
                            class="text-sm cursor-pointer font-semibold text-gray-700 mb-2 flex items-center gap-2 outline-none">
                            <i class="bi bi-grid text-blue-500"></i>
                            Kategori
                        </label>
                        <select name="category"
                            class="w-full py-3 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 hover:bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}"
                                    {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full">
                        <label class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <i class="bi bi-sort-down text-purple-500"></i>
                            Urutkan
                        </label>
                        <select name="sort"
                            class="w-full py-3 px-4 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-gray-50 hover:bg-white">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>

                    <div class="flex gap-2 w-full lg:w-auto">
                        <button type="submit"
                            class="bg-gradient-to-r cursor-pointer from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 flex items-center gap-2">
                            <i class="bi bi-funnel"></i>
                            Filter
                        </button>

                        @if (request()->hasAny(['search', 'category', 'sort']))
                            <a href="{{ route('umkm.page') }}"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-xl transition-all duration-200 flex items-center gap-2">
                                <i class="bi bi-arrow-clockwise"></i>
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mx-auto py-10">
                @foreach ($products as $product)
                    <div
                        class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 group">
                        <a href="{{ route('umkm.show', $product->slug) }}">
                            <div class="relative">
                                <span
                                    class="absolute top-4 left-4 text-white text-xs font-medium px-3 py-1 rounded-full z-10"
                                    style="background-color: {{ $product->category->color ?? '#10b981' }}">
                                    {{ $product->category->name }}
                                </span>
                                @if ($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->title }}"
                                        class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-52 bg-gray-200 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                                        <i class="bi bi-image text-gray-400 text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-5">
                                <div class="flex items-center mb-3">
                                    <span class="text-xs font-medium px-2.5 py-0.5 rounded"
                                        style="background-color: {{ $product->category->color ?? '#10b981' }}20; color: {{ $product->category->color ?? '#10b981' }}">
                                        {{ $product->category->name }}
                                    </span>
                                    <div class="flex-1 h-0.5 bg-gray-100 ml-3"></div>
                                </div>

                                <a href="{{ route('umkm.show', $product->slug) }}">
                                    <h1
                                        class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 hover:underline text-{{ $product->category->color ?? 'green' }}-600 hover:text-{{ $product->category->color ?? 'green' }}-800">
                                        {{ Str::limit($product->title, 100) }}</h1>
                                </a>

                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ Str::limit($product->description, 100) }}</p>

                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-xs text-gray-500">Harga</p>
                                        <p class="font-bold" style="color: {{ $product->category->color ?? '#10b981' }}">
                                            {{ $product->formatted_price }}
                                        </p>
                                    </div>
                                    @php
                                        $rawNumber = preg_replace('/\D/', '', $product->whatsapp_number);
                                        $number = preg_replace('/^0/', '620', $rawNumber);
                                        $message = "Halo, saya tertarik dengan produk {$product->title}";
                                        $url = "https://wa.me/{$number}?text=" . urlencode($message);
                                    @endphp
                                    <a href="{{ $url }}" target="_blank"
                                        class="bg-green-50 border border-green-500 hover:bg-green-500 hover:text-white text-green-600 font-medium rounded-lg px-4 py-2 transition-colors duration-300 flex items-center gap-2">
                                        <i class="bi bi-whatsapp"></i>
                                        <span>Hubungi</span>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto">
                <p class="text-sm text-gray-600 mb-4 md:mb-0">
                    Menampilkan {{ $products->firstItem() }} sampai {{ $products->lastItem() }} dari
                    {{ $products->total() }} produk
                </p>

                <div class="flex items-center space-x-1">
                    @if ($products->onFirstPage())
                        <span
                            class="px-3 py-2 rounded-md bg-gray-100 border border-gray-300 text-gray-400 cursor-not-allowed">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}"
                            class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-500 hover:bg-gray-50 transition-colors">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page == $products->currentPage())
                            <span
                                class="px-3 py-2 rounded-md bg-green-500 text-white font-medium">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}"
                            class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-500 hover:bg-gray-50 transition-colors">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span
                            class="px-3 py-2 rounded-md bg-gray-100 border border-gray-300 text-gray-400 cursor-not-allowed">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <i class="bi bi-search text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-gray-600 mb-6">Maaf, tidak ada produk yang sesuai dengan pencarian Anda.</p>
                <a href="{{ route('umkm.page') }}"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200 inline-flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i>
                    Lihat Semua Produk
                </a>
            </div>
        @endif
    </div>
@endsection
