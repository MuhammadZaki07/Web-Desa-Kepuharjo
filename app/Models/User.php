<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    public function penduduk(): HasOne
    {
        return $this->hasOne(Penduduk::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPenduduk(): bool
    {
        return $this->role === 'penduduk';
    }

    // Tambahkan di User Model (App\Models\User.php)

    /**
     * Relationship dengan PengurusDesa
     */
    public function pengurusDesa()
    {
        return $this->hasMany(PengurusDesa::class);
    }

    public function pengurusDesaAktif()
    {
        return $this->hasOne(PengurusDesa::class)->where('is_aktif', true);
    }

    public function pengurusDesaUtamaAktif()
    {
        return $this->hasOne(PengurusDesa::class)->where('is_aktif', true)->where('is_wakil', false);
    }

    public function pengurusDesaWakilAktif()
    {
        return $this->hasOne(PengurusDesa::class)->where('is_aktif', true)->where('is_wakil', true);
    }

    /**
     * Check apakah user adalah pengurus aktif
     */
    public function isPengurusAktif()
    {
        return $this->pengurusDesaAktif()->exists();
    }

    public function isPengurusUtamaAktif()
    {
        return $this->pengurusDesaUtamaAktif()->exists();
    }

    public function isPengurusWakilAktif()
    {
        return $this->pengurusDesaWakilAktif()->exists();
    }

    /**
     * Get jabatan pengurus aktif
     */
    public function getJabatanPengurusAttribute()
    {
        return $this->pengurusDesaAktif?->jabatan_full;
    }

    /**
     * Check role pengurus spesifik
     */
    public function isKepalaDesaAktif()
    {
        return $this->pengurusDesaAktif?->jabatan === 'kepala_desa' && !$this->pengurusDesaAktif?->is_wakil;
    }

    public function isWakilKepalaDesaAktif()
    {
        return $this->pengurusDesaAktif?->jabatan === 'kepala_desa' && $this->pengurusDesaAktif?->is_wakil;
    }

    public function isSekretarisDesaAktif()
    {
        return $this->pengurusDesaAktif?->jabatan === 'sekretaris_desa' && !$this->pengurusDesaAktif?->is_wakil;
    }

    public function isWakilSekretarisDesaAktif()
    {
        return $this->pengurusDesaAktif?->jabatan === 'sekretaris_desa' && $this->pengurusDesaAktif?->is_wakil;
    }

    public function isBendaharaDesaAktif()
    {
        return $this->pengurusDesaAktif?->jabatan === 'bendahara_desa' && !$this->pengurusDesaAktif?->is_wakil;
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get published articles by this user
     */
    public function publishedArticles(): HasMany
    {
        return $this->hasMany(Article::class)->where('status', 'published');
    }

    /**
     * Get total views for all user's articles
     */
    public function getTotalViewsAttribute(): int
    {
        return $this->articles()->sum('viewers');
    }
}
