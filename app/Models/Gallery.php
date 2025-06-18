<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'path',
        'event_date',
        'is_featured',
    ];

    protected $casts = [
        'path' => 'array',
        'event_date' => 'date',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'type' => 'gallery',
        'is_featured' => false,
    ];

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function getFirstImageAttribute()
    {
        if (is_array($this->path) && count($this->path) > 0) {
            return Storage::url($this->path[0]);
        }
        return null;
    }

    public function getImageCountAttribute()
    {
        return is_array($this->path) ? count($this->path) : 0;
    }

    public function getTypeNameAttribute()
    {
        return match ($this->type) {
            'pkk' => 'PKK',
            'karang_taruna' => 'Karang Taruna',
            'gallery' => 'Galeri Umum',
            'kegiatan' => 'Kegiatan Desa',
            'infrastruktur' => 'Infrastruktur',
            'wisata' => 'Wisata Desa',
            default => ucfirst($this->type)
        };
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gallery) {
            if (empty($gallery->slug) && !empty($gallery->title)) {
                $gallery->slug = \Illuminate\Support\Str::slug($gallery->title);
            }
        });

        static::updating(function ($gallery) {
            if ($gallery->isDirty('title') && !empty($gallery->title)) {
                $gallery->slug = \Illuminate\Support\Str::slug($gallery->title);
            }
        });

        static::deleting(function ($gallery) {
            $paths = is_array($gallery->path) ? $gallery->path : json_decode($gallery->path, true);

            if (is_array($paths)) {
                foreach ($paths as $imagePath) {
                    if (Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
            }
        });
    }
}
