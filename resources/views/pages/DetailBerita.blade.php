@extends('layouts.app')

@section('title', 'Teknologi AI Terbaru Mengubah Industri Healthcare')

@section('content')
    @php
        // Data dummy artikel berdasarkan struktur database
        $article = (object) [
            'id' => 1,
            'title' => 'Teknologi AI Terbaru Mengubah Industri Healthcare di Indonesia',
            'slug' => 'teknologi-ai-terbaru-mengubah-industri-healthcare',
            'excerpt' =>
                'Perkembangan kecerdasan buatan dalam bidang kesehatan membawa revolusi besar dalam diagnosis dan pengobatan pasien di seluruh Indonesia.',
            'content' => '<p>Industri healthcare di Indonesia sedang mengalami transformasi besar-besaran dengan hadirnya teknologi Artificial Intelligence (AI) yang semakin canggih. Berbagai rumah sakit dan klinik di tanah air mulai mengadopsi solusi berbasis AI untuk meningkatkan kualitas pelayanan kesehatan.</p>

<p>Dr. Ahmad Syahrir, direktur teknologi kesehatan di RS Cipto Mangunkusumo, menjelaskan bahwa implementasi AI telah membantu tim medis dalam mendiagnosis penyakit dengan tingkat akurasi yang lebih tinggi. "Dengan bantuan machine learning, kami dapat mendeteksi kanker payudara 30% lebih cepat dibandingkan metode konvensional," ungkapnya.</p>

<h3>Implementasi AI di Berbagai Bidang Kesehatan</h3>

<p>Teknologi AI kini telah diimplementasikan dalam berbagai aspek pelayanan kesehatan, mulai dari:</p>

<ul>
<li><strong>Radiologi:</strong> Analisis hasil CT scan dan MRI dengan presisi tinggi</li>
<li><strong>Kardiologi:</strong> Deteksi dini penyakit jantung melalui analisis EKG</li>
<li><strong>Patologi:</strong> Identifikasi sel kanker dalam sampel jaringan</li>
<li><strong>Farmasi:</strong> Pengembangan obat baru dengan simulasi molekuler</li>
</ul>

<p>Menurut data Kementerian Kesehatan, penggunaan teknologi AI di sektor kesehatan Indonesia mengalami peningkatan sebesar 45% dalam dua tahun terakhir. Hal ini menunjukkan antusiasme tinggi dari para praktisi medis untuk mengadopsi inovasi teknologi.</p>

<h3>Tantangan dan Peluang ke Depan</h3>

<p>Meskipun memberikan banyak manfaat, implementasi AI dalam healthcare juga menghadapi berbagai tantangan. Isu privasi data pasien, biaya implementasi yang tinggi, dan kebutuhan pelatihan SDM menjadi perhatian utama.</p>

<p>Namun, peluang pengembangan AI healthcare di Indonesia sangat besar. Dengan populasi lebih dari 270 juta jiwa, Indonesia memiliki potensi data kesehatan yang massive untuk melatih algoritma AI yang lebih akurat dan sesuai dengan karakteristik masyarakat Indonesia.</p>

<blockquote class="border-l-4 border-blue-500 pl-4 italic text-gray-600 my-6">
"AI bukan untuk menggantikan dokter, tetapi untuk membantu dokter membuat keputusan yang lebih baik dan cepat dalam menangani pasien." - Prof. Dr. Siti Nadia Tarmizi, Direktur Jenderal Pencegahan dan Pengendalian Penyakit Kemenkes RI
</blockquote>

<p>Ke depannya, diharapkan kolaborasi antara pemerintah, industri teknologi, dan institusi kesehatan dapat mempercepat adopsi AI healthcare untuk meningkatkan kualitas kesehatan masyarakat Indonesia secara menyeluruh.</p>',
            'featured_image' => 'assets/news/ai-healthcare.jpg',
            'category_id' => 2,
            'user_id' => 1,
            'viewers' => 1250,
            'status' => 'published',
            'published_at' => '2024-06-01 10:30:00',
            'created_at' => '2024-06-01 09:15:00',
            'updated_at' => '2024-06-01 10:30:00',
        ];

        // Data dummy kategori
        $category = (object) [
            'id' => 2,
            'name' => 'Teknologi',
            'slug' => 'teknologi',
            'color' => 'bg-blue-500',
        ];

        // Data dummy penulis
        $author = (object) [
            'id' => 1,
            'name' => 'Dr. Rizki Pratama',
            'avatar' => 'assets/authors/author-1.jpg',
            'bio' => 'Ahli teknologi kesehatan dengan pengalaman 10 tahun di bidang AI dan machine learning',
        ];

        // Data dummy artikel terkait
        $relatedArticles = [
            (object) [
                'id' => 2,
                'title' => 'Machine Learning dalam Diagnosis Medis',
                'slug' => 'machine-learning-diagnosis-medis',
                'excerpt' =>
                    'Bagaimana teknologi machine learning membantu dokter dalam mendiagnosis penyakit dengan lebih akurat.',
                'featured_image' => 'assets/news/ml-medical.jpg',
                'published_at' => '2024-05-28 14:20:00',
                'viewers' => 890,
            ],
            (object) [
                'id' => 3,
                'title' => 'Telemedicine Era Digital Healthcare',
                'slug' => 'telemedicine-era-digital-healthcare',
                'excerpt' =>
                    'Perkembangan telemedicine di Indonesia dan dampaknya terhadap aksesibilitas layanan kesehatan.',
                'featured_image' => 'assets/news/telemedicine.jpg',
                'published_at' => '2024-05-25 09:45:00',
                'viewers' => 675,
            ],
            (object) [
                'id' => 4,
                'title' => 'Robotika dalam Operasi Bedah Modern',
                'slug' => 'robotika-operasi-bedah-modern',
                'excerpt' => 'Teknologi robotika menghadirkan presisi tinggi dalam prosedur operasi bedah.',
                'featured_image' => 'assets/news/robotic-surgery.jpg',
                'published_at' => '2024-05-22 16:10:00',
                'viewers' => 1120,
            ],
        ];

        // Data dummy artikel terbaru untuk sidebar
        $latestArticles = [
            (object) [
                'title' => '5 Tren Teknologi 2024 yang Wajib Diketahui',
                'slug' => '5-tren-teknologi-2024',
                'featured_image' => 'assets/news/tech-trends.jpg',
                'published_at' => '2024-06-05 10:00:00',
            ],
            (object) [
                'title' => 'Panduan Lengkap Digital Marketing untuk UMKM',
                'slug' => 'panduan-digital-marketing-umkm',
                'featured_image' => 'assets/news/digital-marketing.jpg',
                'published_at' => '2024-06-04 15:30:00',
            ],
            (object) [
                'title' => 'Revolusi Pendidikan dengan E-Learning',
                'slug' => 'revolusi-pendidikan-e-learning',
                'featured_image' => 'assets/news/e-learning.jpg',
                'published_at' => '2024-06-03 11:20:00',
            ],
        ];
    @endphp

    <div class="lg:px-20 px-5">
        <div class="lg:py-16 py-10 flex flex-col lg:flex-row gap-10 items-start">
            <!-- Main Content -->
            <div class="flex-1 lg:flex-[3]">
                <article class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Featured Image -->
                    <div class="relative">
                        <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}"
                            class="w-full h-64 lg:h-96 object-cover">

                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="{{ $category->color }} text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ $category->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Article Content -->
                    <div class="p-6 lg:p-8">
                        <!-- Article Meta -->
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($article->published_at)->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ number_format($article->viewers) }} views</span>
                            </div>
                        </div>

                        <!-- Article Title -->
                        <h1 class="text-2xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                            {{ $article->title }}
                        </h1>

                        <!-- Article Excerpt -->
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                            {{ $article->excerpt }}
                        </p>

                        <!-- Article Content -->
                        <div class="prose prose-lg max-w-none">
                            {!! $article->content !!}
                        </div>

                        <!-- Article Footer -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <!-- Share Buttons -->
                            <div class="flex items-center gap-4">
                                <span class="text-gray-600 font-medium">Bagikan:</span>
                                <div class="flex gap-2">
                                    <a href="#"
                                        class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M18.77 7.46H15.5v-1.9c0-.9.6-1.1 1-1.1h2.2V.5h-3.4C13.2.5 11.5 2.4 11.5 5v2.46H9.5v3.6h2v10.94h3.5V11.06h2.6l.77-3.6Z" />
                                        </svg>
                                    </a>
                                    <a href="#"
                                        class="bg-sky-500 text-white p-2 rounded-full hover:bg-sky-600 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z" />
                                        </svg>
                                    </a>
                                    <a href="#"
                                        class="bg-green-600 text-white p-2 rounded-full hover:bg-green-700 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.520-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.570-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Author Bio -->
                        <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                            <div class="flex items-start gap-4">
                                <img src="{{ asset($author->avatar) }}" alt="{{ $author->name }}"
                                    class="w-16 h-16 rounded-full object-cover">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900">{{ $author->name }}</h3>
                                    <p class="text-gray-600 mt-1">{{ $author->bio }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="mt-5">
                    <x-comment />
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/4 w-full flex flex-col gap-6 mt-10 lg:mt-0">
                <x-latest-blogs />
                <x-category-blogs />
            </div>
        </div>
    </div>
@endsection
