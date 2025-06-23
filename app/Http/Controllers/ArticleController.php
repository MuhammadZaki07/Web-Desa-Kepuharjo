<?php

namespace App\Http\Controllers;

use App\Helpers\ProfileDesa;
use App\Helpers\TimeHelper;
use App\Models\Article;
use App\Models\Category;
use App\Models\ProfileDesa as ModelsProfileDesa;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $timeData = TimeHelper::getFormattedTime();
        $tanggal = $timeData['tanggal'];
        $jam = $timeData['jam'];
        $format = $timeData['format'];
        $title = "Berita";

        $search = $request->get('search');
        $category = $request->get('category');
        $sort = $request->get('sort', 'terbaru');
        $perPage = 6;
        $ProfileDesa = ModelsProfileDesa::first();


        $getHeadlinesInPageArticle = ArticleService::getHeadlinesInPageArticle();
        $headlines = ArticleService::getHeadlines();
        $articles = $this->getFilteredArticles($search, $category, $sort, $perPage);
        $categories = ArticleService::getCategoriesWithCount();


        return view('pages.berita', compact(
            'headlines',
            'articles',
            'getHeadlinesInPageArticle',
            'categories',
            'ProfileDesa',
            'jam',
            'tanggal',
            'format',
            'title',
            'search',
            'category',
            'sort'
        ));
    }

    public function show($slug)
    {
        $timeData = TimeHelper::getFormattedTime();
        $tanggal = $timeData['tanggal'];
        $jam = $timeData['jam'];
        $format = $timeData['format'];
        $headlines = ArticleService::getHeadlines();
        $ProfileDesa = ModelsProfileDesa::first();


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
            ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'created_at', 'viewers', 'updated_at','category_id')
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
            'jam',
            'ProfileDesa',
            'headlines',
            'tanggal',
            'format',
            'title'
        ));
    }

    private function getFilteredArticles($search, $category, $sort, $perPage)
    {
        $query = Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'created_at', 'published_at', 'category_id', 'viewers', 'excerpt', 'updated_at')
            ->with(['category:id,name,slug,color'])
            ->where('status', 'published')
            ->whereHas('category', function ($q) {
                $q->where('type', 'blogs');
            });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('excerpt', 'LIKE', "%{$search}%")
                    ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        switch ($sort) {
            case 'hari-ini':
                $query->where(function ($q) {
                    $q->whereDate('published_at', Carbon::today())
                        ->orWhere(function ($q2) {
                            $q2->whereNull('published_at')
                                ->whereDate('created_at', Carbon::today());
                        });
                })
                    ->orderByDesc('published_at')
                    ->orderByDesc('created_at');
                break;
            case 'bulan-ini':
                $query->where(function ($q) {
                    $q->where(function ($q1) {
                        $q1->whereMonth('published_at', Carbon::now()->month)
                            ->whereYear('published_at', Carbon::now()->year);
                    })
                        ->orWhere(function ($q2) {
                            $q2->whereNull('published_at')
                                ->whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year);
                        });
                })
                    ->orderByDesc('published_at')
                    ->orderByDesc('created_at');
                break;
            case 'tahun-ini':
                $query->where(function ($q) {
                    $q->whereYear('published_at', Carbon::now()->year)
                        ->orWhere(function ($q2) {
                            $q2->whereNull('published_at')
                                ->whereYear('created_at', Carbon::now()->year);
                        });
                })
                    ->orderByDesc('published_at')
                    ->orderByDesc('created_at');
                break;
            case 'views-terbanyak':
                $query->orderByDesc('viewers')
                    ->orderByDesc('published_at')
                    ->orderByDesc('created_at');
                break;
            case 'terbaru':
            default:
                $query->orderByDesc('published_at')
                    ->orderByDesc('created_at');
                break;
        }

        $articles = $query->paginate($perPage)->withQueryString();

        // Ensure published_at fallback for all articles
        $articles->getCollection()->transform(function ($item) {
            if (!$item->published_at) {
                $item->published_at = $item->created_at;
            }
            return $item;
        });

        return $articles;
    }


}
