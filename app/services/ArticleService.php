<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArticleService
{
    protected static $cachedCategories;

    /**
     * Ambil dan cache kategori berdasarkan ID.
     */
    public static function getCategories(array $ids): Collection
    {
        if (!self::$cachedCategories) {
            self::$cachedCategories = Category::whereIn('id', $ids)
                ->select('id', 'name', 'slug')
                ->get()
                ->keyBy('id');
        }

        return self::$cachedCategories->only($ids);
    }

    /**
     * Blog terbaru.
     */
    public static function getLatestPublishedBlogs(?string $category = null, int $perPage = 6): LengthAwarePaginator
    {
        $query = Article::query()
            ->select([
                'id',
                'title',
                'slug',
                'featured_image',
                'created_at',
                'category_id',
                'excerpt',
                'viewers',
                'updated_at',
                'published_at'
            ])
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('type', 'blogs'))
            ->latest();

        if ($category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $category));
        }

        $articles = $query->paginate($perPage);
        $categoryIds = $articles->pluck('category_id')->unique()->toArray();
        self::getCategories($categoryIds);

        return $articles;
    }

    /**
     * Artikel viral.
     */
    public static function getViralBlogs(int $limit = 4): Collection
    {
        $articles = Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'viewers', 'created_at', 'category_id', 'updated_at')
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('type', 'blogs'))
            ->orderByDesc('viewers')
            ->take($limit)
            ->get();

        $categoryIds = $articles->pluck('category_id')->unique()->toArray();
        self::getCategories($categoryIds);

        return $articles;
    }

    /**
     * Headline di halaman artikel.
     */
    public static function getHeadlinesInPageArticle(int $limit = 2): Collection
    {
        $articles = Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'created_at', 'category_id', 'viewers', 'updated_at')
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('type', 'blogs'))
            ->orderByDesc('viewers')
            ->take($limit)
            ->get();

        $categoryIds = $articles->pluck('category_id')->unique()->toArray();
        self::getCategories($categoryIds);

        return $articles;
    }

    /**
     * Headline pendek untuk homepage.
     */
    public static function getHeadlines(int $limit = 5): Collection
    {
        return Article::where('status', 'published')
            ->select('id', 'title')
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Semua kategori blog yang punya artikel.
     */
    public static function getCategoriesWithCount(): Collection
    {
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
    }

    /**
     * Pencarian artikel.
     */
    public static function searchArticles(string $query, ?string $category = null, int $perPage = 6): LengthAwarePaginator
    {
        $articleQuery = Article::query()
            ->select('id', 'title', 'slug', 'featured_image', 'created_at', 'category_id', 'excerpt', 'viewers', 'updated_at')
            ->where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('type', 'blogs'))
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('excerpt', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%");
            });

        if ($category) {
            $articleQuery->whereHas('category', fn($q) => $q->where('slug', $category));
        }

        $articles = $articleQuery->orderByDesc('created_at')->paginate($perPage);

        $categoryIds = $articles->pluck('category_id')->unique()->toArray();
        self::getCategories($categoryIds);

        return $articles;
    }
}
