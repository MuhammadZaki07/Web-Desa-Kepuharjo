@extends('layouts.app')
@section('content')
    <x-hero-banner />
    <section class="w-full lg:px-32 px-4 lg:pb-16">
        <div class="bg-green-600 py-0.5 rounded-full mt-7"></div>

        <nav class="w-full border-b border-slate-200 lg:border-none py-0 lg:py-5">
            <ul class="flex flex-wrap justify-center gap-4 md:gap-8 lg:gap-15 px-4 py-4">
                <li class="tab relative font-semibold text-sm md:text-base text-slate-500 hover:text-green-600 hover:border-green-600 pb-2 border-b-2 border-transparent cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-105"
                    data-target="sambutan">Sambutan <span class="hidden lg:inline-block">Kades</span></li>
                <li class="tab relative font-semibold text-sm md:text-base text-slate-500 hover:text-green-600 hover:border-green-600 pb-2 border-b-2 border-transparent cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-105"
                    data-target="data-penduduk">Data Penduduk</li>
                <li class="tab relative font-semibold text-sm md:text-base text-slate-500 hover:text-green-600 hover:border-green-600 pb-2 border-b-2 border-transparent cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-105"
                    data-target="visi-misi">Visi Misi</li>
                <li class="tab relative font-semibold text-sm md:text-base text-slate-500 hover:text-green-600 hover:border-green-600 pb-2 border-b-2 border-transparent cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-105"
                    data-target="sejarah">Sejarah</li>
            </ul>
        </nav>

        <div class="lg:px-20 px-0 py-5">
            <div id="sambutan" class="tab-content w-full py-3">
                <x-badge class="py-2 lg:flex mx-auto hidden">Sambutan Kades</x-badge>
                <p class="text-center text-slate-500 font-semibold mt-5 hidden lg:block">Sambutan Bersama Pak Khamim Selaku Kepala Desa
                    Kepuharjo </p>
                <div class="flex flex-col lg:flex-row px-6 lg:px-20 py-8 lg:py-14 rounded-2xl shadow-lg gap-10 bg-white">
                    <div class="flex flex-col items-center text-center w-full lg:w-1/3 gap-2">
                        <div class="border-4 border-white lg:rounded-full rounded-lg lg:w-32 lg:h-32 w-42 h-42 overflow-hidden shadow-md">
                            <img src="{{ asset('assets/images/profile.jpg') }}" alt="Foto Kepala Desa"
                                class="w-full h-full object-cover">
                        </div>
                        <h1 class="font-semibold text-lg mt-2">Khamim Karangploso</h1>
                        <p class="text-green-600 font-medium">Kepala Desa</p>
                        <p class="text-xs text-slate-400">Masa Jabatan: 2020–2023</p>
                    </div>

                    <div class="text-slate-600 text-justify leading-relaxed font-normal text-base w-full lg:w-2/3">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Error sapiente qui molestias voluptas?
                            Consectetur ipsam soluta quisquam facere eum aliquid quod dolore laborum, eligendi animi. Lorem
                            ipsum dolor sit amet consectetur adipisicing elit. Error sapiente qui molestias voluptas?
                            Consectetur ipsam soluta quisquam facere eum aliquid quod dolore laborum, eligendi animi.
                            <br><br>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Error sapiente qui molestias voluptas?
                            Consectetur ipsam soluta quisquam facere eum aliquid quod dolore laborum, eligendi animi.
                        </p>
                    </div>
                </div>
            </div>
            <div id="data-penduduk" class="tab-content hidden w-full py-3">
                <x-badge class="py-2 lg:flex mx-auto hidden">Data Penduduk</x-badge>
                <p class="text-center text-slate-500 font-semibold mt-5 hidden lg:block">Data Penduduk Desa Kepuharjo Karangploso Kabupaten
                    Malang</p>
                    <div class="grid lg:grid-cols-3 grid-cols-1 lg:gap-10 gap-5 lg:py-10 py-5">
                        <!-- Card 1 -->
                        <div class="relative bg-white rounded-xl shadow-md p-5 w-full">
                            <div class="absolute top-0 left-0 w-full h-2 bg-green-800 rounded-t-xl"></div>
                            <div class="flex items-center gap-2 bg-green-100 text-green-800 px-2 py-1 rounded-md w-max mt-5">
                                <i class="bi-people-fill text-green-800"></i>
                                <span class="text-sm font-medium text-green-800">UMKM</span>
                            </div>
                            <div class="mt-6">
                                <div class="flex items-end gap-2">
                                    <h2 class="text-5xl sm:text-4xl font-bold text-black">20</h2>
                                    <span class="text-green-800 font-medium lg:text-sm text-lg">Jiwa</span>
                                </div>
                                <p class="text-slate-400 font-semibold mt-2 text-sm sm:text-base">Total Penduduk Desa</p>
                                <div class="h-1 bg-green-800 w-20 mt-2 rounded-full"></div>
                            </div>
                            <div class="absolute right-5 bottom-5 opacity-20 text-8xl sm:text-7xl text-green-200">
                                <i class="bi-people-fill"></i>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="relative bg-white rounded-xl shadow-md p-5 w-full">
                            <div class="absolute top-0 left-0 w-full h-2 bg-red-500 rounded-t-xl"></div>
                            <div class="flex items-center gap-2 bg-red-100 text-red-600 px-2 py-1 rounded-md w-max mt-5">
                                <i class="bi bi-shop text-red-500"></i>
                                <span class="text-sm font-medium text-red-500">UMKM</span>
                            </div>
                            <div class="mt-6">
                                <div class="flex items-end gap-2">
                                    <h2 class="text-5xl sm:text-4xl font-bold text-black">20</h2>
                                    <span class="text-red-600 font-medium lg:text-sm text-lg">Jiwa</span>
                                </div>
                                <p class="text-slate-400 font-semibold mt-2 text-sm sm:text-base">Total Penduduk Desa</p>
                                <div class="h-1 bg-red-400 w-20 mt-2 rounded-full"></div>
                            </div>
                            <div class="absolute right-5 bottom-5 opacity-20 text-8xl sm:text-7xl text-red-200">
                                <i class="bi bi-shop"></i>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="relative bg-white rounded-xl shadow-md p-5 w-full">
                            <div class="absolute top-0 left-0 w-full h-2 bg-blue-400 rounded-t-xl"></div>
                            <div class="flex items-center gap-2 bg-blue-100 text-blue-600 px-2 py-1 rounded-md w-max mt-5">
                                <i class="bi bi-shop"></i>
                                <span class="text-sm font-medium text-blue-600">UMKM</span>
                            </div>
                            <div class="mt-6">
                                <div class="flex items-end gap-2">
                                    <h2 class="text-5xl sm:text-4xl font-bold text-black">20</h2>
                                    <span class="text-blue-600 font-medium lg:text-sm text-lg">Jiwa</span>
                                </div>
                                <p class="text-slate-400 font-semibold mt-2 text-sm sm:text-base">Total Penduduk Desa</p>
                                <div class="h-1 bg-blue-400 w-20 mt-2 rounded-full"></div>
                            </div>
                            <div class="absolute right-5 bottom-5 opacity-20 text-8xl sm:text-7xl text-blue-200">
                                <i class="bi bi-shop"></i>
                            </div>
                        </div>
                    </div>

            </div>
            <div id="visi-misi" class="tab-content hidden w-full py-3">
                <div class="lg:flex gap-3 items-center hidden">
                    <div
                        class="w-[70px] h-[70px] rounded-lg shadow-lg border-4 border-green-600 flex justify-center items-center">
                        <i class="bi bi-file-earmark-text text-blue-500 text-3xl"></i>
                    </div>
                    <div class="w-full bg-white shadow rounded-lg text-left text-xl text-slate-600 px-3 py-1.5">
                        Fungsi dari visi & misi di desa kami yaitu untuk pembangunan desa juga untuk mewujudkan
                        kesejahteraan
                        masyarakat
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-white rounded-3xl shadow-2xl p-10 flex flex-col gap-8 mt-0 lg:mt-8">
                    <div class="flex flex-col items-start gap-4">
                        <div
                            class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-semibold">
                            <i class="bi bi-eye-fill"></i> Visi
                        </div>
                        <p class="text-slate-700 text-lg font-medium leading-relaxed">
                            "Mewujudkan desa yang mandiri, sejahtera, dan berdaya saing melalui inovasi pembangunan
                            berkelanjutan."
                        </p>
                    </div>

                    <div class="border-b border-slate-300"></div>

                    <div class="flex flex-col items-start gap-4">
                        <div
                            class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-semibold">
                            <i class="bi bi-flag-fill"></i> Misi
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                            <div class="flex items-start gap-3">
                                <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
                                <p class="text-slate-700 leading-relaxed">Meningkatkan kualitas pendidikan dan kesehatan
                                    masyarakat.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
                                <p class="text-slate-700 leading-relaxed">Mengembangkan sektor pertanian, UMKM, dan
                                    pariwisata.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
                                <p class="text-slate-700 leading-relaxed">Meningkatkan infrastruktur dan layanan publik
                                    desa.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
                                <p class="text-slate-700 leading-relaxed">Mendorong partisipasi aktif masyarakat dalam
                                    pembangunan desa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sejarah" class="tab-content hidden w-full py-3">
                <x-badge class="py-2 lg:flex mx-auto hidden">Sejarah Desa</x-badge>
                <p class="text-center text-slate-500 font-semibold mt-5 hidden lg:block">Sejarah desa Kepuharjo, Karangploso, Kabupaten
                    Malang, Jawa Timur</p>
                <div
                    class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl overflow-hidden p-8 md:p-12 flex flex-col md:flex-row gap-10 items-center transition-all duration-500 hover:shadow-3xl mt-5">
                    <div class="w-full md:w-5/12 relative overflow-hidden rounded-2xl">
                        <img src="{{ asset('assets/images/kepuharjo.jpeg') }}" alt="Sejarah Desa"
                            class="object-cover w-full h-72 md:h-96 scale-100 transition-all duration-500 rounded-2xl filter grayscale">
                    </div>

                    <!-- Konten -->
                    <div class="flex-1 flex flex-col justify-center gap-6">
                        <div class="flex flex-col gap-2">
                            <h2
                                class="text-4xl md:text-5xl font-extrabold text-slate-800 leading-tight tracking-tight hover:text-green-600 transition-all duration-300">
                                Sejarah <span class="text-green-600">Desa Kepuharjo</span>
                            </h2>
                            <p class="text-slate-500 text-base leading-relaxed max-w-2xl">
                                <span class="font-semibold text-slate-700">Lorem ipsum</span> dolor sit amet, consectetur
                                adipiscing elit.
                                Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit
                                amet, consectetur adipiscing elit.
                            </p>
                        </div>

                        <div>
                            <a href="#"
                                class="inline-flex items-center px-5 py-2 rounded-full bg-green-500 hover:bg-green-600 text-white text-sm font-semibold shadow-md transition-all duration-300">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <x-latest-information :blogs="$blogs" />
    @include('partials.LocationContact')
    @include('partials.footer')
@endsection

@push('js')
    <script>
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');

        function activateTab(targetId) {
            tabs.forEach(t => {
                t.classList.remove('text-green-600', 'border-b-4', 'border-b-green-600');
                t.classList.add('text-slate-400');
            });

            contents.forEach(c => c.classList.add('hidden'));

            const activeTab = document.querySelector(`.tab[data-target="${targetId}"]`);
            const activeContent = document.getElementById(targetId);

            if (activeTab && activeContent) {
                activeTab.classList.remove('text-slate-400');
                activeTab.classList.add('text-green-600', 'border-b-4', 'border-b-green-600');
                activeContent.classList.remove('hidden');
            }
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const targetId = tab.getAttribute('data-target');
                activateTab(targetId);
                localStorage.setItem('activeTab', targetId);
            });
        });

        window.addEventListener('DOMContentLoaded', () => {
            const savedTab = localStorage.getItem('activeTab') || 'sambutan';
            activateTab(savedTab);
        });
    </script>
@endpush
