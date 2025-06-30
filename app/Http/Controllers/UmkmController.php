<?php

namespace App\Http\Controllers;

use App\Models\UmkmProduct;
use App\Models\Category;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categorySlug = $request->input('category');
        $sortBy = $request->input('sort', 'newest');

        $query = UmkmProduct::with('category')->active();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if (!empty($categorySlug)) {
            $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
        }

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

        $categories = Category::where('type', 'umkm')->orderBy('name')->get();
        $products = $query->paginate(8)->withQueryString();

        return view('pages.umkm', compact('products', 'categories'));
    }


    public function show($slug)
    {
        $product = UmkmProduct::with('category')
            ->whereHas('category', function ($query) {
                $query->where('type', 'umkm');
            })
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.DetailUmkm', compact('product'));
    }
}
