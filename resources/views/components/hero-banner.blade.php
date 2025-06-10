@php
    $bannerImages = $banner->images;
    $bannerImagePath =
        !empty($bannerImages) && isset($bannerImages[0])
            ? asset('storage/' . $bannerImages[0])
            : asset('assets/banners/preview-1.png');
@endphp
<div class="relative w-full h-auto min-h-[560px] bg-cover bg-center overflow-hidden"
    style="background-image: url('{{ $bannerImagePath }}');">
    <div class="absolute inset-0 bg-black/45"></div>
    <div
        class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between py-10 px-6 lg:p-0 lg:px-0 lg:pl-20 gap-8 lg:gap-0 h-full">
        <div class="text-white max-w-full lg:max-w-4xl space-y-5">
            <div class="flex flex-col gap-3">
                <h1 class="text-5xl sm:text-6xl lg:text-[7rem] font-bold leading-tight text-center lg:text-left"
                    data-aos="fade-right" data-aos-delay="200">
                    {{ !empty($banner->title[0]) ? $banner->title[0] : 'Title Banner' }}</h1>
                <p class="text-base sm:text-lg lg:text-3xl text-center lg:text-left font-medium" data-aos="fade-right"
                    data-aos-delay="400">{{ $banner->description ?? "No Data" }}</p>
            </div>

            <div class="lg:flex justify-center sm:flex-row gap-4 mt-6 items-center sm:items-start sm:justify-start hidden"
                data-aos="fade-right" data-aos-delay="600">
                <a href="#profiledesa"
                    class="px-6 py-2 bg-white text-gray-800 rounded-md flex items-center gap-2 shadow hover:bg-gray-100 transition cursor-pointer">
                    <i class="bi bi-info-circle-fill"></i> Profile Desa
                </a>
                <button type="button" id="openForm"
                    class="px-6 py-2 bg-green-700 text-white rounded-md flex items-center gap-2 shadow hover:bg-green-900 transition cursor-pointer">
                    <i class="bi bi-headset"></i> Layanan Desa
                </button>
            </div>
        </div>
        <div class="w-full max-w-md lg:w-[500px] h-auto lg:h-[600px] bg-black/40 backdrop-blur-md py-8 px-5 sm:py-10 sm:px-7 text-white space-y-4 flex flex-col justify-center"
            data-aos="fade-left" data-aos-duration="1000">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-semibold pb-1">Bangga Desa Kami</h2>
            <div class="bg-green-700 py-0.5 rounded-full w-1/2"></div>
            <div class="flex flex-col gap-3 w-full sm:w-5/6">
                <a href="/umkm">
                    <div class="flex items-center gap-3 bg-white/20 p-3 rounded-md cursor-pointer hover:bg-white/40"
                        data-aos="zoom-in" data-aos-delay="200">
                        <div
                            class="text-white text-2xl sm:text-3xl font-bold w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-green-700 flex justify-center items-center">
                            <i class="bi bi-shop-window"></i>
                        </div>
                        <div>
                            <p class="font-medium">UMKM Desa</p>
                            <p class="text-sm text-gray-200">Produk lokal dan pelaku usaha desa</p>
                        </div>
                    </div>
                </a>

                <a href="/wisata">
                    <div class="flex items-center gap-3 bg-white/20 p-3 rounded-md cursor-pointer hover:bg-white/40"
                        data-aos="zoom-in" data-aos-delay="400">
                        <div
                            class="text-white text-2xl sm:text-3xl font-bold w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-green-700 flex justify-center items-center">
                            <i class="bi bi-binoculars"></i>
                        </div>
                        <div>
                            <p class="font-medium">Wisata Desa</p>
                            <p class="text-sm text-gray-200">Berbagai Wisata Desa</p>
                        </div>
                    </div>
                </a>

                <a href="/pemerintahan#prestasi">
                    <div class="flex items-center gap-3 bg-white/20 p-3 rounded-md cursor-pointer hover:bg-white/40"
                        data-aos="zoom-in" data-aos-delay="600">
                        <div
                            class="text-white text-2xl sm:text-3xl font-bold w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-green-700 flex justify-center items-center">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <div>
                            <p class="font-medium">Prestasi Desa</p>
                            <p class="text-sm text-gray-200">Berbagai Prestasi Desa</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        const openForm = document.getElementById("openForm");
        const formcard = document.getElementById("formCard");
        const floatingbtn = document.getElementById("floatingBtns");

        // Pasang event listener langsung ke tombol
        openForm.addEventListener("click", (event) => {
            event.stopPropagation(); // supaya klik tombol gak diteruskan ke window
            formcard.classList.remove("invisible", "opacity-0", "scale-90");
            formcard.classList.add("opacity-100", "scale-100");

            if (floatingbtn) {
                floatingbtn.classList.add("hidden");
            }
        });

        // Event untuk tutup form kalau klik di luar form dan tombol
        window.addEventListener("click", (event) => {
            if (
                !formcard.contains(event.target) &&
                !openForm.contains(event.target) &&
                !formcard.classList.contains("invisible")
            ) {
                formcard.classList.remove("opacity-100", "scale-100");
                formcard.classList.add("opacity-0", "scale-90");
                setTimeout(() => formcard.classList.add("invisible"), 300);
            }
        });
    </script>
@endpush
