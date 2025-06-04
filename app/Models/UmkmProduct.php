<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UmkmProduct extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'location',
        'images',
        'whatsapp_number',
        'category_id',
        'is_active',
        'detailed_description',
        'product_info',
        'suitable_for',
    ];

    protected $casts = [
        'images' => 'array',
        'product_info' => 'array',
        'suitable_for' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getMainImageAttribute(): ?string
    {
        return $this->images[0] ?? null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
