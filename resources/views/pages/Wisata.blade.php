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
                    <input type="text" id="searchInput"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                        placeholder="Cari Destinasi Wisata...">
                </div>

                <!-- Filter Options -->
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select id="category"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            <option value="" selected>Semua Kategori</option>
                            <option value="alam">Wisata Alam</option>
                            <option value="budaya">Wisata Budaya</option>
                            <option value="kuliner">Wisata Kuliner</option>
                            <option value="religi">Wisata Religi</option>
                            <option value="sejarah">Wisata Sejarah</option>
                        </select>
                    </div>

                    <div class="flex-1">
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select id="sort"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            <option value="newest" selected>Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="price_low">Harga Terendah</option>
                            <option value="price_high">Harga Tertinggi</option>
                        </select>
                    </div>

                    <div class="flex-1">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Rentang Harga</label>
                        <select id="price"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            <option value="" selected>Semua Harga</option>
                            <option value="0-50000">Di bawah Rp 50.000</option>
                            <option value="50000-100000">Rp 50.000 - 100.000</option>
                            <option value="100000-200000">Rp 100.000 - 200.000</option>
                            <option value="200000+">Di atas Rp 200.000</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto" id="wisataContainer">
        </div>

        <div class="mt-10 flex flex-col md:flex-row justify-between items-center max-w-6xl mx-auto"
            id="paginationContainer">
        </div>
    </div>
    <script>
        const wisataData = [{
                id: 1,
                name: "Pantai Malang Selatan",
                category: "alam",
                description: "Pantai dengan pemandangan indah dan ombak yang cocok untuk surfing. Nikmati sunset yang memukau di sore hari.",
                location: "Malang Selatan",
                price: 25000,
                image: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=500&h=300&fit=crop",
                rating: 4.5,
                date: new Date('2024-01-15')
            },
            {
                id: 2,
                name: "Candi Singosari",
                category: "sejarah",
                description: "Candi bersejarah peninggalan Kerajaan Singosari dengan arsitektur yang menawan dan nilai sejarah tinggi.",
                location: "Singosari",
                price: 15000,
                image: "https://images.unsplash.com/photo-1548013146-72479768bada?w=500&h=300&fit=crop",
                rating: 4.2,
                date: new Date('2024-02-10')
            },
            {
                id: 3,
                name: "Kampung Warna-Warni",
                category: "budaya",
                description: "Kampung dengan rumah-rumah berwarna-warni yang instagramable dan penuh dengan seni jalanan yang menarik.",
                location: "Jodipan",
                price: 10000,
                image: "https://images.unsplash.com/photo-1518105779142-d975f22f1b0a?w=500&h=300&fit=crop",
                rating: 4.7,
                date: new Date('2024-01-20')
            },
            {
                id: 4,
                name: "Gunung Bromo",
                category: "alam",
                description: "Gunung berapi aktif dengan pemandangan sunrise yang spektakuler dan lautan pasir yang eksotis.",
                location: "Probolinggo",
                price: 150000,
                image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=300&fit=crop",
                rating: 4.8,
                date: new Date('2024-03-05')
            },
            {
                id: 5,
                name: "Masjid Agung Jami",
                category: "religi",
                description: "Masjid bersejarah dengan arsitektur Islam klasik yang megah dan suasana spiritual yang damai.",
                location: "Malang Kota",
                price: 0,
                image: "https://images.unsplash.com/photo-1564769625392-651f7b8b7fdf?w=500&h=300&fit=crop",
                rating: 4.3,
                date: new Date('2024-02-15')
            },
            {
                id: 6,
                name: "Wisata Kuliner Ijen",
                category: "kuliner",
                description: "Kawasan kuliner dengan berbagai makanan khas Malang yang lezat dan suasana yang nyaman untuk bersantai.",
                location: "Ijen Boulevard",
                price: 75000,
                image: "https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=500&h=300&fit=crop",
                rating: 4.4,
                date: new Date('2024-01-30')
            }
        ];

        let filteredData = [...wisataData];
        let currentPage = 1;
        const itemsPerPage = 3;

        const categoryColors = {
            'alam': {
                bg: 'bg-green-500',
                badge: 'bg-green-100 text-green-800',
                button: 'bg-green-50 border-green-500 hover:bg-green-500 text-green-600 hover:text-white'
            },
            'budaya': {
                bg: 'bg-purple-500',
                badge: 'bg-purple-100 text-purple-800',
                button: 'bg-purple-50 border-purple-500 hover:bg-purple-500 text-purple-600 hover:text-white'
            },
            'kuliner': {
                bg: 'bg-orange-500',
                badge: 'bg-orange-100 text-orange-800',
                button: 'bg-orange-50 border-orange-500 hover:bg-orange-500 text-orange-600 hover:text-white'
            },
            'religi': {
                bg: 'bg-blue-500',
                badge: 'bg-blue-100 text-blue-800',
                button: 'bg-blue-50 border-blue-500 hover:bg-blue-500 text-blue-600 hover:text-white'
            },
            'sejarah': {
                bg: 'bg-amber-500',
                badge: 'bg-amber-100 text-amber-800',
                button: 'bg-amber-50 border-amber-500 hover:bg-amber-500 text-amber-600 hover:text-white'
            }
        };

        function formatPrice(price) {
            if (price === 0) return 'Gratis';
            return 'Rp ' + price.toLocaleString('id-ID');
        }

        function getCategoryName(category) {
            const names = {
                'alam': 'Wisata Alam',
                'budaya': 'Wisata Budaya',
                'kuliner': 'Wisata Kuliner',
                'religi': 'Wisata Religi',
                'sejarah': 'Wisata Sejarah'
            };
            return names[category] || category;
        }

        function createWisataCard(wisata) {
            const colors = categoryColors[wisata.category];
            return `
                <a href="/wisata/detail-wisata" class="block">
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group">
                        <div class="relative">
                            <span class="absolute top-4 left-4 ${colors.bg} text-white text-xs font-medium px-3 py-1 rounded-full z-10">
                                ${getCategoryName(wisata.category)}
                            </span>
                            <img src="${wisata.image}" alt="${wisata.name}"
                                class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>

                        <div class="p-5">
                            <div class="flex items-center mb-3">
                                <span class="${colors.badge} text-xs font-medium px-2.5 py-0.5 rounded">
                                    ${getCategoryName(wisata.category)}
                                </span>
                                <div class="flex-1 h-0.5 bg-gray-100 ml-3"></div>
                            </div>

                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                                ${wisata.name}
                            </h3>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                ${wisata.description}
                            </p>

                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-gray-500">Tiket Masuk</p>
                                    <p class="font-bold text-lg ${wisata.price === 0 ? 'text-green-600' : 'text-gray-800'}">
                                        ${formatPrice(wisata.price)}
                                    </p>
                                </div>
                                <button class="${colors.button} font-medium rounded-lg px-4 py-2 transition-colors duration-300 flex items-center gap-2">
                                    <i class="bi bi-ticket-detailed"></i>
                                    <span>Detail</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            `;
        }

        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryFilter = document.getElementById('category').value;
            const sortFilter = document.getElementById('sort').value;
            const priceFilter = document.getElementById('price').value;

            filteredData = wisataData.filter(wisata => {
                // Search filter
                const matchesSearch = wisata.name.toLowerCase().includes(searchTerm) ||
                    wisata.description.toLowerCase().includes(searchTerm) ||
                    wisata.location.toLowerCase().includes(searchTerm);

                // Category filter
                const matchesCategory = !categoryFilter || wisata.category === categoryFilter;

                // Price filter
                let matchesPrice = true;
                if (priceFilter) {
                    if (priceFilter === '0-50000') {
                        matchesPrice = wisata.price >= 0 && wisata.price < 50000;
                    } else if (priceFilter === '50000-100000') {
                        matchesPrice = wisata.price >= 50000 && wisata.price < 100000;
                    } else if (priceFilter === '100000-200000') {
                        matchesPrice = wisata.price >= 100000 && wisata.price < 200000;
                    } else if (priceFilter === '200000+') {
                        matchesPrice = wisata.price >= 200000;
                    }
                }

                return matchesSearch && matchesCategory && matchesPrice;
            });

            // Sort filter
            filteredData.sort((a, b) => {
                switch (sortFilter) {
                    case 'oldest':
                        return a.date - b.date;
                    case 'price_low':
                        return a.price - b.price;
                    case 'price_high':
                        return b.price - a.price;
                    case 'newest':
                    default:
                        return b.date - a.date;
                }
            });

            currentPage = 1;
            renderWisata();
            renderPagination();
            updateResultInfo();
        }

        function renderWisata() {
            const container = document.getElementById('wisataContainer');
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const currentData = filteredData.slice(startIndex, endIndex);

            if (currentData.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <i class="bi bi-search text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak ada destinasi wisata ditemukan</h3>
                        <p class="text-gray-500">Coba ubah kata kunci pencarian atau filter yang digunakan</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = currentData.map(wisata => createWisataCard(wisata)).join('');
        }

        function renderPagination() {
            const container = document.getElementById('paginationContainer');
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);

            if (totalPages <= 1) {
                container.style.display = 'none';
                return;
            }

            container.style.display = 'flex';

            let paginationHTML = `
                <p class="text-sm text-gray-600 mb-4 md:mb-0">
                    Menampilkan ${Math.min((currentPage - 1) * itemsPerPage + 1, filteredData.length)} -
                    ${Math.min(currentPage * itemsPerPage, filteredData.length)} dari ${filteredData.length} destinasi
                </p>
                <div class="flex items-center space-x-1">
            `;

            // Previous button
            paginationHTML += `
                <button onclick="changePage(${currentPage - 1})"
                    class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-500 hover:bg-gray-50 ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                    ${currentPage === 1 ? 'disabled' : ''}>
                    <i class="bi bi-chevron-left"></i>
                </button>
            `;

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    paginationHTML += `
                        <button class="px-3 py-2 rounded-md bg-blue-500 text-white">${i}</button>
                    `;
                } else {
                    paginationHTML += `
                        <button onclick="changePage(${i})"
                            class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">${i}</button>
                    `;
                }
            }

            // Next button
            paginationHTML += `
                <button onclick="changePage(${currentPage + 1})"
                    class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-500 hover:bg-gray-50 ${currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''}"
                    ${currentPage === totalPages ? 'disabled' : ''}>
                    <i class="bi bi-chevron-right"></i>
                </button>
            `;

            paginationHTML += '</div>';
            container.innerHTML = paginationHTML;
        }

        function changePage(page) {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                renderWisata();
                renderPagination();
                updateResultInfo();
                window.scrollTo(0, 0);
            }
        }

        function updateResultInfo() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredData.length);
            document.getElementById('currentCount').textContent = endIndex;
            document.getElementById('totalCount').textContent = filteredData.length;
        }

        // Event listeners
        document.getElementById('searchInput').addEventListener('input', applyFilters);
        document.getElementById('category').addEventListener('change', applyFilters);
        document.getElementById('sort').addEventListener('change', applyFilters);
        document.getElementById('price').addEventListener('change', applyFilters);

        // Initialize
        renderWisata();
        renderPagination();
        updateResultInfo();
    </script>
@endsection
