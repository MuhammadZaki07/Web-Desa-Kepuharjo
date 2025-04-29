@extends('layouts.app')

@section('content')
    <section class="lg:px-20 px-5 py-3">
        <div class="hidden lg:block">
            <x-running-blog :blogs="$blogs" />
            <x-banner-sejarah />
        </div>
        <div class="flex flex-col lg:flex-row gap-5 lg:gap-15 items-start">
            <div class="flex-1 lg:flex-7">
                <x-content>
                    <div class="overflow-hidden rounded-xl w-full">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTuzbpvCM-BxrE97T4p2EALEtG3UBsy3WcOfA&s"
                            alt="Kantor Desa Kepuharjo" class="w-full h-[350px] object-cover">
                    </div>
                    <div class="flex flex-col gap-3 py-5">
                        <h1 class="font-bold text-4xl text-gray-800">Sejarah Desa Kepuharjo</h1>
                        <h2 class="text-sm text-slate-500 font-medium">
                            Oleh <span class="font-semibold text-green-600">Eurico Darline</span> | 21 Agustus 2018
                        </h2>
                    </div>

                    <div id="content" class="space-y-8 text-gray-800">
                        <p class="text-lg leading-relaxed text-gray-600">
                            Desa Kepuharjo terletak di Kecamatan Karangploso, Kabupaten Malang, Jawa Timur. Nama "Kepuharjo"
                            berasal dari dua kata: "Kepuh" yang berarti pohon kepuh dan "Arjo" yang berarti ramai. Desa ini
                            dikenal sebagai jalur utama menuju Kota Batu dari arah Surabaya, serta memiliki sejarah dan
                            budaya yang kaya.
                        </p>

                        <section>
                            <h3 class="text-2xl font-semibold text-green-600">Asal Usul Nama dan Sejarah Awal</h3>
                            <p class="text-base leading-relaxed">
                                Menurut cerita rakyat, nama Desa Kepuharjo berasal dari perjalanan Kebo Ijo, seorang tokoh
                                legendaris, yang melintasi wilayah ini. Dalam perjalanannya, Kebo Ijo menemukan pohon besar
                                bernama "Ploso" yang kemudian menjadi nama wilayah tersebut, yaitu Karangploso. Selanjutnya,
                                Kebo Ijo melanjutkan perjalanan ke timur dan menemukan rumpun bambu ampel, yang dikenal
                                sebagai "Ampel", yang kini menjadi nama Desa Ampeldento. Perjalanan Kebo Ijo berakhir di
                                wilayah yang dikenal sebagai "Kasin" dan "Tlasih", yang masing-masing memiliki cerita dan
                                makna tersendiri dalam sejarah lokal.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-2xl font-semibold text-green-600">Perkembangan Desa Kepuharjo</h3>
                            <p class="text-base leading-relaxed">
                                Seiring berjalannya waktu, Desa Kepuharjo berkembang pesat. Desa ini memiliki enam dusun:
                                Wringin Anom (Langgat), Kepuh Utara, Kepuh Selatan, Karangploso Wetan, Turi, dan Tlasih.
                                Mayoritas penduduk desa ini bekerja sebagai petani dan pedagang, sementara sebagian lainnya,
                                terutama pemuda, bekerja sebagai karyawan swasta atau buruh pabrik. Desa Kepuharjo juga
                                dikenal sebagai jalur utama memasuki Kota Batu dari arah Surabaya.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-2xl font-semibold text-green-600">Infrastruktur dan Fasilitas Desa</h3>
                            <p class="text-base leading-relaxed">
                                Desa Kepuharjo memiliki berbagai fasilitas penting, antara lain Balai Pengkajian Teknologi
                                Pertanian Jawa Timur (BPTP JATIM) dan Balai Pengujian Standar Instrumen Tanaman Pemanis dan
                                Serat (BSIP), yang merupakan balai penelitian nasional di bawah Badan Penelitian dan
                                Pengembangan Pertanian. Keberadaan fasilitas ini menunjukkan komitmen desa dalam mendukung
                                sektor pertanian dan penelitian ilmiah.
                            </p>
                        </section>

                        <section>
                            <h3 class="text-2xl font-semibold text-green-600">Peran Tokoh Masyarakat dalam Pembangunan</h3>
                            <p class="text-base leading-relaxed">
                                Pembangunan di Desa Kepuharjo tidak hanya melibatkan pemerintah desa, tetapi juga
                                partisipasi aktif dari tokoh masyarakat. Tokoh masyarakat berperan dalam berbagai aspek
                                pembangunan, seperti pemikiran, tenaga, keahlian, dan dana. Peran serta mereka sangat
                                penting dalam mewujudkan kemajuan desa dan meningkatkan kualitas hidup masyarakat.
                            </p>
                        </section>
                    </div>
                </x-content>
                <x-comment />
            </div>
            <div class="flex-1 lg:flex-2 flex flex-col gap-5">
                <x-youtube />
                <x-latest-blogs />
                <x-suara-pembaca />
            </div>
        </div>
    </section>
@endsection
