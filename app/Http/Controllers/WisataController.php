<?php

namespace App\Http\Controllers;

use App\Helpers\ProfileDesa;
use App\Helpers\TimeHelper;
use App\Services\ArticleService;
use App\Models\Wisata;
use App\Models\Category;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function index(Request $request)
    {
        $timeData = TimeHelper::getFormattedTime();
        $tanggal = $timeData['tanggal'];
        $jam = $timeData['jam'];
        $format = $timeData['format'];
        $headlines = ArticleService::getHeadlines();
        $ProfileDesa = ProfileDesa::GetProfileDesa();
        $categories = Category::where('type', "wisata")->get();
        $query = Wisata::with('category')->active();
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        if ($request->filled('price_min') || $request->filled('price_max')) {
            $query->byPriceRange($request->price_min, $request->price_max);
        }
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        $wisataList = $query->paginate(6)->withQueryString();

        return view('pages.wisata', compact(
            'jam',
            'tanggal',
            'format',
            'headlines',
            'ProfileDesa',
            'wisataList',
            'categories'
        ));
    }

    public function show($slug)
    {
        $timeData = TimeHelper::getFormattedTime();
        $tanggal = $timeData['tanggal'];
        $jam = $timeData['jam'];
        $format = $timeData['format'];
        $headlines = ArticleService::getHeadlines();
        $ProfileDesa = ProfileDesa::GetProfileDesa();
        $wisata = Wisata::with('category')
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();
        $wisata->incrementViews();
        $recommendedWisata = Wisata::with('category')
            ->where('category_id', $wisata->category_id)
            ->where('id', '!=', $wisata->id)
            ->active()
            ->limit(3)
            ->get();
        if ($recommendedWisata->count() < 3) {
            $additionalWisata = Wisata::with('category')
                ->where('id', '!=', $wisata->id)
                ->whereNotIn('id', $recommendedWisata->pluck('id'))
                ->active()
                ->limit(3 - $recommendedWisata->count())
                ->get();

            $recommendedWisata = $recommendedWisata->merge($additionalWisata);
        }

        return view('pages.DetailWisata', compact(
            'jam',
            'tanggal',
            'format',
            'headlines',
            'ProfileDesa',
            'wisata',
            'recommendedWisata'
        ));
    }
}
