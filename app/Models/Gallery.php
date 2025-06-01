<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $guarded = [];

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
}
