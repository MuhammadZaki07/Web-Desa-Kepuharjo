<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Article;
use App\Models\Penduduk;
use App\Models\PengurusDesa;

class HomeController extends Controller
{
    public function index()
    {
        $viralBlogs = cache()->remember('viral_blogs_home', 600, function () {
            return Article::query()
                ->select('id', 'title', 'slug', 'featured_image', 'created_at', 'category_id', 'viewers', 'updated_at', 'published_at')
                ->where('status', 'published')
                ->whereHas('category', fn($q) => $q->where('type', 'blogs'))
                ->with(['category:id,name,slug,color'])
                ->orderByDesc('viewers')
                ->limit(5)
                ->get();
        });

        if ($viralBlogs->count() < 4) {
            $viralBlogs = collect();
        }

        $banner = cache()->remember('banner_beranda', 1800, function () {
            return Banner::where('type', 'beranda')->first();
        }) ?? null;

        $kepalaDesa = cache()->remember('kepala_desa', 3600, function () {
            return PengurusDesa::where('jabatan', 'kepala_desa')
                ->with(['user:id,name,email,photo'])
                ->first();
        }) ?? null;

        $dataPenduduk = cache()->remember('data_penduduk', 1800, function () {
            $laki = Penduduk::where('jenis_kelamin', 'L')->count() ?? 0;
            $perempuan = Penduduk::where('jenis_kelamin', 'P')->count() ?? 0;
            $total = $laki + $perempuan;

            return [
                ['jumlah' => $laki, 'label' => 'Kelamin Laki-Laki', 'warna' => 'green', 'icon' => 'bi-gender-male'],
                ['jumlah' => $perempuan, 'label' => 'Kelamin Perempuan', 'warna' => 'red', 'icon' => 'bi-gender-female'],
                ['jumlah' => $total, 'label' => 'Total Penduduk Desa', 'warna' => 'blue', 'icon' => 'bi-gender-ambiguous'],
            ];
        });

        $visi = $ProfileDesa->visi ?? 'no data';
        $misi = $ProfileDesa->misi ?? ['no data'];
        $sejarah = \Illuminate\Support\Str::limit($ProfileDesa->sejarah_desa ?? 'no data', 200);
        $title = 'Beranda';

        return view('index', compact(
            'banner',
            'kepalaDesa',
            'viralBlogs',
            'dataPenduduk',
            'visi',
            'misi',
            'title'
        ));
    }
}
