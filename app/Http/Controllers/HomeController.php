<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Article;
use App\Models\ProfileDesa;
use App\Models\User;

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
                'image' => $article->image,
                'url' => route('artikel.show', $article->slug),
                'time' => Carbon::parse($article->created_at)->diffForHumans(),
            ];
        });
        $ProfileDesa = ProfileDesa::first();
        $kepalaDesa = User::where('jabatan', 'kepala_desa')->first();


        return view('index', [
            'banner' => $banner,
            'kepalaDesa' => $kepalaDesa->name,
            'blogs' => $blogs,
            'ProfileDesa' => $ProfileDesa,
            'tanggal' => $tanggal,
            'jam' => $jam,
            'format' => $format,
            'headline' => $headlines,
            'title' => 'Beranda',
        ]);
    }
}
