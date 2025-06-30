<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $title = "Berita";

        $search = $request->get('search');
        $category = $request->get('category');
        $sort = $request->get('sort', 'terbaru');
        $perPage = 6;

        $getHeadlinesInPageArticle = ArticleService::getHeadlinesInPageArticle();
        $articles = $this->getFilteredArticles($search, $category, $sort, $perPage);
        $categories = ArticleService::getCategoriesWithCount();


        return view('pages.berita', compact(
            'articles',
            'getHeadlinesInPageArticle',
            'categories',
            'title',
            'search',
            'category',
            'sort'
        ));
    }

    public function show($slug)
    {
        $article = Article::query()
            ->select('id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'created_at', 'updated_at', 'published_at', 'category_id', 'user_id', 'viewers', 'status')
            ->with([
                'category:id,name,slug,color',
                'author:id,name,photo,role,email',
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereHas('category', function ($q) {
                $q->where('type', 'blogs');
            })
            ->firstOrFail();

        if (!$article->published_at) {
            $article->published_at = $article->created_at;
        }

        $article->increment('viewers');

        $relatedArticles = Article::query()
            ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'created_at', 'viewers', 'updated_at', 'category_id')
            ->where('category_id', $article->category_id)
            ->with('category')
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get()
            ->each(function ($item) {
                $item->published_at = $item->published_at ?? $item->created_at;
            });

        $latestArticles = Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'published_at', 'created_at')
            ->where('status', 'published')
            ->whereHas('category', function ($q) {
                $q->where('type', 'blogs');
            })
            ->where('id', '!=', $article->id)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                if (!$item->published_at) {
                    $item->published_at = $item->created_at;
                }
                return $item;
            });

        $categories = ArticleService::getCategoriesWithCount();
        $title = $article->title;

        return view('pages.show-berita', compact(
            'article',
            'relatedArticles',
            'latestArticles',
            'categories',
            'title'
        ));
    }

    private function getFilteredArticles($search, $category, $sort, $perPage)
    {
        $now = Carbon::now();

        $query = Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'created_at', 'published_at', 'category_id', 'viewers', 'excerpt', 'updated_at')
            ->with(['category:id,name,slug,color'])
            ->where('status', 'published')
            ->whereHas('category', function ($q) {
                $q->where('type', 'blogs');
            });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        switch ($sort) {
            case 'hari-ini':
                $query->where(function ($q) use ($now) {
                    $q->whereDate('published_at', $now->toDateString())
                        ->orWhere(function ($q2) use ($now) {
                            $q2->whereNull('published_at')
                                ->whereDate('created_at', $now->toDateString());
                        });
                });
                break;

            case 'bulan-ini':
                $query->where(function ($q) use ($now) {
                    $q->where(function ($q1) use ($now) {
                        $q1->whereMonth('published_at', $now->month)
                            ->whereYear('published_at', $now->year);
                    })->orWhere(function ($q2) use ($now) {
                        $q2->whereNull('published_at')
                            ->whereMonth('created_at', $now->month)
                            ->whereYear('created_at', $now->year);
                    });
                });
                break;

            case 'tahun-ini':
                $query->where(function ($q) use ($now) {
                    $q->whereYear('published_at', $now->year)
                        ->orWhere(function ($q2) use ($now) {
                            $q2->whereNull('published_at')
                                ->whereYear('created_at', $now->year);
                        });
                });
                break;

            case 'views-terbanyak':
                $query->orderByDesc('viewers');
                break;
        }

        $query->orderByDesc('published_at')->orderByDesc('created_at');

        $articles = $query->paginate($perPage)->withQueryString();

        $articles->getCollection()->transform(function ($item) {
            $item->published_at = $item->published_at ?? $item->created_at;
            return $item;
        });

        return $articles;
    }
}
