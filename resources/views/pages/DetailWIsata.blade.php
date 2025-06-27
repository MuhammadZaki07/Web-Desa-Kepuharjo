@extends('layouts.app')
@section('content')
    <div class="lg:px-20 px-5 lg:py-10 py-5">
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="/" class="hover:text-green-600">Beranda</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li><a href="{{ route('wisata.page') }}" class="hover:text-green-600">Wisata</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li class="text-green-900 font-medium">{{ $wisata->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="mb-8">
                    @if ($wisata->gallery_image_urls && count($wisata->gallery_image_urls) > 0)
                        <div class="slider-container rounded-xl overflow-hidden bg-white relative">
                            <div class="slider-track" id="imageSlider">
                                @foreach ($wisata->gallery_image_urls as $index => $image)
                                    <div class="slider-slide">
                                        <img src="{{ $image }}" alt="{{ $wisata->name }} {{ $index + 1 }}"
                                            class="w-full h-96 object-cover">
                                    </div>
                                @endforeach
                            </div>

                            @if (count($wisata->gallery_image_urls) > 1)
                                <button onclick="prevSlide()"
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white w-10 h-10 cursor-pointer hover:bg-black/75 rounded-full hover:bg-opacity-75 transition-all">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button onclick="nextSlide()"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white w-10 h-10 cursor-pointer hover:bg-black/75 rounded-full hover:bg-opacity-75 transition-all">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                    @foreach ($wisata->gallery_image_urls as $index => $image)
                                        <button onclick="goToSlide({{ $index }})"
                                            class="w-3 h-3 rounded-full bg-white opacity-60 hover:opacity-100 transition-opacity slide-indicator {{ $index === 0 ? 'active' : '' }}">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="rounded-xl overflow-hidden shadow-lg bg-white">
                            <img src="{{ $wisata->main_image_url }}" alt="{{ $wisata->name }}"
                                class="w-full h-96 object-cover">
                        </div>
                    @endif
                </div>

                <div class="rounded-xl p-6 mb-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $wisata->name }}</h1>
                            <div class="flex items-center mb-2">
                                @if ($wisata->views > 0)
                                    <div class="flex items-center text-gray-600 mr-4">
                                        <i class="bi bi-eye mr-1"></i>
                                        <span class="text-sm">{{ number_format($wisata->views) }} kali dilihat</span>
                                    </div>
                                @endif
                                @if ($wisata->is_featured)
                                    <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-2 py-1 rounded-full">
                                        <i class="bi bi-star-fill mr-1"></i>
                                        Populer
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="bi bi-geo-alt mr-2"></i>
                                <span>{{ $wisata->address ?? $wisata->location }}</span>
                            </div>
                        </div>
                        <span style="background-color: {{ $wisata->category->color_code ?? '#3B82F6' }}; color: white;"
                            class="bg-{{ $wisata->category->color ?? 'blue' }}-100 text-{{ $wisata->category->color ?? 'blue' }}-800 text-sm font-medium px-3 py-1 rounded-full">
                            {{ $wisata->category->name }}
                        </span>
                    </div>
                </div>

                <div class="rounded-xl p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Tentang Destinasi</h2>
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-700 leading-relaxed mb-4">
                            {!! $wisata->description !!}
                        </p>

                        @if ($wisata->long_description)
                            <div class="text-gray-700 leading-relaxed [&_ul]:list-disc [&_ol]:list-decimal [&_li]:ml-6">
                                {!! $wisata->long_description !!}
                            </div>
                        @endif

                        @if ($wisata->activities && count($wisata->activities) > 0)
                            <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-3">Aktivitas yang Bisa Dilakukan:</h3>
                            <ul class="list-disc list-inside text-gray-700 space-y-1">
                                @foreach ($wisata->activities as $activity)
                                    <li>{{ $activity }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if ($wisata->operating_hours !== 'Tidak tersedia')
                            <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-3">Jam Operasional:</h3>
                            <p class="text-gray-700">{{ $wisata->operating_hours }}</p>
                        @endif

                        @if ($wisata->facilities && count($wisata->facilities) > 0)
                            <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-3">Fasilitas:</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-gray-700">
                                @foreach ($wisata->facilities as $facility)
                                    <div class="flex items-center">
                                        <i class="bi bi-check-circle text-green-500 mr-2"></i>
                                        {{ $facility }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                @if ($wisata->latitude && $wisata->longitude)
                    <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Lokasi</h2>

                        <div class="w-full h-64 rounded-lg overflow-hidden mb-4">
                            <iframe
                                src="https://www.google.com/maps?q={{ $wisata->latitude }},{{ $wisata->longitude }}&hl=id&z=16&output=embed"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Koordinat:</p>
                                <p class="font-mono text-sm">{{ $wisata->latitude }}, {{ $wisata->longitude }}</p>
                            </div>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $wisata->latitude }},{{ $wisata->longitude }}"
                                target="_blank"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                                <i class="bi bi-navigation"></i>
                                Buka di Maps
                            </a>
                        </div>
                    </div>
                @endif

            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl p-6 shadow-sm mb-6 lg:sticky top-4">
                    <div class="text-center mb-6">
                        <p class="text-sm text-gray-600 mb-1">Harga Tiket Masuk</p>
                        <p class="text-3xl font-bold">
                            {{ $wisata->formatted_price }}
                        </p>
                        @if ($wisata->price > 0)
                            <p class="text-sm text-gray-500">per orang</p>
                        @endif
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tiket Dewasa</span>
                            <span class="font-medium">{{ $wisata->formatted_price }}</span>
                        </div>
                        @if ($wisata->child_price)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tiket Anak</span>
                                <span class="font-medium">{{ $wisata->formatted_child_price }}</span>
                            </div>
                        @endif
                        @if ($wisata->parking_motor_price > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Parkir Motor</span>
                                <span class="font-medium">{{ $wisata->formatted_parking_motor_price }}</span>
                            </div>
                        @endif
                        @if ($wisata->parking_car_price > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Parkir Mobil</span>
                                <span class="font-medium">{{ $wisata->formatted_parking_car_price }}</span>
                            </div>
                        @endif
                    </div>

                    @if ($wisata->whatsapp)
                        <a href="{{ $wisata->getWhatsAppBookingUrl() }}" target="_blank"
                            class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center gap-2 mb-4 transition-colors">
                            <i class="bi bi-whatsapp text-xl"></i>
                            <span>Pesan via WhatsApp</span>
                        </a>
                    @endif

                    <p class="text-xs text-gray-500 text-center">
                        *Untuk informasi lebih lanjut, hubungi kontak yang tersedia
                    </p>
                </div>

                @if ($wisata->phone || $wisata->whatsapp || $wisata->email)
                    <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontak</h3>
                        <div class="space-y-3">
                            @if ($wisata->phone)
                                <div class="flex items-center">
                                    <i class="bi bi-telephone text-blue-500 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Telepon</p>
                                        <p class="font-medium">{{ $wisata->phone }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($wisata->whatsapp)
                                <div class="flex items-center">
                                    <i class="bi bi-whatsapp text-green-500 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">WhatsApp</p>
                                        <p class="font-medium">{{ $wisata->whatsapp }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($wisata->email)
                                <div class="flex items-center">
                                    <i class="bi bi-envelope text-red-500 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="font-medium">{{ $wisata->email }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if ($wisata->social_media && count($wisata->social_media) > 0)
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Media Sosial</h3>
                        <div class="flex space-x-3 flex-wrap gap-y-3">
                            @foreach ($wisata->social_media as $platform => $url)
                                @if ($url)
                                    <a href="https://instagram.com/{{ $url }}" target="_blank"
                                        rel="noopener noreferrer"
                                        class="
                                        @switch($platform)
                                            @case('facebook')
                                                bg-blue-500 hover:bg-blue-600
                                                @break
                                            @case('instagram')
                                                bg-pink-500 hover:bg-pink-600
                                                @break
                                            @case('twitter')
                                                bg-blue-400 hover:bg-blue-500
                                                @break
                                            @case('youtube')
                                                bg-red-500 hover:bg-red-600
                                                @break
                                            @case('tiktok')
                                                bg-red-600 hover:bg-red-700
                                                @break
                                            @default
                                                bg-gray-500 hover:bg-gray-600
                                        @endswitch
                                        text-white w-10 h-10 flex justify-center items-center rounded-lg transition-colors">
                                        <i class="bi bi-{{ $platform }} text-xl"></i>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if ($recommendedWisata && count($recommendedWisata) > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Rekomendasi Wisata Lainnya</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($recommendedWisata as $recommendation)
                        <a href="{{ route('wisata.show', $recommendation->slug) }}" class="block">
                            <div
                                class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group">
                                <div class="relative">
                                    <span
                                        class="absolute top-4 left-4 bg-{{ $recommendation->category->color ?? 'blue' }}-500 text-white text-xs font-medium px-3 py-1 rounded-full z-10">
                                        {{ $recommendation->category->name }}
                                    </span>
                                    <img src="{{ $recommendation->main_image_url }}" alt="{{ $recommendation->name }}"
                                        class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="p-5">
                                    <div class="flex items-center mb-3">
                                        <span
                                            class="bg-{{ $recommendation->category->color ?? 'blue' }}-100 text-{{ $recommendation->category->color ?? 'blue' }}-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ $recommendation->category->name }}
                                        </span>
                                        <div class="flex-1 h-0.5 bg-gray-100 ml-3"></div>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                                        {{ $recommendation->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ Str::limit($recommendation->description, 100) }}
                                    </p>
                                    <div class="flex items-center mb-4">
                                        <i class="bi bi-geo-alt mr-1 text-gray-500"></i>
                                        <span class="text-gray-500 text-sm">{{ $recommendation->location }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-xs text-gray-500">Tiket Masuk</p>
                                            <p class="font-bold text-lg text-gray-800">
                                                {{ $recommendation->formatted_price }}</p>
                                        </div>
                                        <button
                                            class="bg-{{ $recommendation->category->color ?? 'blue' }}-50 border border-{{ $recommendation->category->color ?? 'blue' }}-500 hover:bg-{{ $recommendation->category->color ?? 'blue' }}-500 text-{{ $recommendation->category->color ?? 'blue' }}-600 hover:text-white font-medium rounded-lg px-4 py-2 transition-colors duration-300 flex items-center gap-2">
                                            <i class="bi bi-ticket-detailed"></i>
                                            <span>Detail</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <x-social-media-share />
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if ($wisata->gallery_image_urls && count($wisata->gallery_image_urls) > 1)
                    let currentSlide = 0;
                    const totalSlides = {{ count($wisata->gallery_image_urls) }};
                    let autoSlideInterval;

                    function showSlide(index) {
                        const slider = document.getElementById('imageSlider');
                        const indicators = document.querySelectorAll('.slide-indicator');

                        if (!slider) return;

                        slider.style.transform = `translateX(-${index * 100}%)`;
                        indicators.forEach((indicator, i) => {
                            if (i === index) {
                                indicator.classList.add('active');
                                indicator.style.opacity = '1';
                            } else {
                                indicator.classList.remove('active');
                                indicator.style.opacity = '0.6';
                            }
                        });

                        currentSlide = index;
                    }

                    window.nextSlide = function() {
                        const nextIndex = (currentSlide + 1) % totalSlides;
                        showSlide(nextIndex);
                    }

                    window.prevSlide = function() {
                        const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
                        showSlide(prevIndex);
                    }

                    window.goToSlide = function(index) {
                        showSlide(index);
                    }

                    function startAutoSlide() {
                        autoSlideInterval = setInterval(nextSlide, 5000);
                    }

                    function stopAutoSlide() {
                        clearInterval(autoSlideInterval);
                    }

                    showSlide(0);
                    startAutoSlide();

                    const sliderContainer = document.querySelector('.slider-container');
                    if (sliderContainer) {
                        sliderContainer.addEventListener('mouseenter', stopAutoSlide);
                        sliderContainer.addEventListener('mouseleave', startAutoSlide);
                    }
                @endif
            });
        </script>
    @endpush
@endsection
