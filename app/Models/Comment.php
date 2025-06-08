<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments";

    protected $fillable = [
        'name',
        'email',
        'website',
        'comment',
        'page_url',
        'page_title',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeForPage($query, $url)
    {
        return $query->where('page_url', $url);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getCleanWebsiteAttribute()
    {
        if (!$this->website) return null;

        $url = $this->website;
        if (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
            $url = 'https://' . $url;
        }
        return $url;
    }

    public function getCleanPageTitleAttribute()
    {
        return $this->page_title ?: 'Halaman Tidak Diketahui';
    }
}
