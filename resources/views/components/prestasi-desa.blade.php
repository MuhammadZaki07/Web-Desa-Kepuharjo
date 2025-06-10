<section class="w-full px-5 lg:px-20 py-10" id="prestasi">
    <h2 class="text-2xl lg:text-5xl uppercase font-semibold mb-6">Prestasi Desa Kepuharjo</h2>
    <div class="bg-green-600 py-0.5 w-1/4 rounded-full"></div>

    <div class="overflow-hidden relative">
        <div id="carouselWrapper" class="w-full">
            <div id="carousel" class="flex transition-transform duration-700 ease-in-out">
            </div>
        </div>
    </div>

    <div class="flex justify-center items-center gap-4 mt-6">
        <button id="prevBtn" class="text-gray-500 hover:text-black">
            <i class="bi bi-arrow-left"></i> Previous
        </button>
        <div id="paginationDots" class="flex gap-2"></div>
        <button id="nextBtn" class="text-gray-500 hover:text-black">
            Next <i class="bi bi-arrow-right"></i>
        </button>
    </div>
</section>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cardsPerPage = 3;
            const dataPrestasi = [{
                    title: 'Inovasi Pengelolaan Sampah Tingkat Nasional',
                    desc: 'Desa Kepuharjo meraih penghargaan atas inovasi sistem pengelolaan sampah terpadu yang efektif dan berkelanjutan.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                },
                {
                    title: 'Juara 1 Lomba Kebersihan Antar Desa',
                    desc: 'Dengan partisipasi aktif warga, Kepuharjo berhasil menyabet juara pertama dalam lomba kebersihan dan keindahan lingkungan tingkat kabupaten.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                },
                {
                    title: 'Pengembangan Ekowisata Berbasis Masyarakat',
                    desc: 'Inisiatif pengembangan ekowisata yang melibatkan masyarakat lokal berhasil meningkatkan perekonomian desa dan memperkenalkan potensi alam Kepuharjo.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                },
                {
                    title: 'Penghargaan Desa Digital Terbaik',
                    desc: 'Kepuharjo diakui sebagai desa digital terbaik atas pemanfaatan teknologi dalam pelayanan publik dan pemberdayaan masyarakat.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                },
                {
                    title: 'Peningkatan Hasil Panen Organik',
                    desc: 'Melalui program pertanian organik, petani Kepuharjo berhasil meningkatkan hasil panen secara signifikan dengan tetap menjaga kelestarian lingkungan.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                },
                {
                    title: 'Pembentukan Bank Sampah Mandiri',
                    desc: 'Inisiatif pembentukan bank sampah mandiri memberikan solusi kreatif dalam mengelola sampah dan meningkatkan kesadaran masyarakat akan pentingnya daur ulang.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                },
                {
                    title: 'Pelatihan Kewirausahaan Pemuda Desa',
                    desc: 'Program pelatihan kewirausahaan bagi pemuda desa berhasil menciptakan lapangan kerja baru dan mendorong kemandirian ekonomi.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                },
                {
                    title: 'Pengembangan Produk Unggulan Lokal',
                    desc: 'Desa Kepuharjo berhasil mengembangkan produk unggulan lokal yang memiliki nilai jual tinggi dan menjadi ciri khas desa.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                },
                {
                    title: 'Sanitasi Total Berbasis Masyarakat (STBM)',
                    desc: 'Keberhasilan implementasi program STBM meningkatkan kualitas kesehatan masyarakat dan menciptakan lingkungan yang lebih bersih.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                },
                {
                    title: 'Ketahanan Pangan Melalui Lumbung Desa',
                    desc: 'Tradisi lumbung desa di Kepuharjo kembali digalakkan untuk menjaga ketahanan pangan dan membantu masyarakat saat musim paceklik.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                },
                {
                    title: 'Pelestarian Seni dan Budaya Lokal',
                    desc: 'Upaya pelestarian seni dan budaya tradisional Kepuharjo berhasil menarik wisatawan dan menjaga identitas desa.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                },
                {
                    title: 'Pemberdayaan Perempuan Melalui UMKM',
                    desc: 'Program pemberdayaan perempuan melalui dukungan terhadap Usaha Mikro, Kecil, dan Menengah (UMKM) meningkatkan peran wanita dalam perekonomian desa.',
                    imgUrl: '{{ asset('assets/banners/gellery/sawah.jpg') }}'
                }
            ];

            const totalPages = Math.ceil(dataPrestasi.length / cardsPerPage);
            let currentPage = 0;

            const carousel = document.getElementById('carousel');
            const paginationDots = document.getElementById('paginationDots');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            function setupCarousel() {
                carousel.innerHTML = '';

                for (let i = 0; i < totalPages; i++) {
                    const pageDiv = document.createElement('div');
                    pageDiv.className =
                        'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 min-w-full px-2 py-10';
                    const items = dataPrestasi.slice(i * cardsPerPage, (i + 1) * cardsPerPage);

                    items.forEach(card => {
                        const cardEl = document.createElement('div');
                        cardEl.innerHTML = `
                        <img src="${card.imgUrl}" class="w-full h-62 object-cover rounded-lg" alt="${card.title}" />
                        <div class="p-4">
                            <h3 class="font-bold text-xl mb-2">${card.title}</h3>
                            <p class="text-sm text-gray-600 line-clamp-3">${card.desc}</p>
                        </div>
                    `;
                        pageDiv.appendChild(cardEl);
                    });

                    carousel.appendChild(pageDiv);
                }
            }

            function updateCarouselPosition() {
                const offset = -currentPage * 100;
                carousel.style.transform = `translateX(${offset}%)`;
            }

            function updateDots() {
                paginationDots.innerHTML = '';
                for (let i = 0; i < totalPages; i++) {
                    const dot = document.createElement('div');
                    dot.className =
                        `w-3 h-3 cursor-pointer ${i === currentPage ? 'bg-green-600' : 'bg-gray-300'}`;
                    dot.addEventListener('click', () => {
                        currentPage = i;
                        updateCarouselPosition();
                        updateDots();
                        updateButtonState();
                    });
                    paginationDots.appendChild(dot);
                }
            }

            function updateButtonState() {
                prevBtn.disabled = currentPage === 0;
                nextBtn.disabled = currentPage === totalPages - 1;
                prevBtn.classList.toggle('opacity-50', currentPage === 0);
                prevBtn.classList.toggle('cursor-not-allowed', currentPage === 0);
                nextBtn.classList.toggle('opacity-50', currentPage === totalPages - 1);
                nextBtn.classList.toggle('cursor-not-allowed', currentPage === totalPages - 1);
            }

            prevBtn.addEventListener('click', function() {
                if (currentPage > 0) {
                    currentPage--;
                    updateCarouselPosition();
                    updateDots();
                    updateButtonState();
                }
            });

            nextBtn.addEventListener('click', function() {
                if (currentPage < totalPages - 1) {
                    currentPage++;
                    updateCarouselPosition();
                    updateDots();
                    updateButtonState();
                }
            });

            setupCarousel();
            updateCarouselPosition();
            updateDots();
            updateButtonState();
        });
    </script>
@endpush
