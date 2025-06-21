@extends('layouts.app')

@section('title', "{{ $product->title }} - Produk UMKM {{ config('app.name') }}")

@push('head')
    <meta name="description" content="{{ Str::limit(strip_tags($product->description), 160) }}">
    <meta name="keywords"
        content="{{ $product->title }}, {{ $product->category->name }}, UMKM, produk lokal, {{ $product->location }}">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="product">
    <meta property="og:title" content="{{ $product->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($product->description), 160) }}">
    <meta property="og:image"
        content="{{ $product->images && count($product->images) > 0 ? asset('storage/' . $product->images[0]) : asset('assets/banners/preview-1.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $product->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($product->description), 160) }}">
    <meta name="twitter:image"
        content="{{ $product->images && count($product->images) > 0 ? asset('storage/' . $product->images[0]) : asset('assets/banners/preview-1.png') }}">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Product",
        "name": "{{ $product->title }}",
        "image": [
            @if ($product->images && is_array($product->images))
                @foreach ($product->images as $image)
                    "{{ asset('storage/' . $image) }}"{{ !$loop->last ? ',' : '' }}
                @endforeach
            @else
                "{{ asset('assets/banners/preview-1.png') }}"
            @endif
        ],
        "description": "{{ strip_tags($product->description) }}",
        "sku": "{{ $product->id }}",
        "brand": {
            "@type": "Brand",
            "name": "{{ config('app.name') }}"
        },
        "offers": {
            "@type": "Offer",
            "url": "{{ url()->current() }}",
            "priceCurrency": "IDR",
            "price": "{{ $product->price }}",
            "availability": "https://schema.org/InStock"
        },
        "category": "{{ $product->category->name }}",
        "breadcrumb": {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Beranda",
                    "item": "{{ url('/') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "UMKM",
                    "item": "{{ route('umkm.page') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ $product->title }}",
                    "item": "{{ url()->current() }}"
                }
            ]
        }
    }
    </script>
@endpush

