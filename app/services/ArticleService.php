<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArticleService
{
    /**
     * Blog terbaru dengan eager loading dan index optimization.
     */
// In ArticleService.php
public static function getLatestPublishedBlogs(?string $category = null, int $perPage = 6): LengthAwarePaginator
{
    static $cached = null;
    if ($cached) {
        return $cached;
    }
    $categories = cache()->remember('categories_for_blogs', 1800, function () {
        return Category::select('id', 'name', 'slug', 'color', 'type')->where('type', 'blogs')->get()->keyBy('id');
    });
    $query = Article::query()
        ->select(['id', 'title', 'slug', 'featured_image', 'created_at', 'category_id', 'excerpt', 'viewers', 'updated_at'])
        ->where('status', 'published')
        ->whereHas('category', fn($q) => $q->where('type', 'blogs'))
        ->latest('published_at');
    if ($category) {
        $query->whereHas('category', fn($q) => $q->where('slug', $category));
    }
    $articles = $query->paginate($perPage);
    $articles->getCollection()->each(function ($article) use ($categories) {
        $article->setRelation('category', $categories[$article->category_id] ?? null);
    });
    return $cached = $articles;
}

    /**
     * Artikel viral dengan eager loading.
     */
    public static function getViralBlogs(int $limit = 4): Collection
    {
        static $cached = null;

        if ($cached) {
            return $cached;
        }

        return $cached = Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'viewers', 'created_at', 'category_id', 'updated_at')
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('type', 'blogs'))
            ->with(['category:id,name,slug,color,type'])
            ->orderByDesc('viewers')
            ->take($limit)
            ->get();
    }

    /**
     * Headline di halaman artikel dengan eager loading.
     */
    public static function getHeadlinesInPageArticle(int $limit = 2): Collection
    {
        return Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'created_at', 'category_id', 'viewers', 'updated_at')
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('type', 'blogs'))
            ->with(['category:id,name,slug,color,type'])
            ->orderByDesc('viewers')
            ->take($limit)
            ->get();
    }

    /**
     * Headline pendek untuk homepage - tambah cache.
     */
    public static function getHeadlines(int $limit = 5): Collection
    {
        return Article::query()
            ->select('id', 'title', 'slug')
            ->where('status', 'published')
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    /**
     * Semua kategori blog yang punya artikel.
     */
    public static function getCategoriesWithCount(): Collection
    {
        return cache()->remember('categories_with_count', 1800, function () {
            return Category::query()
                ->select('id', 'name', 'slug', 'color')
                ->where('type', 'blogs')
                ->withCount([
                    'articles as published_articles_count' => fn($q) =>
                    $q->where('status', 'published')
                ])
                ->having('published_articles_count', '>', 0)
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Pencarian artikel dengan eager loading.
     */
    public static function searchArticles(string $query, ?string $category = null, int $perPage = 6): LengthAwarePaginator
    {
        $articleQuery = Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'created_at', 'category_id', 'excerpt', 'viewers', 'updated_at')
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('type', 'blogs'))
            ->with(['category:id,name,slug,color,type'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('excerpt', 'LIKE', "%{$query}%");
            });

        if ($category) {
            $articleQuery->whereHas('category', fn($q) => $q->where('slug', $category));
        }

        return $articleQuery->orderByDesc('created_at')->paginate($perPage);
    }
}
