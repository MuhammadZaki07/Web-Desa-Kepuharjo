<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class ProfileDesa extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'logo_desa',
        'name',
        'email',
        'no_tlp',
        'website',
        'alamat_kantor',
        'kode_pos',
        'sambutan_kepala_desa',
        'motto_desa',
        'sejarah_desa',
        'program_unggulan',
        'visi',
        'misi',
        'instagram',
        'facebook',
        'tiktok',
        'youtube',
        'whatsapp',
        'threads',
    ];

    protected $casts = [
        'visi' => 'array',
        'misi' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function images(): MorphMany
    {
        return $this->morphMany(Images::class, 'imageable');
    }

    // Accessors
    public function getLogoDesaUrlAttribute(): ?string
    {
        if ($this->logo_desa) {
            return Storage::disk('public')->url($this->logo_desa);
        }
        return null;
    }

    public function getVisiListAttribute(): array
    {
        return $this->visi ? collect($this->visi)->pluck('poin_visi')->filter()->toArray() : [];
    }

    public function getMisiListAttribute(): array
    {
        return $this->misi ? collect($this->misi)->pluck('poin_misi')->filter()->toArray() : [];
    }

    // Social Media URL Getters
    public function getInstagramUrlAttribute(): ?string
    {
        return $this->instagram ? 'https://instagram.com/' . $this->instagram : null;
    }

    public function getFacebookUrlAttribute(): ?string
    {
        return $this->facebook ? 'https://facebook.com/' . $this->facebook : null;
    }

    public function getTiktokUrlAttribute(): ?string
    {
        return $this->tiktok ? 'https://tiktok.com/@' . $this->tiktok : null;
    }

    public function getYoutubeUrlAttribute(): ?string
    {
        return $this->youtube ? 'https://youtube.com/' . $this->youtube : null;
    }

    public function getWhatsappUrlAttribute(): ?string
    {
        return $this->whatsapp ? 'https://wa.me/' . $this->whatsapp : null;
    }

    public function getThreadsUrlAttribute(): ?string
    {
        return $this->threads ? 'https://threads.net/@' . $this->threads : null;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereNotNull('name')->whereNotNull('email');
    }

    public function scopeWithSocialMedia($query)
    {
        return $query->where(function ($q) {
            $q->whereNotNull('instagram')
              ->orWhereNotNull('facebook')
              ->orWhereNotNull('tiktok')
              ->orWhereNotNull('youtube')
              ->orWhereNotNull('whatsapp')
              ->orWhereNotNull('threads');
        });
    }

    // Methods
    public function hasVisiMisi(): bool
    {
        return !empty($this->visi_list) || !empty($this->misi_list);
    }

    public function hasSocialMedia(): bool
    {
        return !empty($this->instagram) || !empty($this->facebook) ||
               !empty($this->tiktok) || !empty($this->youtube) ||
               !empty($this->whatsapp) || !empty($this->threads);
    }

    public function getSocialMediaLinks(): array
    {
        $links = [];

        if ($this->instagram) {
            $links['instagram'] = [
                'name' => 'Instagram',
                'url' => $this->instagram_url,
                'icon' => 'instagram'
            ];
        }

        if ($this->facebook) {
            $links['facebook'] = [
                'name' => 'Facebook',
                'url' => $this->facebook_url,
                'icon' => 'facebook'
            ];
        }

        if ($this->tiktok) {
            $links['tiktok'] = [
                'name' => 'TikTok',
                'url' => $this->tiktok_url,
                'icon' => 'tiktok'
            ];
        }

        if ($this->youtube) {
            $links['youtube'] = [
                'name' => 'YouTube',
                'url' => $this->youtube_url,
                'icon' => 'youtube'
            ];
        }

        if ($this->whatsapp) {
            $links['whatsapp'] = [
                'name' => 'WhatsApp',
                'url' => $this->whatsapp_url,
                'icon' => 'whatsapp'
            ];
        }

        if ($this->threads) {
            $links['threads'] = [
                'name' => 'Threads',
                'url' => $this->threads_url,
                'icon' => 'threads'
            ];
        }

        return $links;
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        // Before saving, validate unique constraints
        static::saving(function ($model) {
            // Clean up social media inputs
            $model->instagram = $model->cleanSocialMediaInput($model->instagram);
            $model->facebook = $model->cleanSocialMediaInput($model->facebook);
            $model->tiktok = $model->cleanSocialMediaInput($model->tiktok);
            $model->youtube = $model->cleanSocialMediaInput($model->youtube);
            $model->whatsapp = $model->cleanSocialMediaInput($model->whatsapp);
            $model->threads = $model->cleanSocialMediaInput($model->threads);
        });

        // After deleting, clean up files
        static::deleted(function ($model) {
            if ($model->logo_desa) {
                Storage::disk('public')->delete($model->logo_desa);
            }
        });
    }

    private function cleanSocialMediaInput(?string $input): ?string
    {
        if (empty($input)) {
            return null;
        }

        return trim($input);
    }
}
