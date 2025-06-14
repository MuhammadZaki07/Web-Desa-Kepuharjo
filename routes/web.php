<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\ProfileDataPendudukController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\VisiMisiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/auth', [CustomLoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [CustomLoginController::class, 'login'])->name('custom.login')->middleware('throttle:5,1');
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('addpengajuan');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/profile-data-penduduk', [ProfileDataPendudukController::class, 'index'])->name('profile-data-penduduk');
Route::get('/visi-misi', [VisiMisiController::class, 'index'])->name('visi-misi');
Route::get('/sejarah', [SejarahController::class, 'index'])->name('sejarah');
Route::get('/pkk', [OrganizationsController::class,'index']);

Route::get('/gallery', function () {
    return view('pages.gallery', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headlines' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'Gallery'
    ]);
});
Route::get('/pemerintahan', function () {
    return view('pages.pemerintahan', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headlines' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
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
        'headlines' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'blogs' => $blogs,
        'title' => 'Berita'
    ]);
});
Route::get('/umkm', function () {

    return view('pages.umkm', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headlines' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'UMKM'
    ]);
});
Route::get('/karang-taruna', function () {
    return view('pages.karangtaruna', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headlines' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'Karang-Taruna'
    ]);
});
Route::get('/wisata', function () {
    return view('pages.wisata', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headlines' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'PKK'
    ]);
});
Route::get('/wisata/detail-wisata', function () {
    return view('pages.DetailWIsata', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headlines' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'PKK'
    ]);
});
Route::get('/detail-umkm', function () {
    return view('pages.DetailUmkm', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headlines' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'PKK'
    ]);
});
Route::get('/detail-blog/{slug}', function () {
    return view('pages.DetailBerita', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headlines' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.',
        'title' => 'Detail Blogs'
    ]);
})->name('detail-blog');
