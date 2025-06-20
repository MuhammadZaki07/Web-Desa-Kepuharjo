<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class ArticleService
{
    public static function getLatestPublishedBlogs(?string $category = null, int $perPage = 6): LengthAwarePaginator
    {
        $query = Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'created_at', 'category_id', 'excerpt', 'viewers', 'updated_at','published_at')
            ->with(['category:id,name,slug'])
            ->where('status', 'published')
            ->whereHas('category', function ($q) {
                $q->where('type', 'blogs');
            })
            ->orderByDesc('created_at');

        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        return $query->paginate($perPage);
    }

    public static function getViralBlogs(int $limit = 4): \Illuminate\Database\Eloquent\Collection
    {
        return Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'viewers', 'created_at', 'category_id', 'updated_at')
            ->with(['category:id,name,slug'])
            ->where('status', 'published')
            ->whereHas('category', function ($query) {
                $query->where('type', 'blogs');
            })
            ->orderByDesc('viewers')
            ->take($limit)
            ->get();
    }

    public static function getHeadlinesInPageArticle(int $limit = 2): \Illuminate\Database\Eloquent\Collection
    {
        return Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'created_at', 'category_id', 'viewers', 'updated_at')
            ->with(['category:id,name,slug,color'])
            ->where('status', 'published')
            ->whereHas('category', function ($query) {
                $query->where('type', 'blogs');
            })
            ->orderByDesc('viewers')
            ->take($limit)
            ->get();
    }

    public static function getHeadlines($limit = 5)
    {
        return Article::where('status', 'published')
            ->latest()
            ->take($limit)
            ->pluck('title');
    }

    public static function getCategoriesWithCount()
    {
        return Category::query()
            ->select('id', 'name', 'slug', 'color')
            ->where('type', 'blogs')
            ->withCount(['articles as published_articles_count' => function ($query) {
                $query->where('status', 'published');
            }])
            ->having('published_articles_count', '>', 0)
            ->orderBy('name')
            ->get();
    }


    public static function searchArticles(string $query, ?string $category = null, int $perPage = 6): LengthAwarePaginator
    {
        $articleQuery = Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'created_at', 'category_id', 'excerpt', 'viewers', 'updated_at')
            ->with(['category:id,name,slug'])
            ->where('status', 'published')
            ->whereHas('category', function ($q) {
                $q->where('type', 'blogs');
            })
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('excerpt', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%");
            });

        if ($category) {
            $articleQuery->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        return $articleQuery->orderByDesc('created_at')->paginate($perPage);
    }
}
