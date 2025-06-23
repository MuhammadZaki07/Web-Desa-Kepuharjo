<?php

namespace App\Models;

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
        $titles = $this->type === 'sejarah' ? $this->title_sejarah : $this->title;

        if (!is_array($titles)) return (string) $titles;

        if (isset($titles[0]) && is_array($titles[0]) && array_key_exists('value', $titles[0])) {
            return implode(', ', array_map(fn($item) => $item['value'], $titles));
        }

        return implode(', ', $titles);
    }

    protected static function booted()
    {
        // Saat model dihapus
        static::deleted(function (Banner $banner) {
            foreach ((array) $banner->images as $image) {
                if (Storage::exists($image)) {
                    Storage::delete($image);
                }
            }
        });

        static::updating(function (Banner $banner) {
            $originalImages = (array) $banner->getOriginal('images');
            $newImages = (array) $banner->images;

            $deletedImages = array_diff($originalImages, $newImages);

            foreach ($deletedImages as $image) {
                if (Storage::exists($image)) {
                    Storage::delete($image);
                }
            }
        });
    }
}
