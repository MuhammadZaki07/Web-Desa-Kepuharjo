<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Wisata extends Model
{
    use HasFactory;

    protected $table = 'wisata';

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'long_description',
        'location',
        'latitude',
        'longitude',
        'price',
        'child_price',
        'parking_motor_price',
        'parking_car_price',
        'main_image',
        'gallery_images',
        'address',
        'phone',
        'whatsapp',
        'email',
        'social_media',
        'opening_time',
        'closing_time',
        'facilities',
        'activities',
        'is_active',
        'is_featured',
        'views'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'social_media' => 'array',
        'facilities' => 'array',
        'activities' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($wisata) {
            if (empty($wisata->slug)) {
                $wisata->slug = Str::slug($wisata->name);
            }
        });

        static::updating(function ($wisata) {
            if ($wisata->isDirty('name')) {
                $wisata->slug = Str::slug($wisata->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeByPriceRange($query, $minPrice, $maxPrice = null)
    {
        if ($maxPrice) {
            return $query->whereBetween('price', [$minPrice, $maxPrice]);
        }
        return $query->where('price', '>=', $minPrice);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        });
    }

    public function getFormattedPriceAttribute()
    {
        if ($this->price == 0) {
            return 'Gratis';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedChildPriceAttribute()
    {
        if (!$this->child_price) {
            return null;
        }
        return 'Rp ' . number_format($this->child_price, 0, ',', '.');
    }

    public function getFormattedParkingMotorPriceAttribute()
    {
        return 'Rp ' . number_format($this->parking_motor_price, 0, ',', '.');
    }

    public function getFormattedParkingCarPriceAttribute()
    {
        return 'Rp ' . number_format($this->parking_car_price, 0, ',', '.');
    }

    public function getMainImageUrlAttribute()
    {
        if ($this->main_image) {
            return asset('storage/' . $this->main_image);
        }
        return 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=500&h=300&fit=crop';
    }

    public function getGalleryImageUrlsAttribute()
    {
        if ($this->gallery_images && is_array($this->gallery_images)) {
            return array_map(function ($image) {
                return asset('storage/' . $image);
            }, $this->gallery_images);
        }
        return [];
    }

    public function getOperatingHoursAttribute()
    {
        if ($this->opening_time && $this->closing_time) {
            return $this->opening_time->format('H:i') . ' - ' . $this->closing_time->format('H:i') . ' WIB';
        }
        return 'Tidak tersedia';
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getWhatsAppBookingUrl($customMessage = null)
    {
        if (!$this->whatsapp) {
            return null;
        }

        $number = preg_replace('/\D/', '', $this->whatsapp);

        $number = preg_replace('/^0/', '62', $number);

        $message = $customMessage ?:
            "Halo! Saya tertarik untuk berkunjung ke {$this->name}.\n\n" .
            "Mohon informasi lebih lanjut mengenai:\n" .
            "- Ketersediaan tiket\n" .
            "- Jadwal kunjungan\n" .
            "- Informasi tambahan\n\n" .
            "Terima kasih!";

        return "https://wa.me/{$number}?text=" . urlencode($message);
    }


    public function getGoogleMapsUrl()
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }
        return null;
    }
}
