@extends('layouts.app')

@section('content')
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="rounded-xl overflow-hidden">
            <div class="relative">
                <span
                    class="absolute top-4 left-4 bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full z-10">Produk
                    Terbaik</span>
                <div class="">
                    <div class="relative h-96 bg-gray-100">
                        <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" alt="Beras Organik"
                            class="w-full h-full object-cover rounded-xl">
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="flex items-center mb-3">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1.5 rounded">Pertanian</span>
                </div>

                <div class="flex justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-2">Beras Organik Premium Hasil Panen Desa Sejahtera
                        </h1>

                        <div class="flex items-center text-gray-500 text-sm mb-4">
                            <i class="bi bi-geo-alt mr-1"></i>
                            <span>Desa Sejahtera, Kecamatan Makmur, Kabupaten Bahagia</span>
                        </div>
                    </div>
                    <div class="">
                        <button class="bg-green-400 rounded px-4 py-2 text-white cursor-pointer hover:bg-green-600"><i
                                class="bi bi-whatsapp"></i> Hubungi Penjual</button>
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
                                kualitas dalam konsumsi
                                sehari-hari. Dihasilkan oleh petani lokal dari <strong>Desa Sejahtera</strong>, produk ini
                                menawarkan
                                kesegaran alami tanpa bahan kimia sintetis.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-lg font-medium">🌿 Keunggulan Produk</h3>
                            <ul class="list-disc list-inside space-y-2">
                                <li>
                                    <strong>Ditanam secara organik:</strong> Beras ini tumbuh dengan metode pertanian ramah
                                    lingkungan <em>tanpa
                                        pestisida kimia</em>, menjaga kesuburan tanah dan ekosistem alami.
                                </li>
                                <li>
                                    <strong>Kualitas butir terbaik:</strong> Dipilih dari hasil panen terbaik dengan
                                    <em>butiran beras yang utuh</em>,
                                    bersih, dan memiliki <em>aroma khas alami</em> yang harum.
                                </li>
                                <li>
                                    <strong>Sertifikasi Organik Nasional:</strong> Telah <em>tersertifikasi secara
                                        resmi</em> oleh lembaga terkait,
                                    menjamin bahwa proses produksi memenuhi standar organik nasional.
                                </li>
                                <li>
                                    <strong>Kemasan Vakum Modern:</strong> Dikemas dengan <em>teknologi vakum</em> untuk
                                    menjaga kualitas dan
                                    kesegaran beras agar lebih tahan lama serta higienis saat sampai ke tangan konsumen.
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
@endsection
