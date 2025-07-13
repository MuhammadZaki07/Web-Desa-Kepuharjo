<?php

namespace App\Http\Controllers;

use App\Helpers\ProfileDesa as HelpersProfileDesa;
use App\Helpers\TimeHelper;
use App\Models\Banner;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Article;
use App\Models\Penduduk;
use App\Models\PengurusDesa;
use App\Models\ProfileDesa;
use App\Models\User;
use App\Services\ArticleService;
use Str;

class HomeController extends Controller
{

    public function index()
    {
        $timeData = TimeHelper::getFormattedTime();
        $tanggal = $timeData['tanggal'] ?? 'no data';
        $jam = $timeData['jam'] ?? 'no data';
        $format = $timeData['format'] ?? 'no data';

        $banner = Banner::where('type', 'beranda')->first() ?? null;

        $headlines = ArticleService::getHeadlines() ?? [];
        $blogs = ArticleService::getViralBlogs() ?? [];

        $viralBlogs = Article::query()
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('type', 'blogs'))
            ->with('category')
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        if ($viralBlogs->count() < 4) {
            $viralBlogs = collect();
        }

        $ProfileDesa = HelpersProfileDesa::GetProfileDesa() ?? null;
        $kepalaDesa = PengurusDesa::where('jabatan', 'kepala_desa')->with('user')->first() ?? null;

        $laki = Penduduk::where('jenis_kelamin', 'L')->count() ?? 0;
        $perempuan = Penduduk::where('jenis_kelamin', 'P')->count() ?? 0;
        $total = $laki + $perempuan;

        $dataPenduduk = [
            ['jumlah' => $laki, 'label' => 'Kelamin Laki-Laki', 'warna' => 'green', 'icon' => 'bi-gender-male'],
            ['jumlah' => $perempuan, 'label' => 'Kelamin Perempuan', 'warna' => 'red', 'icon' => 'bi-gender-female'],
            ['jumlah' => $total, 'label' => 'Total Penduduk Desa', 'warna' => 'blue', 'icon' => 'bi-gender-ambiguous'],
        ];

        $visi = $ProfileDesa->visi ?? 'no data';
        $misi = $ProfileDesa->misi ?? ['no data'];
        $sejarah = \Illuminate\Support\Str::limit($ProfileDesa->sejarah_desa ?? 'no data', 200);
        $title = 'Beranda';

        return view('index', compact(
            'banner',
            'kepalaDesa',
            'blogs',
            'viralBlogs',
            'ProfileDesa',
            'dataPenduduk',
            'tanggal',
            'jam',
            'format',
            'headlines',
            'visi',
            'misi',
            'title'
        ));
    }


    // public function index()
    // {
    //     $timeData = TimeHelper::getFormattedTime();
    //     $tanggal = $timeData['tanggal'];
    //     $jam = $timeData['jam'];
    //     $format = $timeData['format'];

    //     $banner = Banner::where('type', 'beranda')->first();
    //     $headlines = ArticleService::getHeadlines();
    //     $blogs = ArticleService::getViralBlogs();
    //     $viralBlogs = Article::query()
    //         ->where('status', 'published')
    //         ->whereHas('category', function ($q) {
    //             $q->where('type', 'blogs');
    //         })
    //         ->with('category')
    //         ->orderByDesc('published_at')
    //         ->limit(5)
    //         ->get();

    //     if ($viralBlogs->count() < 4) {
    //         $viralBlogs = collect();
    //     }

    //     $ProfileDesa = HelpersProfileDesa::GetProfileDesa();
    //     $kepalaDesa = PengurusDesa::where('jabatan', 'kepala_desa')->with('user')->first();

    //     $laki = Penduduk::where('jenis_kelamin', 'L')->count();
    //     $perempuan = Penduduk::where('jenis_kelamin', 'P')->count();
    //     $total = $laki + $perempuan;

    //     $dataPenduduk = [
    //         ['jumlah' => $laki, 'label' => 'Kelamin Laki-Laki', 'warna' => 'green', 'icon' => 'bi-gender-male'],
    //         ['jumlah' => $perempuan, 'label' => 'Kelamin Perempuan', 'warna' => 'red', 'icon' => 'bi-gender-female'],
    //         ['jumlah' => $total, 'label' => 'Total Penduduk Desa', 'warna' => 'blue', 'icon' => 'bi-gender-ambiguous'],
    //     ];

    //     $visi = $ProfileDesa->visi ?? [];
    //     $misi = $ProfileDesa->misi ?? [];
    //     $sejarah = \Illuminate\Support\Str::limit($ProfileDesa->sejarah_desa ?? "", 200);
    //     $title = 'Beranda';

    //     return view('index', compact(
    //         'banner',
    //         'kepalaDesa',
    //         'blogs',
    //         'viralBlogs',
    //         'ProfileDesa',
    //         'dataPenduduk',
    //         'tanggal',
    //         'jam',
    //         'format',
    //         'headlines',
    //         'visi',
    //         'misi',
    //         'title'
    //     ));
    // }
}
