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
            ->get();


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

    public function download($id)
    {
        $gallery = Gallery::findOrFail($id);

        $imagePath = $gallery->path ? asset('storage/' . $gallery->path) : asset('assets/images/profile.jpg');

        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            $imageContent = file_get_contents($imagePath);
            $extension = pathinfo(parse_url($imagePath, PHP_URL_PATH), PATHINFO_EXTENSION);
        } else {
            $fullPath = public_path($imagePath);

            if (!file_exists($fullPath)) {
                abort(404, 'File tidak ditemukan');
            }

            $imageContent = file_get_contents($fullPath);
            $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        }

        $fileName = Str::slug($gallery->title) . '.' . $extension;

        return response($imageContent)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Content-Length', strlen($imageContent));
    }
}
