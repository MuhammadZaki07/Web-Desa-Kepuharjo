<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'content',
        'structure',
        'programs',
        'activities',
        'contact_phone',
    ];

    protected $casts = [
        'structure' => 'array',
        'programs' => 'array',
        'activities' => 'array',
    ];


    public function getTypeDisplayAttribute()
    {
        return match ($this->type) {
            'pkk' => 'PKK',
            'karang_taruna' => 'Karang Taruna',
            default => $this->type,
        };
    }

    public static function hasType(string $type): bool
    {
        return static::where('type', $type)->exists();
    }


    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function getTypeNameAttribute(): string
    {
        return match ($this->type) {
            'pkk' => 'PKK',
            'karang_taruna' => 'Karang Taruna',
            default => $this->type,
        };
    }
}
