<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'type' => 'gallery',
    ];

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public static function getByType($type)
    {
        return static::where('type', $type)->latest()->get();
    }

    protected static function booted()
    {
        static::deleted(function ($gallery) {
            if ($gallery->path && Storage::disk('public')->exists($gallery->path)) {
                Storage::disk('public')->delete($gallery->path);
            }
        });
    }
}
