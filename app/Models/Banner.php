<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'title' => 'array',
        'title_sejarah' => 'array',
    ];

    public function getImageUrlsAttribute()
    {
        $images = $this->images ?? [];

        if (!is_array($images)) {
            $images = [$images];
        }

        return array_map(fn($image) => Storage::url($image), $images);
    }

    public function getFormattedTitleAttribute(): string
    {
        if ($this->type === 'sejarah') {
            $titles = $this->title_sejarah;
        } else {
            $titles = $this->title;
        }

        if (!is_array($titles)) {
            return (string) $titles;
        }

        if (isset($titles[0]) && is_array($titles[0]) && array_key_exists('value', $titles[0])) {
            return implode(', ', array_map(fn($item) => $item['value'], $titles));
        }

        return implode(', ', $titles);
    }
}
