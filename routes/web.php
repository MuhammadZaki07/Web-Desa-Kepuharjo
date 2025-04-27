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
        'blogs' => $blogs
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
        'blogs' => $blogs
    ]);
});