@section('content')
    <article class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <nav aria-label="breadcrumb" class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600" itemscope
                itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" class="hover:text-green-600" itemprop="item">
                        <span itemprop="name">Beranda</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>
                <li><span class="bi bi-chevron-right text-xs" aria-hidden="true"></span></li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="{{ route('umkm.page') }}" class="hover:text-green-600" itemprop="item">
                        <span itemprop="name">UMKM</span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>
                <li><span class="bi bi-chevron-right text-xs" aria-hidden="true"></span></li>
                <li class="text-gray-900 font-medium" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <span itemprop="name">{{ $product->title }}</span>
                    <meta itemprop="position" content="3">
                </li>
            </ol>
        </nav>

        <div class="rounded-xl overflow-hidden">
            <div class="relative">
                <span
                    class="absolute top-4 left-4 bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full z-10">{{ $product->category->name }}</span>
                <div class="relative">
                    <div class="carousel-container relative h-96 bg-gray-100 rounded-xl overflow-hidden" role="region"
                        aria-label="Product Image Carousel">
                        <div class="carousel-wrapper flex transition-transform duration-300 ease-in-out h-full"
                            id="carousel">
                            @if ($product->images && is_array($product->images) && count($product->images) > 0)
                                @foreach ($product->images as $index => $image)
                                    <div class="carousel-slide min-w-full h-full">
                                        <img src="{{ asset('storage/' . $image) }}"
                                            alt="{{ $product->title }} - Gambar {{ $index + 1 }}"
                                            class="w-full h-full object-cover"
                                            loading="{{ $index === 0 ? 'eager' : 'lazy' }}" width="1280" height="720">
                                    </div>
                                @endforeach
                            @else
                                <div class="carousel-slide min-w-full h-full">
                                    <img src="{{ asset('assets/banners/preview-1.png') }}"
                                        alt="{{ $product->title }} - Gambar Default" class="w-full h-full object-cover"
                                        loading="eager" width="1280" height="720">
                                </div>
                            @endif
                        </div>

                        @if ($product->images && is_array($product->images) && count($product->images) > 1)
                            <button
                                class="carousel-btn carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-black hover:bg-black/75 cursor-pointer bg-opacity-50 text-white w-10 h-10 rounded-full hover:bg-opacity-70 transition-all z-20"
                                aria-label="Previous Image">
                                <span class="bi bi-chevron-left text-lg" aria-hidden="true"></span>
                            </button>
                            <button
                                class="carousel-btn carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-black hover:bg-black/75 cursor-pointer bg-opacity-50 text-white w-10 h-10 rounded-full hover:bg-opacity-70 transition-all z-20"
                                aria-label="Next Image">
                                <span class="bi bi-chevron-right text-lg" aria-hidden="true"></span>
                            </button>

                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20"
                                role="tablist" aria-label="Carousel Navigation Dots">
                                @foreach ($product->images as $index => $image)
                                    <button
                                        class="carousel-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-80 transition-all"
                                        data-slide="{{ $index }}" role="tab"
                                        aria-label="Go to slide {{ $index + 1 }}"
                                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if ($product->images && is_array($product->images) && count($product->images) > 1)
                        <div class="mt-4 flex space-x-2 overflow-x-auto pb-2" role="tablist"
                            aria-label="Thumbnail Navigation">
                            @foreach ($product->images as $index => $image)
                                <button
                                    class="thumbnail-btn cursor-pointer flex-shrink-0 w-20 h-16 rounded-lg overflow-hidden border-2 border-transparent hover:border-green-500 transition-all"
                                    data-slide="{{ $index }}" role="tab"
                                    aria-label="Select thumbnail {{ $index + 1 }}"
                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                    <img src="{{ asset('storage/' . $image) }}"
                                        alt="Thumbnail {{ $product->title }} - Gambar {{ $index + 1 }}"
                                        class="w-full h-full object-cover" loading="lazy" width="80" height="64">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-3 lg:6">
                <div class="flex items-center mb-3">
                    <span
                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1.5 rounded">{{ $product->category->name }}</span>
                </div>

                <header class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->title }}</h1>
                        <div class="flex items-center text-gray-500 text-sm mb-4">
                            <span class="bi bi-geo-alt mr-1" aria-hidden="true"></span>
                            <span>{{ $product->location }}</span>
                        </div>
                    </div>
                    <div>
                        @php
                            $rawNumber = preg_replace('/\D/', '', $product->whatsapp_number);
                            $number = preg_replace('/^0/', '620', $rawNumber);
                            $message = "Halo, saya tertarik dengan produk {$product->title}";
                            $url = "https://wa.me/{$number}?text=" . urlencode($message);
                        @endphp
                        <a href="{{ $url }}" target="_blank" rel="nofollow noopener"
                            class="w-10 h-10 bg-green-400 hover:bg-green-600 text-white rounded flex items-center justify-center transition duration-200"
                            aria-label="Hubungi penjual melalui WhatsApp">
                            <i class="bi bi-whatsapp text-xl"></i>
                        </a>
                    </div>
                </header>

                <div class="flex items-center mb-6">
                    <span class="text-3xl font-bold text-green-600" itemprop="offers" itemscope
                        itemtype="https://schema.org/Offer">
                        <span itemprop="priceCurrency" content="IDR"></span>
                        <span itemprop="price" content="{{ $product->price }}">
                            {{ $product->formatted_price ?? 'Rp ' . number_format($product->price, 0, ',', '.') }}
                        </span>
                        <meta itemprop="availability" content="https://schema.org/InStock">
                    </span>
                </div>

                <section class="border-t border-gray-100 pt-6" itemprop="description">
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Deskripsi Produk</h2>
                    <div class="text-gray-700 space-y-6 leading-relaxed py-5">
                        <section>
                            <h3 class="text-lg font-medium">Ringkasan</h3>
                            <p>{{ $product->description }}</p>
                        </section>

                        @if ($product->detailed_description)
                            <section>
                                <h3 class="text-lg font-medium">Deskripsi Detail</h3>
                                <div class="prose max-w-none [&_ul]:list-disc [&_ol]:list-decimal [&_li]:ml-6">
                                    {!! nl2br(strip_tags($product->detailed_description, '<p><br><strong><em><ul><ol><li>')) !!}
                                </div>
                            </section>
                        @endif

                        @if ($product->product_info && is_array($product->product_info) && count($product->product_info) > 0)
                            <section>
                                <h3 class="text-lg font-medium">Informasi Produk</h3>
                                <ul class="list-disc list-inside space-y-2">
                                    @foreach ($product->product_info as $info)
                                        @if (is_array($info) && isset($info['label']) && isset($info['value']))
                                            <li><strong>{{ $info['label'] }}:</strong> {{ $info['value'] }}</li>
                                        @elseif(is_string($info))
                                            <li>{{ $info }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </section>
                        @endif

                        @if ($product->suitable_for && is_array($product->suitable_for) && count($product->suitable_for) > 0)
                            <section>
                                <h3 class="text-lg font-medium">Cocok Untuk</h3>
                                <ul class="list-disc list-inside space-y-2">
                                    @foreach ($product->suitable_for as $suitable)
                                        <li>{{ $suitable }}</li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </article>

    @push('js')
        <script defer>
            document.addEventListener('DOMContentLoaded', () => {
                const carousel = document.getElementById('carousel');
                const slides = document.querySelectorAll('.carousel-slide');
                const dots = document.querySelectorAll('.carousel-dot');
                const thumbnails = document.querySelectorAll('.thumbnail-btn');
                const prevBtn = document.querySelector('.carousel-prev');
                const nextBtn = document.querySelector('.carousel-next');

                if (slides.length === 0) return;

                let currentSlide = 0;
                const totalSlides = slides.length;

                function updateCarousel() {
                    carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
                    dots.forEach((dot, idx) => {
                        dot.classList.toggle('bg-white', idx === currentSlide);
                        dot.classList.toggle('bg-opacity-50', idx !== currentSlide);
                        dot.setAttribute('aria-selected', idx === currentSlide ? 'true' : 'false');
                    });
                    thumbnails.forEach((thumb, idx) => {
                        thumb.classList.toggle('border-green-500', idx === currentSlide);
                        thumb.classList.toggle('border-transparent', idx !== currentSlide);
                        thumb.setAttribute('aria-selected', idx === currentSlide ? 'true' : 'false');
                    });
                }

                function nextSlide() {
                    currentSlide = (currentSlide + 1) % totalSlides;
                    updateCarousel();
                }

                function prevSlide() {
                    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                    updateCarousel();
                }

                function goToSlide(slideIndex) {
                    currentSlide = slideIndex;
                    updateCarousel();
                }

                // Event listeners
                nextBtn?.addEventListener('click', nextSlide);
                prevBtn?.addEventListener('click', prevSlide);

                dots.forEach((dot, idx) => {
                    dot.addEventListener('click', () => goToSlide(idx));
                });

                thumbnails.forEach((thumb, idx) => {
                    thumb.addEventListener('click', () => goToSlide(idx));
                });

                // Keyboard navigation
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') prevSlide();
                    if (e.key === 'ArrowRight') nextSlide();
                });

                // Auto-slide
                if (totalSlides > 1) {
                    setInterval(nextSlide, 5000);
                }

                updateCarousel();
            });
        </script>
    @endpush
@endsection
