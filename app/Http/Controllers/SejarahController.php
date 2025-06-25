<?php

namespace App\Http\Controllers;

use App\Helpers\ProfileDesa;
use App\Helpers\TimeHelper;
use App\Models\Banner;

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
        $viralBlogs = ArticleService::getViralBlogs(5);
        $ProfileDesa = ProfileDesa::GetProfileDesa();
        $categories = ArticleService::getCategoriesWithCount();

        $menus = Banner::where('type', 'sejarah')
            ->select('title_sejarah', 'images')
            ->get()
            ->flatMap(function ($banner) {
                return collect($banner->title_sejarah)
                    ->map(function ($title, $i) use ($banner) {
                        return [
                            'title' => $title,
                            'image' => $banner->images[$i] ?? null,
                        ];
                    });
            })
            ->values()
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
            'viralBlogs',
            'headlines',
            'categories',
            'blogs',
            'ProfileDesa',
            'menus',
            'title'
        ));
    }
}
