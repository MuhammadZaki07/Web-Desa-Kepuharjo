<?php

use Illuminate\Support\Facades\Route;

Route::get('/auth', function () {
    return view('auth.auth');
});
Route::get('/', function () {
    $blogs = [
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
    ];

    return view('index', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'blogs' => $blogs,
        'title' => 'Beranda'
    ]);
});
Route::get('/profile-data-penduduk', function () {
    $blogs = [
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
    ];
    return view('pages.profile-data-penduduk', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'blogs' => $blogs,
        'title' => 'Profile Data Penduduk'
    ]);
});
Route::get('/sejarah', function () {
    $blogs = [
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
    ];
    return view('pages.sejarah', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'blogs' => $blogs,
        'title' => 'Sejarah'
    ]);
});
Route::get('/visi-misi', function () {
    $blogs = [
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
    ];
    return view('pages.VisiMisi', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'blogs' => $blogs,
        'title' => 'Visi Misi'
    ]);
});
Route::get('/gallery', function () {
    return view('pages.gallery', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'Gallery'
    ]);
});
Route::get('/pemerintahan', function () {
    return view('pages.pemerintahan', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'Pemerintahan'
    ]);
});
Route::get('/berita', function () {
    $blogs = [
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
        [
            'title' => 'Segini Besaran Biaya UKT di Universitas Brawijaya Untuk Jalur SNBT Dan Mandiri',
            'image' => asset('assets/images/foto_brawijaya.png'),
            'url' => "/",
            'time' => '3 Hari Yang Lalu'
        ],
    ];
    return view('pages.berita', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'blogs' => $blogs,
        'title' => 'Berita'
    ]);
});
Route::get('/umkm', function () {

    return view('pages.umkm', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'UMKM'
    ]);
});
Route::get('/karang-taruna', function () {
    return view('pages.karangtaruna', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'Karang-Taruna'
    ]);
});
Route::get('/pkk', function () {
    return view('pages.pkk', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'PKK'
    ]);
});
Route::get('/detail-umkm', function () {
    return view('pages.DetailUmkm', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'PKK'
    ]);
});

