<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileDataPendudukController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\PemerintahController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PrestasiDesaController;
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\WisataController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/auth', [CustomLoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [CustomLoginController::class, 'login'])->name('custom.login')->middleware('throttle:5,1');
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('addpengajuan');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/profile-data-penduduk', [ProfileDataPendudukController::class, 'index'])->name('profile-data-penduduk');
Route::get('/visi-misi', [VisiMisiController::class, 'index'])->name('visi-misi');
Route::get('/sejarah', [SejarahController::class, 'index'])->name('sejarah');
Route::get('/pkk', [OrganizationsController::class, 'index'])->name('pkk.page');
Route::get('/karang-taruna', [OrganizationsController::class, 'halamanKarangtaruna'])->name('karangtaruna.page');
Route::get('/berita', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/berita/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/pemerintahan', [PemerintahController::class, 'index'])->name('pemerintahan.page');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{gallery}/download', [GalleryController::class, 'download'])->name('gallery.download');
Route::get('/umkm', [UmkmController::class,'index'])->name('umkm.page');
Route::get('/umkm/{slug}', [UmkmController::class, 'show'])->name('umkm.show');
Route::get('/wisata', [WisataController::class,'index'])->name('wisata.page');
Route::get('/wisata/{slug}/detail-wisata', [WisataController::class,'show'])->name('wisata.show');

