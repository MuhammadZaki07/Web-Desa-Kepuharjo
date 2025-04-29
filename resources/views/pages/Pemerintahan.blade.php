@extends('layouts.app')
@php
    $pengurusDesa = [
        ['nama' => 'Jhon Doe', 'jabatan' => 'Kepala Desa', 'foto' => 'fotobgred.jpg'],
        ['nama' => 'Jane Smith', 'jabatan' => 'Sekretaris Desa', 'foto' => 'fotobgred.jpg'],
        ['nama' => 'Ahmad Fauzi', 'jabatan' => 'Bendahara Desa', 'foto' => 'fotobgred.jpg'],
        ['nama' => 'Siti Aminah', 'jabatan' => 'Kasi Pelayanan', 'foto' => 'fotobgred.jpg'],
        ['nama' => 'Dedi Santoso', 'jabatan' => 'Kaur Umum', 'foto' => 'fotobgred.jpg'],
        ['nama' => 'Lina Marlina', 'jabatan' => 'Kasi Pemerintahan', 'foto' => 'fotobgred.jpg'],
        ['nama' => 'Budi Setiawan', 'jabatan' => 'Kasi Kesejahteraan', 'foto' => 'fotobgred.jpg'],
        ['nama' => 'Rina Andini', 'jabatan' => 'Kaur Perencanaan', 'foto' => 'fotobgred.jpg'],
    ];
@endphp
@section('content')
    <x-banner-pemerintahan>
        <section class="w-full h-[464px] relative bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('assets/banners/pemerintahan/pemerintahan.jpg') }}')">
            <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-r from-black to-transparent"></div>
            <div
                class="absolute flex justify-start flex-col gap-4 lg:w-4/5 lg:left-15 left-0 top-1/4 sm:top-40 lg:px-4 px-8">
                <h1 class="font-bold text-white lg:text-6xl text-5xl lg:text-left text-center">Pemerintahan</h1>
                <p class="lg:text-left text-center lg:text-lg text-sm text-white font-normal lg:w-2/3">
                    Informasi seputar struktur, tugas, dan layanan pemerintahan Desa Kepuharjo. Wujud transparansi dan
                    pelayanan publik demi membangun desa yang maju, mandiri, dan berdaya saing.
                </p>
            </div>
        </section>
        <div class="lg:px-20 px-5">
            <div class="flex flex-col gap-5 py-20">
                <h1 class="font-semibold text-4xl text-center lg:text-left">Pemerintahan Desa</h1>
                <p class="lg:text-xl font-extralight text-lg">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                    reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                    cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
                </p>
            </div>
        </div>
    </x-banner-pemerintahan>
    <x-sambutan class="bg-slate-50 w-full py-24 px-5 lg:px-20" id="">
        <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center gap-12 py-10">
            <div class="w-48 h-48 lg:w-64 lg:h-64 overflow-hidden shadow-lg mx-auto">
                <img src="{{ asset('assets/images/profile.jpg') }}" alt="Kepala Desa" class="w-full h-full object-cover" />
            </div>

            <div class="flex-1 text-gray-800 relative">
                <div
                    class="absolute top-0 left-0 -translate-x-6 -translate-y-6 text-6xl text-black select-none hidden lg:block">
                    “</div>
                <h2 class="text-2xl lg:text-5xl font-bold mb-4 text-black text-center lg:text-left">Sambutan Kepala Desa
                </h2>
                <p class="text-lg leading-relaxed font-light text-center lg:text-left">
                    Dengan rasa syukur dan bangga, kami menyambut Anda di website resmi Desa Kepuharjo. Melalui platform
                    ini, kami berkomitmen untuk menghadirkan informasi yang transparan, aktual, serta mempererat komunikasi
                    antara pemerintah desa dan masyarakat. Semoga website ini menjadi sarana yang bermanfaat bagi kita
                    semua.
                </p>
                <div class="mt-6 text-center lg:text-left">
                    <p class="font-semibold text-black text-xl">H. Suparman</p>
                    <p class="text-sm text-gray-500 font-light">Kepala Desa Kepuharjo</p>
                </div>
            </div>
        </div>
    </x-sambutan>
    <x-pengurus-desa :pengurusDesa="$pengurusDesa" />
    <x-prestasi-desa />
    <section class="w-full px-5 lg:px-20 py-28 flex justify-center flex-col gap-10">
        <h1 class="text-3xl text-center font-medium">Share this page</h1>
        <div class="grid grid-cols-3 gap-10 mx-auto justify-items-center">
            <div class="bg-green-500 flex justify-center items-center rounded-full w-16 h-16">
                <i class="bi bi-instagram font-bold text-3xl text-white"></i>
            </div>
            <div class="bg-green-500 flex justify-center items-center rounded-full w-16 h-16">
                <i class="bi bi-facebook font-bold text-3xl text-white"></i>
            </div>
            <div class="bg-green-500 flex justify-center items-center rounded-full w-16 h-16">
                <i class="bi bi-whatsapp font-bold text-3xl text-white"></i>
            </div>
        </div>
    </section>
@endsection
