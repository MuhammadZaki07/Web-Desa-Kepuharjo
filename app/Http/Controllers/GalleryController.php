<?php

namespace App\Http\Controllers;

use App\Helpers\ProfileDesa;
use App\Helpers\TimeHelper;
use App\Models\Gallery;
use App\Services\ArticleService;
use App\Services\BannersService;
use Illuminate\Support\Str;

class GalleryController extends Controller
{

    protected BannersService $bannersService;

    public function __construct(BannersService $bannersService)
    {
        $this->bannersService = $bannersService;
    }
 public function index()
{
    $ProfileDesa = ProfileDesa::GetProfileDesa();
    $Time = TimeHelper::getFormattedTime();
    $jam = $Time['jam'];
    $tanggal = $Time['tanggal'];
    $format = $Time['format'];
    $headlines = ArticleService::getHeadlines();
    $categories = ArticleService::getCategoriesWithCount();
    $articles = ArticleService::getViralBlogs();
    $banner = $this->bannersService->getBanner("gallery");
    $imagesPathBanner = $this->bannersService->getBannerImagePath($banner);

    $galleries = Gallery::where('is_featured', 1)
        ->when(request('search'), function ($query) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%');
        })
        ->when(request('type'), function ($query) {
            $query->where('type', request('type'));
        })
        ->latest()
        ->paginate(12)
        ->withQueryString();

    $types = Gallery::distinct()->pluck('type');

    return view('pages.gallery', compact(
        'tanggal',
        'jam',
        'format',
        'headlines',
        'ProfileDesa',
        'categories',
        'articles',
        'imagesPathBanner',
        'banner',
        'galleries',
        'types'
    ));
}
}
