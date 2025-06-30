<?php

namespace App\Http\Controllers;
use App\Models\Gallery;
use App\Services\ArticleService;
use App\Services\BannersService;

class GalleryController extends Controller
{

    protected BannersService $bannersService;

    public function __construct(BannersService $bannersService)
    {
        $this->bannersService = $bannersService;
    }
    public function index()
    {
        $search = request('search');
        $type = request('type');

        $articles = ArticleService::getViralBlogs();
        $banner = $this->bannersService->getBanner("gallery");
        $imagesPathBanner = $this->bannersService->getBannerImagePath($banner);

        $galleries = Gallery::where('is_featured', 1)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($type, fn($query, $type) => $query->where('type', $type))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $types = Gallery::distinct()->pluck('type');

        return view('pages.gallery', compact(
            'articles',
            'imagesPathBanner',
            'banner',
            'galleries',
            'types'
        ));
    }
}
