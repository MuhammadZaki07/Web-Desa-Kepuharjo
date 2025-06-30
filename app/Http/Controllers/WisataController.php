<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use App\Models\Category;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->input('search');
        $category   = $request->input('category');
        $priceMin   = $request->input('price_min');
        $priceMax   = $request->input('price_max');
        $sortBy     = $request->input('sort', 'newest');

        $categories = Category::where('type', "wisata")->get();
        $query = Wisata::with('category')->active();

        if ($search) {
            $query->search($search);
        }

        if ($category) {
            $query->byCategory($category);
        }

        if ($priceMin || $priceMax) {
            $query->byPriceRange($priceMin, $priceMax);
        }

        $sortOptions = [
            'oldest'    => ['created_at', 'asc'],
            'price_low' => ['price', 'asc'],
            'price_high' => ['price', 'desc'],
            'name_asc'  => ['name', 'asc'],
            'name_desc' => ['name', 'desc'],
            'newest'    => ['created_at', 'desc'],
        ];

        [$sortField, $sortDir] = $sortOptions[$sortBy] ?? ['created_at', 'desc'];
        $query->orderBy($sortField, $sortDir);

        $wisataList = $query->paginate(6)->withQueryString();

        return view('pages.wisata', compact('wisataList', 'categories'));
    }


    public function show($slug)
    {
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
            'wisata',
            'recommendedWisata'
        ));
    }
}
