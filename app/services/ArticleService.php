<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Carbon;

class ArticleService
{
    public static function getLatestPublishedBlogs($limit = 3)
    {
        return Article::where('status', 'published')
            ->latest()
            ->take($limit)
            ->get()
            ->map(function ($article) {
                return [
                    'title' => $article->title,
                    'image' => $article->featured_image,
                    'url' => route('detail-blog', $article->slug),
                    'time' => Carbon::parse($article->created_at)->diffForHumans(),
                ];
            });
    }

    public static function getViralBlogs($limit = 5)
    {
        return Article::where('status', 'published')
            ->whereHas('category', function ($query) {
                $query->where('type', 'blogs');
            })
            ->with('category')
            ->orderByDesc('viewers')
            ->take($limit)
            ->get()
            ->map(function ($article) {
                return [
                    'title' => $article->title,
                    'image' => $article->featured_image,
                    'url' => route('detail-blog', $article->slug),
                    'views' => $article->viewers,
                    'time' => Carbon::parse($article->created_at)->diffForHumans(),
                    'category' => $article->category?->name ?? '-',
                ];
            });
    }

    public static function getHeadlines($limit = 5)
    {
        return Article::where('status', 'published')
            ->latest()
            ->take($limit)
            ->pluck('title');
    }
}
