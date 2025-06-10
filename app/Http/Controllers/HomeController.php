<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Article;
use App\Models\Penduduk;
use App\Models\PengurusDesa;
use App\Models\ProfileDesa;
use App\Models\User;
use Str;

class HomeController extends Controller
{

    public function index()
    {
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $banner = Banner::where('type', 'beranda')->first();
        $now = Carbon::now();
        $tanggal = $now->translatedFormat('D, d F Y');
        $jam = $now->format('H:i:s');
        $format = $now->format('A');
        $headlines = Article::latest()->take(5)->pluck('title');
        $articles = Article::latest()->take(3)->get();
        $blogs = $articles->map(function ($article) {
            return [
                'title' => $article->title,
                'image' => $article->featured_image,
                'url' => route('artikel.show', $article->slug),
                'time' => Carbon::parse($article->created_at)->diffForHumans(),
            ];
        });
        $ProfileDesa = ProfileDesa::first();
        $kepalaDesa = PengurusDesa::where('jabatan', 'kepala_desa')->first();
        $laki = Penduduk::where('jenis_kelamin', 'L')->count();
        $perempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $total = $laki + $perempuan;

        $dataPenduduk = [
            [
                'jumlah' => $laki,
                'label' => 'Kelamin Laki-Laki',
                'warna' => 'green',
                'icon' => 'bi-gender-male',
            ],
            [
                'jumlah' => $perempuan,
                'label' => 'Kelamin Perempuan',
                'warna' => 'red',
                'icon' => 'bi-gender-female',
            ],
            [
                'jumlah' => $total,
                'label' => 'Total Penduduk Desa',
                'warna' => 'blue',
                'icon' => 'bi-gender-ambiguous',
            ],
        ];

        return view('index', [
            'banner' => $banner,
            'kepalaDesa' => $kepalaDesa->user->name,
            'blogs' => $blogs,
            'ProfileDesa' => $ProfileDesa,
            'dataPenduduk' => $dataPenduduk,
            'tanggal' => $tanggal,
            'visi' => $ProfileDesa->visi,
            'misi' => $ProfileDesa->misi,
            'sejarah' => \Illuminate\Support\Str::limit($ProfileDesa->sejarah_desa, 200),
            'jam' => $jam,
            'tlp_desa' => $ProfileDesa->no_tlp,
            'email_desa' => $ProfileDesa->email,
            'alamat_desa' => $ProfileDesa->alamat_kantor,
            'format' => $format,
            'headline' => $headlines,
            'title' => 'Beranda',
        ]);
    }
}
