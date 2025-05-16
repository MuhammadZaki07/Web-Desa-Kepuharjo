@extends('layouts.app')
@section('content')
    <x-banner-pemerintahan>
        <section class="w-full h-[500px] relative bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('assets/banners/pemerintahan/ibu-pkk.jpeg') }}')">
            <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-r from-black to-transparent"></div>
            <div
                class="absolute flex justify-start flex-col gap-4 lg:w-4/5 lg:left-15 left-0 top-1/4 sm:top-40 lg:px-4 px-8">
                <h1 class="font-bold text-white lg:text-6xl text-5xl lg:text-left text-center">PKK</h1>
                <p class="lg:text-left text-center lg:text-lg text-sm text-white font-normal lg:w-2/3">
                    Informasi seputar program kerja, kegiatan, dan peran aktif PKK Desa Kepuharjo. Bersama membangun
                    keluarga sejahtera, mandiri, dan berdaya melalui semangat gotong royong dan pemberdayaan masyarakat.
                </p>
            </div>
        </section>
    </x-banner-pemerintahan>
    <div class="px-5 lg:px-20 lg:py-10 py-5">
        <x-layouts-blogs>
            <x-flex-one>
                <x-content>
                    <!-- Judul dan Tanggal -->
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Struktur dan Kegiatan PKK Desa Kepuharjo</h1>
                    <p class="text-sm text-gray-500 mb-6">Diperbarui pada: 4 Mei 2025</p>

                    <!-- Deskripsi -->
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        Pemberdayaan dan Kesejahteraan Keluarga (PKK) adalah gerakan nasional dalam pembangunan masyarakat
                        yang tumbuh dari bawah,
                        dengan wanita sebagai penggerak utamanya. Di Desa Kepuharjo, PKK menjadi mitra strategis pemerintah
                        desa dalam mendukung pembangunan,
                        khususnya dalam bidang keluarga, kesehatan, pendidikan, ekonomi, dan lingkungan.
                    </p>

                    <!-- Struktur Organisasi PKK -->
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Struktur Organisasi PKK Desa Kepuharjo</h2>
                    <table class="w-full text-left text-sm border-t border-gray-200 mb-8">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="py-3 px-4 border-b">Jabatan</th>
                                <th class="py-3 px-4 border-b">Nama</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="py-3 px-4 border-b">Ketua</td>
                                <td class="py-3 px-4 border-b">Ibu Sri Wahyuni</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="py-3 px-4 border-b">Wakil Ketua</td>
                                <td class="py-3 px-4 border-b">Ibu Rina Astuti</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="py-3 px-4 border-b">Sekretaris</td>
                                <td class="py-3 px-4 border-b">Ibu Lestari</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="py-3 px-4 border-b">Bendahara</td>
                                <td class="py-3 px-4 border-b">Ibu Wati</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="py-3 px-4 border-b">Koordinator Pokja I</td>
                                <td class="py-3 px-4 border-b">Ibu Dewi Sari</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="py-3 px-4 border-b">Koordinator Pokja II</td>
                                <td class="py-3 px-4 border-b">Ibu Nina Kartika</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="py-3 px-4 border-b">Koordinator Pokja III</td>
                                <td class="py-3 px-4 border-b">Ibu Erna Sulastri</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="py-3 px-4 border-b">Koordinator Pokja IV</td>
                                <td class="py-3 px-4 border-b">Ibu Yuni Rahayu</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- 10 Program Pokok PKK -->
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">10 Program Pokok PKK</h2>
                    <ul class="list-decimal pl-6 text-gray-700 space-y-2 mb-8">
                        <li>Penghayatan dan Pengamalan Pancasila</li>
                        <li>Gotong Royong</li>
                        <li>Pangan</li>
                        <li>Sandang</li>
                        <li>Perumahan dan Tata Laksana Rumah Tangga</li>
                        <li>Pendidikan dan Keterampilan</li>
                        <li>Kesehatan</li>
                        <li>Pengembangan Kehidupan Berkoperasi</li>
                        <li>Kelestarian Lingkungan Hidup</li>
                        <li>Perencanaan Sehat</li>
                    </ul>

                    <!-- Kegiatan Rutin -->
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Kegiatan Rutin PKK</h2>
                    <ul class="list-disc pl-6 text-gray-700 space-y-2 mb-8">
                        <li>Posyandu Balita dan Lansia setiap bulan</li>
                        <li>Pelatihan keterampilan ibu rumah tangga (menjahit, memasak, dll)</li>
                        <li>Pembinaan remaja melalui kelas remaja sehat</li>
                        <li>Pengelolaan kebun PKK dan bank sampah</li>
                        <li>Arisan dan pertemuan bulanan antar kader</li>
                    </ul>

                    <!-- Kontak -->
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Hubungi Kami</h2>
                    <p class="text-gray-700">
                        Untuk informasi lebih lanjut mengenai kegiatan PKK Desa Kepuharjo, silakan hubungi sekretariat PKK
                        di kantor desa atau melalui WhatsApp: <span class="text-blue-600 font-medium">0812-3456-7890</span>.
                    </p>
                </x-content>
                <div class="w-full pt-10">
                    <div class="flex flex-col gap-4">
                        <h1 class="text-5xl font-bold text-green-600">Gallery <span class="text-black">PKK</span></h1>
                        <div class="bg-green-600 w-1/9 py-0.5"></div>
                    </div>
                    <div class="grid grid-cols-4 gap-5 py-5">
                        <img src="{{ asset('assets/banners/sejarah/1.jpg') }}"
                            class="hover:scale-105 duration-200 transition ease-in-out" alt="">
                        <img src="{{ asset('assets/banners/sejarah/1.jpg') }}"
                            class="hover:scale-105 duration-200 transition ease-in-out" alt="">
                        <img src="{{ asset('assets/banners/sejarah/1.jpg') }}"
                            class="hover:scale-105 duration-200 transition ease-in-out" alt="">
                        <img src="{{ asset('assets/banners/sejarah/1.jpg') }}"
                            class="hover:scale-105 duration-200 transition ease-in-out" alt="">
                        <img src="{{ asset('assets/banners/sejarah/1.jpg') }}"
                            class="hover:scale-105 duration-200 transition ease-in-out" alt="">
                        <img src="{{ asset('assets/banners/sejarah/1.jpg') }}"
                            class="hover:scale-105 duration-200 transition ease-in-out" alt="">
                        <img src="{{ asset('assets/banners/sejarah/1.jpg') }}"
                            class="hover:scale-105 duration-200 transition ease-in-out" alt="">
                        <img src="{{ asset('assets/banners/sejarah/1.jpg') }}"
                            class="hover:scale-105 duration-200 transition ease-in-out" alt="">
                    </div>
                </div>
            </x-flex-one>
            <x-flex-two>
                <x-latest-blogs />
                <x-category-blogs />
                <x-youtube />
            </x-flex-two>
        </x-layouts-blogs>
    </div>
@endsection
