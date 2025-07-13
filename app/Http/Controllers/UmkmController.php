<?php

namespace App\Http\Controllers;

use App\Helpers\ProfileDesa;
use App\Helpers\TimeHelper;
use App\Models\UmkmProduct;
use App\Models\Category;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $timeData = TimeHelper::getFormattedTime();
        $tanggal = $timeData['tanggal'];
        $jam = $timeData['jam'];
        $format = $timeData['format'];
        $ProfileDesa = ProfileDesa::GetProfileDesa();
        $headlines = ArticleService::getHeadlines();

        $query = UmkmProduct::with('category')->active();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('location', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('category') && $request->category !== '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $categories = Category::where('type', 'umkm')
            ->orderBy('name', 'asc')
            ->get();

        $products = $query->paginate(8)->withQueryString();

        return view('pages.umkm', compact('products', 'categories', 'ProfileDesa', 'jam', 'format', 'tanggal', 'headlines'));
    }

    public function show($slug)
    {
        $timeData = TimeHelper::getFormattedTime();
        $tanggal = $timeData['tanggal'];
        $jam = $timeData['jam'];
        $format = $timeData['format'];
        $ProfileDesa = ProfileDesa::GetProfileDesa();
        $headlines = ArticleService::getHeadlines();
        $product = UmkmProduct::with('category')
            ->whereHas('category', function ($query) {
                $query->where('type', 'umkm');
            })
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.DetailUmkm', compact('product', 'ProfileDesa', 'jam', 'format', 'tanggal', 'headlines'));
    }
}
