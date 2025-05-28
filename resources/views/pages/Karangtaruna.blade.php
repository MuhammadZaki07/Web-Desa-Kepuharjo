@extends('layouts.app')
@section('content')
    <x-banner-pemerintahan>
        <section class="w-full h-[500px] relative bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('assets/banners/pemerintahan/karangtaruna.jpeg') }}')">
            <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-r from-black to-transparent"></div>
            <div
                class="absolute flex justify-start flex-col gap-4 lg:w-4/5 lg:left-15 left-0 top-1/4 sm:top-40 lg:px-4 px-8">
                <h1 class="font-bold text-white lg:text-6xl text-5xl lg:text-left text-center uppercase">karangtaruna</h1>
                <p class="lg:text-left text-center lg:text-lg text-sm text-white font-normal lg:w-2/3">
                    Informasi seputar program kerja, kegiatan kepemudaan, dan peran aktif Karang Taruna Desa Kepuharjo.
                    Bersama membangun generasi muda yang kreatif, tangguh, dan peduli sosial melalui kolaborasi, inovasi,
                    dan semangat kebersamaan.
                </p>
            </div>
        </section>
    </x-banner-pemerintahan>
    <div class="px-5 lg:px-20 lg:py-10 py-5">
        <x-layouts-blogs>
            <x-flex-one>
                <x-content>
                    <!-- Judul dan Tanggal -->
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Karang Taruna Desa Kepuharjo</h1>
                    <p class="text-sm text-gray-500 mb-6">Terakhir diperbarui: 4 Mei 2025</p>

                    <!-- Deskripsi -->
                    <div class="text-gray-700 space-y-5 mb-8 leading-relaxed">
                        <p>
                            Karang Taruna Desa Kepuharjo adalah organisasi kepemudaan yang menjadi garda terdepan dalam mendorong transformasi sosial di tingkat desa.
                            Lahir dari semangat kolektif pemuda desa, Karang Taruna hadir sebagai ruang aktualisasi diri, pemberdayaan, dan inovasi sosial berbasis gotong royong.
                        </p>
                        <p>
                            Fokus utamanya mencakup pembangunan karakter, pengembangan potensi generasi muda, serta peningkatan kesejahteraan sosial masyarakat melalui kegiatan
                            edukatif, kreatif, dan kolaboratif. Karang Taruna menjadi jembatan antara semangat muda dan kebutuhan nyata masyarakat, menjawab tantangan zaman tanpa meninggalkan nilai-nilai kearifan lokal.
                        </p>
                        <p>
                            Dalam praktiknya, organisasi ini aktif menjalankan program wirausaha, pelatihan digital, kampanye sosial, hingga festival budaya, menjalin kemitraan strategis
                            dengan pemerintah desa, lembaga pendidikan, dan komunitas lokal lainnya demi menciptakan desa yang dinamis, inklusif, dan berdaya saing.
                        </p>
                    </div>

                    <!-- Struktur Organisasi -->
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Struktur Organisasi</h2>
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full text-left text-sm border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="py-3 px-4 border-b">Jabatan</th>
                                    <th class="py-3 px-4 border-b">Nama</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800">
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="py-3 px-4 border-b">Ketua</td>
                                    <td class="py-3 px-4 border-b">Adi Nugroho</td>
                                </tr>
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="py-3 px-4 border-b">Wakil Ketua</td>
                                    <td class="py-3 px-4 border-b">Rizky Ramadhan</td>
                                </tr>
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="py-3 px-4 border-b">Sekretaris</td>
                                    <td class="py-3 px-4 border-b">Dinda Saraswati</td>
                                </tr>
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="py-3 px-4 border-b">Bendahara</td>
                                    <td class="py-3 px-4 border-b">Yulia Puspita</td>
                                </tr>
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="py-3 px-4 border-b">Koordinator Sosial</td>
                                    <td class="py-3 px-4 border-b">Ilham Setiawan</td>
                                </tr>
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="py-3 px-4 border-b">Koordinator Olahraga</td>
                                    <td class="py-3 px-4 border-b">Fajar Maulana</td>
                                </tr>
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="py-3 px-4 border-b">Koordinator Ekonomi Kreatif</td>
                                    <td class="py-3 px-4 border-b">Sari Melati</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Program Unggulan -->
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Program Kerja Unggulan</h2>
                    <ul class="list-disc pl-6 text-gray-700 space-y-2 mb-8">
                        <li>Pembinaan kewirausahaan dan UMKM berbasis digital</li>
                        <li>Festival Olahraga Pemuda antar dusun</li>
                        <li>Aksi sosial: donor darah, bantuan bencana, bakti desa</li>
                        <li>Pelatihan teknologi digital & literasi keuangan</li>
                        <li>Penyuluhan anti-narkoba dan kesehatan remaja</li>
                        <li>Pentas seni dan pelestarian budaya lokal</li>
                    </ul>

                    <!-- Kegiatan Rutin -->
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Agenda Rutin</h2>
                    <ul class="list-disc pl-6 text-gray-700 space-y-2 mb-8">
                        <li>Rapat koordinasi bulanan pengurus Karang Taruna</li>
                        <li>Pelayanan sosial bagi lansia dan keluarga prasejahtera</li>
                        <li>Pelatihan soft skill (komunikasi, kepemimpinan, teamwork)</li>
                        <li>Program Jum’at Bersih & gerakan penghijauan desa</li>
                        <li>Festival Pemuda Desa setiap akhir tahun</li>
                    </ul>

                    <!-- Kontak -->
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Hubungi Kami</h2>
                    <p class="text-gray-700">
                        Untuk informasi lebih lanjut mengenai kegiatan dan kolaborasi dengan Karang Taruna Desa Kepuharjo,
                        silakan kunjungi <span class="font-medium text-gray-800">sekretariat di Balai Desa Kepuharjo</span>
                        atau hubungi kami melalui WhatsApp di
                        <a href="https://wa.me/6282112345678" class="text-blue-600 font-medium hover:underline">0821-1234-5678</a>.
                    </p>
                </x-content>
                <div class="w-full pt-10">
                    <div class="flex flex-col gap-4">
                        <h1 class="text-5xl font-bold text-green-600">Gallery <span class="text-black">karangtaruna</span>
                        </h1>
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
