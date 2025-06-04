@extends('layouts.app')
@section('content')
    <div class="lg:px-20 px-5 lg:py-10 py-5">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="/" class="hover:text-blue-600">Beranda</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li><a href="/wisata" class="hover:text-blue-600">Wisata</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li class="text-gray-900 font-medium">Pantai Malang Selatan</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Image Slider -->
                <div class="mb-8">
                    <div class="slider-container rounded-xl overflow-hidden shadow-lg bg-white">
                        <div class="slider-track" id="imageSlider">
                            <div class="slider-slide">
                                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&h=400&fit=crop"
                                     alt="Pantai Malang Selatan 1" class="w-full h-96 object-cover">
                            </div>
                            <div class="slider-slide">
                                <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&h=400&fit=crop"
                                     alt="Pantai Malang Selatan 2" class="w-full h-96 object-cover">
                            </div>
                            <div class="slider-slide">
                                <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&h=400&fit=crop"
                                     alt="Pantai Malang Selatan 3" class="w-full h-96 object-cover">
                            </div>
                            <div class="slider-slide">
                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=400&fit=crop"
                                     alt="Pantai Malang Selatan 4" class="w-full h-96 object-cover">
                            </div>
                        </div>

                        <!-- Slider Controls -->
                        <button onclick="prevSlide()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-all">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button onclick="nextSlide()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-all">
                            <i class="bi bi-chevron-right"></i>
                        </button>

                        <!-- Slide Indicators -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            <button onclick="goToSlide(0)" class="w-3 h-3 rounded-full bg-white opacity-60 hover:opacity-100 transition-opacity slide-indicator active"></button>
                            <button onclick="goToSlide(1)" class="w-3 h-3 rounded-full bg-white opacity-60 hover:opacity-100 transition-opacity slide-indicator"></button>
                            <button onclick="goToSlide(2)" class="w-3 h-3 rounded-full bg-white opacity-60 hover:opacity-100 transition-opacity slide-indicator"></button>
                            <button onclick="goToSlide(3)" class="w-3 h-3 rounded-full bg-white opacity-60 hover:opacity-100 transition-opacity slide-indicator"></button>
                        </div>
                    </div>
                </div>

                <!-- Title and Rating -->
                <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pantai Malang Selatan</h1>
                            <div class="flex items-center mb-2">
                                <div class="flex items-center text-yellow-400 mr-3">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    <span class="text-gray-600 ml-2">4.5 (128 ulasan)</span>
                                </div>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="bi bi-geo-alt mr-2"></i>
                                <span>Jl. Pantai Selatan, Malang, Jawa Timur</span>
                            </div>
                        </div>
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">Wisata Alam</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Tentang Destinasi</h2>
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Pantai Malang Selatan merupakan salah satu destinasi wisata alam terpopuler di Jawa Timur. Pantai ini menawarkan pemandangan yang menakjubkan dengan hamparan pasir putih yang luas dan ombak yang cocok untuk aktivitas surfing.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Keindahan pantai ini semakin sempurna dengan adanya tebing-tebing karang yang menjulang tinggi di sepanjang garis pantai. Pengunjung dapat menikmati sunset yang memukau di sore hari, menjadikan tempat ini sebagai spot foto yang instagramable.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Fasilitas yang tersedia cukup lengkap mulai dari area parkir yang luas, warung makan, toilet, hingga penyewaan peralatan surfing. Pantai ini juga dilengkapi dengan gazebo dan area istirahat yang nyaman untuk keluarga.
                        </p>

                        <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-3">Aktivitas yang Bisa Dilakukan:</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Surfing dan olahraga air lainnya</li>
                            <li>Fotografi landscape dan portrait</li>
                            <li>Menikmati sunset di sore hari</li>
                            <li>Berjalan-jalan di sepanjang pantai</li>
                            <li>Piknik keluarga di area yang disediakan</li>
                        </ul>

                        <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-3">Jam Operasional:</h3>
                        <p class="text-gray-700">Setiap hari: 06.00 - 18.00 WIB</p>

                        <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-3">Fasilitas:</h3>
                        <div class="grid grid-cols-2 gap-2 text-gray-700">
                            <div class="flex items-center"><i class="bi bi-check-circle text-green-500 mr-2"></i> Area Parkir Luas</div>
                            <div class="flex items-center"><i class="bi bi-check-circle text-green-500 mr-2"></i> Toilet & Kamar Mandi</div>
                            <div class="flex items-center"><i class="bi bi-check-circle text-green-500 mr-2"></i> Warung Makan</div>
                            <div class="flex items-center"><i class="bi bi-check-circle text-green-500 mr-2"></i> Gazebo & Tempat Istirahat</div>
                            <div class="flex items-center"><i class="bi bi-check-circle text-green-500 mr-2"></i> Penyewaan Alat Surfing</div>
                            <div class="flex items-center"><i class="bi bi-check-circle text-green-500 mr-2"></i> Area Foto Instagramable</div>
                        </div>
                    </div>
                </div>

                <!-- Maps -->
                <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Lokasi</h2>
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <i class="bi bi-geo-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-600">Peta Interaktif</p>
                            <p class="text-sm text-gray-500">Jl. Pantai Selatan, Malang, Jawa Timur</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Koordinat:</p>
                            <p class="font-mono text-sm">-8.2543, 112.6304</p>
                        </div>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                            <i class="bi bi-navigation"></i>
                            Buka di Maps
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Price & Booking -->
                <div class="bg-white rounded-xl p-6 shadow-sm mb-6 sticky top-4">
                    <div class="text-center mb-6">
                        <p class="text-sm text-gray-600 mb-1">Harga Tiket Masuk</p>
                        <p class="text-3xl font-bold text-green-600">Rp 25.000</p>
                        <p class="text-sm text-gray-500">per orang</p>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tiket Dewasa</span>
                            <span class="font-medium">Rp 25.000</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tiket Anak (3-12 tahun)</span>
                            <span class="font-medium">Rp 15.000</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Parkir Motor</span>
                            <span class="font-medium">Rp 5.000</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Parkir Mobil</span>
                            <span class="font-medium">Rp 10.000</span>
                        </div>
                    </div>

                    <button onclick="bookViaWhatsApp()" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center gap-2 mb-4 transition-colors">
                        <i class="bi bi-whatsapp text-xl"></i>
                        <span>Pesan via WhatsApp</span>
                    </button>

                    <p class="text-xs text-gray-500 text-center">
                        *Pemesanan dilakukan melalui WhatsApp dengan admin kami
                    </p>
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontak</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="bi bi-telephone text-blue-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Telepon</p>
                                <p class="font-medium">+62 341-123456</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="bi bi-whatsapp text-green-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">WhatsApp</p>
                                <p class="font-medium">+62 812-3456-7890</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="bi bi-envelope text-red-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium">info@pantaimalangselatan.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Media Sosial</h3>
                    <div class="flex space-x-3">
                        <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-lg transition-colors">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="bg-pink-500 hover:bg-pink-600 text-white p-3 rounded-lg transition-colors">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="bg-blue-400 hover:bg-blue-500 text-white p-3 rounded-lg transition-colors">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="bg-red-500 hover:bg-red-600 text-white p-3 rounded-lg transition-colors">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="#" class="bg-red-600 hover:bg-red-700 text-white p-3 rounded-lg transition-colors">
                            <i class="bi bi-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Places -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Rekomendasi Wisata Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Recommendation 1 -->
                <a href="/detail-wisata/2" class="block">
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group">
                        <div class="relative">
                            <span class="absolute top-4 left-4 bg-amber-500 text-white text-xs font-medium px-3 py-1 rounded-full z-10">
                                Wisata Sejarah
                            </span>
                            <img src="https://images.unsplash.com/photo-1548013146-72479768bada?w=500&h=300&fit=crop" alt="Candi Singosari"
                                class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-5">
                            <div class="flex items-center mb-3">
                                <span class="bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    Wisata Sejarah
                                </span>
                                <div class="flex-1 h-0.5 bg-gray-100 ml-3"></div>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">Candi Singosari</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                Candi bersejarah peninggalan Kerajaan Singosari dengan arsitektur yang menawan.
                            </p>
                            <div class="flex items-center mb-4">
                                <i class="bi bi-geo-alt mr-1 text-gray-500"></i>
                                <span class="text-gray-500 text-sm">Singosari</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-gray-500">Tiket Masuk</p>
                                    <p class="font-bold text-lg text-gray-800">Rp 15.000</p>
                                </div>
                                <button class="bg-amber-50 border border-amber-500 hover:bg-amber-500 text-amber-600 hover:text-white font-medium rounded-lg px-4 py-2 transition-colors duration-300 flex items-center gap-2">
                                    <i class="bi bi-ticket-detailed"></i>
                                    <span>Detail</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Recommendation 2 -->
                <a href="/detail-wisata/3" class="block">
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group">
                        <div class="relative">
                            <span class="absolute top-4 left-4 bg-purple-500 text-white text-xs font-medium px-3 py-1 rounded-full z-10">
                                Wisata Budaya
                            </span>
                            <img src="https://images.unsplash.com/photo-1518105779142-d975f22f1b0a?w=500&h=300&fit=crop" alt="Kampung Warna-Warni"
                                class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-5">
                            <div class="flex items-center mb-3">
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    Wisata Budaya
                                </span>
                                <div class="flex-1 h-0.5 bg-gray-100 ml-3"></div>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">Kampung Warna-Warni</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                Kampung dengan rumah-rumah berwarna-warni yang instagramable dan penuh seni.
                            </p>
                            <div class="flex items-center mb-4">
                                <i class="bi bi-geo-alt mr-1 text-gray-500"></i>
                                <span class="text-gray-500 text-sm">Jodipan</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-gray-500">Tiket Masuk</p>
                                    <p class="font-bold text-lg text-gray-800">Rp 10.000</p>
                                </div>
                                <button class="bg-purple-50 border border-purple-500 hover:bg-purple-500 text-purple-600 hover:text-white font-medium rounded-lg px-4 py-2 transition-colors duration-300 flex items-center gap-2">
                                    <i class="bi bi-ticket-detailed"></i>
                                    <span>Detail</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Recommendation 3 -->
                <a href="/detail-wisata/4" class="block">
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group">
                        <div class="relative">
                            <span class="absolute top-4 left-4 bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full z-10">
                                Wisata Alam
                            </span>
                            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=300&fit=crop" alt="Gunung Bromo"
                                class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-5">
                            <div class="flex items-center mb-3">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    Wisata Alam
                                </span>
                                <div class="flex-1 h-0.5 bg-gray-100 ml-3"></div>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">Gunung Bromo</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                Gunung berapi aktif dengan pemandangan sunrise yang spektakuler.
                            </p>
                            <div class="flex items-center mb-4">
                                <i class="bi bi-geo-alt mr-1 text-gray-500"></i>
                                <span class="text-gray-500 text-sm">Probolinggo</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-gray-500">Tiket Masuk</p>
                                    <p class="font-bold text-lg text-gray-800">Rp 150.000</p>
                                </div>
                                <button class="bg-green-50 border border-green-500 hover:bg-green-500 text-green-600 hover:text-white font-medium rounded-lg px-4 py-2 transition-colors duration-300 flex items-center gap-2">
                                    <i class="bi bi-ticket-detailed"></i>
                                    <span>Detail</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const totalSlides = 4;

        function showSlide(index) {
            const slider = document.getElementById('imageSlider');
            const indicators = document.querySelectorAll('.slide-indicator');

            // Update slider position
            slider.style.transform = `translateX(-${index * 100}%)`;

            // Update indicators
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

        function nextSlide() {
            const nextIndex = (currentSlide + 1) % totalSlides;
            showSlide(nextIndex);
        }

        function prevSlide() {
            const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(prevIndex);
        }

        function goToSlide(index) {
            showSlide(index);
        }

        function bookViaWhatsApp() {
            const message = encodeURIComponent(
                "Halo! Saya tertarik untuk berkunjung ke Pantai Malang Selatan.\n\n" +
                "Mohon informasi lebih lanjut mengenai:\n" +
                "- Ketersediaan tiket\n" +
                "- Jadwal kunjungan\n" +
                "- Informasi tambahan\n\n" +
                "Terima kasih!"
            );
            const whatsappUrl = `https://wa.me/6281234567890?text=${message}`;
            window.open(whatsappUrl, '_blank');
        }

        // Auto slide every 5 seconds
        let autoSlide = setInterval(nextSlide, 5000);

        // Pause auto slide on hover
        const sliderContainer = document.querySelector('.slider-container');
        sliderContainer.addEventListener('mouseenter', () => {
            clearInterval(autoSlide);
        });

        sliderContainer.addEventListener('mouseleave', () => {
            autoSlide = setInterval(nextSlide, 5000);
        });

        // Initialize first slide
        showSlide(0);
    </script>
@endsection
