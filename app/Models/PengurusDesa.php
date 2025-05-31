<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class PengurusDesa extends Model
{
    use HasFactory;

    protected $table = 'pengurus_desas';

    protected $fillable = [
        'user_id',
        'jabatan',
        'is_wakil',
        'mulai_jabatan',
        'selesai_jabatan',
        'is_aktif',
        'keterangan',
        'tugas_pokok'
    ];

    protected $casts = [
        'mulai_jabatan' => 'date',
        'selesai_jabatan' => 'date',
        'is_aktif' => 'boolean',
        'is_wakil' => 'boolean'
    ];

    // Static jabatan options
    public static $jabatan_options = [
        'kepala_desa' => 'Kepala Desa',
        'sekretaris_desa' => 'Sekretaris Desa',
        'bendahara_desa' => 'Bendahara Desa',
        'kaur_keuangan' => 'Kepala Urusan Keuangan',
        'kaur_umum' => 'Kepala Urusan Umum',
        'kaur_pembangunan' => 'Kepala Urusan Pembangunan',
        'kasi_pemerintahan' => 'Kepala Seksi Pemerintahan',
        'kasi_kesejahteraan' => 'Kepala Seksi Kesejahteraan',
        'kasi_pelayanan' => 'Kepala Seksi Pelayanan'
    ];

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function penduduk(): BelongsTo
    {
        return $this->user->penduduk();
    }

    /**
     * Scopes
     */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    public function scopeUtama($query)
    {
        return $query->where('is_wakil', false);
    }

    public function scopeWakil($query)
    {
        return $query->where('is_wakil', true);
    }

    public function scopeByJabatan($query, $jabatan)
    {
        return $query->where('jabatan', $jabatan);
    }

    public function scopeOrderByHierarchy($query)
    {
        $hierarchy = [
            'kepala_desa' => 1,
            'sekretaris_desa' => 2,
            'bendahara_desa' => 3,
            'kaur_keuangan' => 4,
            'kaur_umum' => 5,
            'kaur_pembangunan' => 6,
            'kasi_pemerintahan' => 7,
            'kasi_kesejahteraan' => 8,
            'kasi_pelayanan' => 9
        ];

        return $query->orderByRaw("CASE jabatan " .
            collect($hierarchy)->map(fn($order, $jabatan) => "WHEN '$jabatan' THEN $order")->implode(' ') .
            " ELSE 99 END")
            ->orderBy('is_wakil');
    }

    /**
     * Accessors
     */
    public function getJabatanLabelAttribute()
    {
        $label = self::$jabatan_options[$this->jabatan] ?? $this->jabatan;
        return $this->is_wakil ? "Wakil $label" : $label;
    }

    public function getJabatanFullAttribute()
    {
        return $this->jabatan_label;
    }

    public function getMasaJabatanAttribute()
    {
        $start = $this->mulai_jabatan->format('d M Y');
        $end = $this->selesai_jabatan ? $this->selesai_jabatan->format('d M Y') : 'Sekarang';
        return "$start - $end";
    }

    public function getDurasiJabatanAttribute()
    {
        $end = $this->selesai_jabatan ?: now();
        return $this->mulai_jabatan->diffForHumans($end, true);
    }

    /**
     * Static Methods
     */
    public static function getKepalaDesaAktif()
    {
        return self::aktif()->byJabatan('kepala_desa')->utama()->with('user.penduduk')->first();
    }

    public static function getWakilKepalaDesaAktif()
    {
        return self::aktif()->byJabatan('kepala_desa')->wakil()->with('user.penduduk')->first();
    }

    public static function getPengurusAktif()
    {
        return self::aktif()
            ->with('user.penduduk')
            ->orderByHierarchy()
            ->get();
    }

    public static function getPengurusUtamaAktif()
    {
        return self::aktif()
            ->utama()
            ->with('user.penduduk')
            ->orderByHierarchy()
            ->get();
    }

    public static function getPengurusWakilAktif()
    {
        return self::aktif()
            ->wakil()
            ->with('user.penduduk')
            ->orderByHierarchy()
            ->get();
    }

    public static function validateJabatanUnik($jabatan, $isWakil = false, $userId = null)
    {
        $query = self::aktif()->byJabatan($jabatan)->where('is_wakil', $isWakil);

        if ($userId) {
            $query->where('user_id', '!=', $userId);
        }

        return !$query->exists();
    }

    /**
     * Methods
     */
    public function nonAktifkan($keterangan = null)
    {
        $this->update([
            'is_aktif' => false,
            'selesai_jabatan' => now()->toDateString(),
            'keterangan' => $keterangan
        ]);
    }

    public function isUtama()
    {
        return !$this->is_wakil;
    }

    public function isWakil()
    {
        return $this->is_wakil;
    }
}
