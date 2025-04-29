@extends('layouts.app')
@php
    $berita = [
        [
            'judul' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT dan Mandiri',
            'gambar' => 'foto_brawijaya_1.png',
            'waktu' => '3 Hari Lalu',
        ],
        [
            'judul' => 'Warga Desa Kepuharjo Gotong Royong Bangun Jalan Menuju Lahan Pertanian',
            'gambar' => 'foto_brawijaya_1.png',
            'waktu' => '1 Minggu Lalu',
        ],
        [
            'judul' => 'Pemerintah Desa Bagikan Bantuan Langsung Tunai kepada Warga Kurang Mampu',
            'gambar' => 'foto_brawijaya_1.png',
            'waktu' => '5 Hari Lalu',
        ],
        [
            'judul' => 'Remaja Karang Taruna Kepuharjo Gelar Festival Budaya dan Kesenian',
            'gambar' => 'foto_brawijaya_1.png',
            'waktu' => '2 Hari Lalu',
        ],
        [
            'judul' => 'Pemerintah Desa Bagikan Bantuan Langsung Tunai kepada Warga Kurang Mampu',
            'gambar' => 'foto_brawijaya_1.png',
            'waktu' => '5 Hari Lalu',
        ],
        [
            'judul' => 'Remaja Karang Taruna Kepuharjo Gelar Festival Budaya dan Kesenian',
            'gambar' => 'foto_brawijaya_1.png',
            'waktu' => '2 Hari Lalu',
        ],
    ];
@endphp
@section('content')
    <div class="lg:px-20 px-5">
        <div class="hidden lg:block">
            <x-running-blog :blogs="$blogs" />
        </div>
        <x-fyp-blogs />
        <div class="lg:py-16 py-10 flex flex-col lg:flex-row gap-10 items-start">
            <div class="flex-1 lg:flex-7">
                <x-content>
                    <div class="border-b-2 border-green-700">
                        <h1 class="text-2xl font-semibold text-black">Berita Terbaru</h1>
                    </div>
                    <div class="py-5 space-y-5">
                        <!-- Berita Besar -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @for ($i = 0; $i < 2; $i++)
                                <div class="group cursor-pointer">
                                    <div class="relative rounded-xl overflow-hidden">
                                        <img src="{{ asset('assets/images/foto_brawijaya 1.png') }}" alt=""
                                            class="w-full h-48 md:h-64 object-cover transition-opacity duration-500 group-hover:opacity-80" />
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/50 group-hover:via-black/20 to-transparent z-10 transition-all duration-500 ease-in-out">
                                        </div>
                                        <div class="absolute inset-0 z-20 overflow-hidden pointer-events-none">
                                            <div
                                                class="absolute w-[50px] h-[500%] bg-white/50 transform rotate-45 translate-x-[-100%] translate-y-[-100%] group-hover:translate-x-[150%] group-hover:translate-y-[150%] transition-all duration-[2000ms] ease-in-out">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="py-2 px-1 flex flex-col gap-2">
                                        <h1
                                            class="font-bold text-gray-800 text-sm md:text-base lg:text-xl hover:text-green-800 hover:underline">
                                            Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri
                                        </h1>
                                        <div class="flex flex-wrap gap-3 items-center">
                                            <div class="py-1 px-2 text-white bg-green-700 font-semibold text-xs rounded">Berita</div>
                                            <div class="flex items-center gap-1 text-gray-600 text-xs">
                                                <i class="bi bi-clock"></i>
                                                <span class="font-semibold">3 Hari Yang Lalu</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- Daftar Berita Kecil -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($berita as $item)
                                <div class="flex gap-3 items-start">
                                    <div class="w-28 h-20 md:w-32 md:h-24 flex-shrink-0 rounded-lg overflow-hidden relative">
                                        <img src="{{ asset('assets/images/foto_brawijaya 1.png') }}"
                                            alt="{{ $item['judul'] }}" class="w-full h-full object-cover">
                                        <div
                                            class="absolute bottom-1 left-1 text-white font-semibold px-1.5 py-0.5 bg-green-700 rounded text-xs shadow">
                                            Berita
                                        </div>
                                    </div>
                                    <div class="flex flex-col justify-between flex-grow">
                                        <h2
                                            class="text-sm font-semibold text-gray-900 leading-snug line-clamp-2 hover:text-green-800 hover:underline cursor-pointer">
                                            {{ $item['judul'] }}
                                        </h2>
                                        <div class="flex items-center gap-2 text-xs text-gray-500 mt-2 flex-wrap">
                                            <span>KepuhNews</span>
                                            <span><i class="bi bi-clock-fill text-slate-500 text-sm"></i></span>
                                            <span>{{ $item['waktu'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </x-content>
            </div>
            <div class="lg:w-1/4 w-full flex flex-col gap-5 mt-10 lg:mt-0">
                <x-youtube />
                <x-latest-blogs />
            </div>
        </div>
    </div>
@endsection
