<?php

namespace App\Http\Controllers;

use App\Helpers\ProfileDesa;
use App\Helpers\TimeHelper;
use App\Services\ArticleService;
use App\Services\BannersService;
use Illuminate\Http\Request;

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


        return view('pages.gallery', compact('tanggal', 'jam', 'format', 'headlines', 'ProfileDesa', 'headlines', 'categories', 'articles', 'imagesPathBanner', 'banner'));
    }
}
