@extends('layouts.app')

@section('content')
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="/" class="hover:text-blue-600">Beranda</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li><a href="/wisata" class="hover:text-blue-600">UMKM</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li class="text-gray-900 font-medium">Beras Organik Premium</li>
            </ol>
        </nav>

        <div class="rounded-xl overflow-hidden">
            <div class="relative">
                <span class="absolute top-4 left-4 bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full z-10">Makanan</span>

                <!-- Image Carousel -->
                <div class="relative">
                    <div class="carousel-container relative h-96 bg-gray-100 rounded-xl overflow-hidden">
                        <!-- Carousel Images -->
                        <div class="carousel-wrapper flex transition-transform duration-300 ease-in-out h-full" id="carousel">
                            <div class="carousel-slide min-w-full h-full">
                                <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" alt="Beras Organik - Sawah" class="w-full h-full object-cover">
                            </div>
                            <div class="carousel-slide min-w-full h-full">
                                <img src="{{ asset('assets/banners/gellery/beras-1.jpg') }}" alt="Beras Organik - Produk" class="w-full h-full object-cover">
                            </div>
                            <div class="carousel-slide min-w-full h-full">
                                <img src="{{ asset('assets/banners/gellery/beras-2.jpg') }}" alt="Beras Organik - Kemasan" class="w-full h-full object-cover">
                            </div>
                            <div class="carousel-slide min-w-full h-full">
                                <img src="{{ asset('assets/banners/gellery/petani.jpg') }}" alt="Petani Desa Sejahtera" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Navigation Arrows -->
                        <button class="carousel-btn carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70 transition-all z-20">
                            <i class="bi bi-chevron-left text-lg"></i>
                        </button>
                        <button class="carousel-btn carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70 transition-all z-20">
                            <i class="bi bi-chevron-right text-lg"></i>
                        </button>

                        <!-- Dots Indicator -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20">
                            <button class="carousel-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-80 transition-all" data-slide="0"></button>
                            <button class="carousel-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-80 transition-all" data-slide="1"></button>
                            <button class="carousel-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-80 transition-all" data-slide="2"></button>
                            <button class="carousel-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-80 transition-all" data-slide="3"></button>
                        </div>
                    </div>

                    <!-- Thumbnail Navigation -->
                    <div class="mt-4 flex space-x-2 overflow-x-auto pb-2">
                        <button class="thumbnail-btn flex-shrink-0 w-20 h-16 rounded-lg overflow-hidden border-2 border-transparent hover:border-green-500 transition-all" data-slide="0">
                            <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" alt="Thumbnail 1" class="w-full h-full object-cover">
                        </button>
                        <button class="thumbnail-btn flex-shrink-0 w-20 h-16 rounded-lg overflow-hidden border-2 border-transparent hover:border-green-500 transition-all" data-slide="1">
                            <img src="{{ asset('assets/banners/gellery/beras-1.jpg') }}" alt="Thumbnail 2" class="w-full h-full object-cover">
                        </button>
                        <button class="thumbnail-btn flex-shrink-0 w-20 h-16 rounded-lg overflow-hidden border-2 border-transparent hover:border-green-500 transition-all" data-slide="2">
                            <img src="{{ asset('assets/banners/gellery/beras-2.jpg') }}" alt="Thumbnail 3" class="w-full h-full object-cover">
                        </button>
                        <button class="thumbnail-btn flex-shrink-0 w-20 h-16 rounded-lg overflow-hidden border-2 border-transparent hover:border-green-500 transition-all" data-slide="3">
                            <img src="{{ asset('assets/banners/gellery/petani.jpg') }}" alt="Thumbnail 4" class="w-full h-full object-cover">
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="flex items-center mb-3">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1.5 rounded">Pertanian</span>
                </div>

                <div class="flex justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-2">Beras Organik Premium Hasil Panen Desa Sejahtera</h1>
                        <div class="flex items-center text-gray-500 text-sm mb-4">
                            <i class="bi bi-geo-alt mr-1"></i>
                            <span>Desa Sejahtera, Kecamatan Makmur, Kabupaten Bahagia</span>
                        </div>
                    </div>
                    <div class="">
                        <button class="bg-green-400 rounded px-4 py-2 text-white cursor-pointer hover:bg-green-600">
                            <i class="bi bi-whatsapp"></i> Hubungi Penjual
                        </button>
                    </div>
                </div>

                <div class="flex items-center mb-6">
                    <div class="text-3xl font-bold text-green-600">Rp 85.000</div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Deskripsi Produk</h2>
                    <div class="text-gray-700 space-y-6 leading-relaxed py-5">
                        <section>
                            <h3 class="text-lg font-medium">✅ Ringkasan</h3>
                            <p>
                                Beras Organik Premium adalah pilihan tepat bagi Anda yang mengutamakan kesehatan dan
                                kualitas dalam konsumsi sehari-hari. Dihasilkan oleh petani lokal dari <strong>Desa Sejahtera</strong>, produk ini
                                menawarkan kesegaran alami tanpa bahan kimia sintetis.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-medium">🌿 Keunggulan Produk</h3>
                            <ul class="list-disc list-inside space-y-2">
                                <li>
                                    <strong>Ditanam secara organik:</strong> Beras ini tumbuh dengan metode pertanian ramah
                                    lingkungan <em>tanpa pestisida kimia</em>, menjaga kesuburan tanah dan ekosistem alami.
                                </li>
                                <li>
                                    <strong>Kualitas butir terbaik:</strong> Dipilih dari hasil panen terbaik dengan
                                    <em>butiran beras yang utuh</em>, bersih, dan memiliki <em>aroma khas alami</em> yang harum.
                                </li>
                                <li>
                                    <strong>Sertifikasi Organik Nasional:</strong> Telah <em>tersertifikasi secara
                                        resmi</em> oleh lembaga terkait, menjamin bahwa proses produksi memenuhi standar organik nasional.
                                </li>
                                <li>
                                    <strong>Kemasan Vakum Modern:</strong> Dikemas dengan <em>teknologi vakum</em> untuk
                                    menjaga kualitas dan kesegaran beras agar lebih tahan lama serta higienis saat sampai ke tangan konsumen.
                                </li>
                            </ul>
                        </section>

                        <section>
                            <h3 class="text-lg font-medium">📦 Informasi Tambahan</h3>
                            <ul class="list-disc list-inside">
                                <li>Asal produk: Desa Sejahtera, Indonesia</li>
                                <li>Jenis beras: Organik medium grain</li>
                                <li>Berat bersih: Tersedia dalam ukuran 1 kg, 2.5 kg, dan 5 kg</li>
                                <li>Masa simpan: Hingga 12 bulan dalam suhu ruang dan tempat kering</li>
                            </ul>
                        </section>

                        <section>
                            <h3 class="text-lg font-medium">🍽️ Cocok Untuk</h3>
                            <ul class="list-disc list-inside">
                                <li>Keluarga yang mengutamakan gaya hidup sehat</li>
                                <li>Restoran yang menyajikan makanan sehat dan alami</li>
                                <li>Individu dengan alergi atau sensitivitas terhadap bahan kimia</li>
                            </ul>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('carousel');
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.carousel-dot');
            const thumbnails = document.querySelectorAll('.thumbnail-btn');
            const prevBtn = document.querySelector('.carousel-prev');
            const nextBtn = document.querySelector('.carousel-next');

            let currentSlide = 0;
            const totalSlides = slides.length;

            function updateCarousel() {
                // Update carousel position
                carousel.style.transform = `translateX(-${currentSlide * 100}%)`;

                // Update dots
                dots.forEach((dot, index) => {
                    if (index === currentSlide) {
                        dot.classList.add('bg-white');
                        dot.classList.remove('bg-opacity-50');
                    } else {
                        dot.classList.remove('bg-white');
                        dot.classList.add('bg-opacity-50');
                    }
                });

                // Update thumbnails
                thumbnails.forEach((thumb, index) => {
                    if (index === currentSlide) {
                        thumb.classList.add('border-green-500');
                        thumb.classList.remove('border-transparent');
                    } else {
                        thumb.classList.remove('border-green-500');
                        thumb.classList.add('border-transparent');
                    }
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
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => goToSlide(index));
            });

            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', () => goToSlide(index));
            });

            // Auto-slide (optional)
            setInterval(nextSlide, 5000);

            // Initialize
            updateCarousel();
        });
    </script>
@endsection
