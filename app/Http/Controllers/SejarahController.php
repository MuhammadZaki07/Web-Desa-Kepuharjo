<?php

namespace App\Http\Controllers;

use App\Helpers\TimeHelper;
use App\Models\Banner;
use App\Models\ProfileDesa;
use App\Services\ArticleService;

class SejarahController extends Controller
{
    public function index()
    {
        $timeData = TimeHelper::getFormattedTime();
        $tanggal = $timeData['tanggal'];
        $jam = $timeData['jam'];
        $format = $timeData['format'];

        $headlines = ArticleService::getHeadlines();
        $blogs = ArticleService::getLatestPublishedBlogs();

        $ProfileDesa = ProfileDesa::first();
        $sejarah = $ProfileDesa->sejarah_desa ?? 'Tidak ada sejarah tersedia';

        $menus = Banner::where('type', 'sejarah')
            ->select('title', 'images')
            ->get()
            ->map(function ($banner) {
                return [
                    'title' => $banner->title,
                    'image' => $banner->image,
                ];
            })
            ->toArray();

        $dummyMenus = [
            ['title' => 'judul Banner 1', 'image' => 'assets/banners/preview_sejarah.png'],
            ['title' => 'judul Banner 2', 'image' => 'assets/banners/preview_sejarah.png'],
            ['title' => 'judul Banner 3', 'image' => 'assets/banners/preview_sejarah.png'],
            ['title' => 'judul Banner 4', 'image' => 'assets/banners/preview_sejarah.png'],
            ['title' => 'judul Banner 5', 'image' => 'assets/banners/preview_sejarah.png'],
        ];

        $menus = count($menus) >= 5 ? $menus : $dummyMenus;

        $title = 'Sejarah';

        return view('pages.sejarah', compact(
            'tanggal',
            'jam',
            'format',
            'headlines',
            'blogs',
            'sejarah',
            'menus',
            'title'
        ));
    }
}
