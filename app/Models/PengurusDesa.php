<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

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
     * Boot method with improved error handling
     */
    // PERBAIKAN untuk boot method di PengurusDesa Model

    protected static function booted()
    {
        static::saving(function ($model) {
            try {
                // Hanya jalankan logika ini jika record yang disimpan adalah aktif
                if ($model->is_aktif) {
                    // PERBAIKAN: Tambahkan kondisi untuk menghindari konflik saat update
                    $query = self::where('user_id', $model->user_id)
                        ->where('is_aktif', true);

                    // Jika ini adalah update, exclude record yang sedang diupdate
                    if ($model->exists) {
                        $query->where('id', '!=', $model->id);
                    }

                    $existingActivePositions = $query->get();

                    // Nonaktifkan jabatan aktif lainnya dari user yang sama
                    foreach ($existingActivePositions as $existingPosition) {
                        $existingPosition->update([
                            'is_aktif' => false,
                            'selesai_jabatan' => now()->toDateString(),
                            'keterangan' => ($existingPosition->keterangan ? $existingPosition->keterangan . ' | ' : '') . 'Dinonaktifkan otomatis karena mendapat jabatan baru pada ' . now()->format('d/m/Y H:i')
                        ]);

                        Log::info("Auto-deactivated position ID {$existingPosition->id} for user {$model->user_id}");
                    }
                }
            } catch (Exception $e) {
                Log::error('Error in PengurusDesa boot method: ' . $e->getMessage(), [
                    'model_id' => $model->id ?? 'new',
                    'user_id' => $model->user_id ?? null,
                    'jabatan' => $model->jabatan ?? null,
                    'trace' => $e->getTraceAsString()
                ]);

                // Tidak throw exception agar tidak mengganggu proses save
                // Tapi log error untuk investigation
            }
        });

        // TAMBAHAN: Event untuk validasi sebelum save
        static::saving(function ($model) {
            try {
                // Validasi tanggal
                if ($model->mulai_jabatan && $model->selesai_jabatan) {
                    $mulai = Carbon::parse($model->mulai_jabatan);
                    $selesai = Carbon::parse($model->selesai_jabatan);

                    if ($selesai->lte($mulai)) {
                        throw new Exception('Tanggal selesai jabatan harus setelah tanggal mulai jabatan');
                    }
                }

                // Auto-set selesai_jabatan jika status non-aktif tapi belum ada tanggal selesai
                if (!$model->is_aktif && !$model->selesai_jabatan) {
                    $model->selesai_jabatan = now()->toDateString();
                    $model->keterangan = ($model->keterangan ? $model->keterangan . ' | ' : '') . 'Tanggal selesai diset otomatis karena status non-aktif';
                }

                // Auto-set non-aktif jika tanggal selesai sudah lewat
                if ($model->is_aktif && $model->selesai_jabatan) {
                    $selesai = Carbon::parse($model->selesai_jabatan);
                    if ($selesai->isPast()) {
                        $model->is_aktif = false;
                        $model->keterangan = ($model->keterangan ? $model->keterangan . ' | ' : '') . 'Status diset non-aktif karena tanggal selesai sudah lewat';
                    }
                }
            } catch (Exception $e) {
                Log::error('Error in PengurusDesa validation: ' . $e->getMessage());
                throw $e; // Throw error untuk validation errors
            }
        });
    }
    /**
     * Static Methods with improved error handling
     */
    public static function getKepalaDesaAktif()
    {
        try {
            return self::aktif()->byJabatan('kepala_desa')->utama()->with('user.penduduk')->first();
        } catch (Exception $e) {
            Log::error('Error getting active Kepala Desa: ' . $e->getMessage());
            return null;
        }
    }

    public static function getWakilKepalaDesaAktif()
    {
        try {
            return self::aktif()->byJabatan('kepala_desa')->wakil()->with('user.penduduk')->first();
        } catch (Exception $e) {
            Log::error('Error getting active Wakil Kepala Desa: ' . $e->getMessage());
            return null;
        }
    }

    public static function getPengurusAktif()
    {
        try {
            return self::aktif()
                ->with('user.penduduk')
                ->orderByHierarchy()
                ->get();
        } catch (Exception $e) {
            Log::error('Error getting active pengurus: ' . $e->getMessage());
            return collect([]);
        }
    }

    public static function getPengurusUtamaAktif()
    {
        try {
            return self::aktif()
                ->utama()
                ->with('user.penduduk')
                ->orderByHierarchy()
                ->get();
        } catch (Exception $e) {
            Log::error('Error getting active pengurus utama: ' . $e->getMessage());
            return collect([]);
        }
    }

    public static function getPengurusWakilAktif()
    {
        try {
            return self::aktif()
                ->wakil()
                ->with('user.penduduk')
                ->orderByHierarchy()
                ->get();
        } catch (Exception $e) {
            Log::error('Error getting active pengurus wakil: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Enhanced validation method
     */
    public static function validateJabatanUnik($jabatan, $isWakil = false, $userId = null, $excludeId = null)
    {
        try {
            $query = self::aktif()->byJabatan($jabatan)->where('is_wakil', $isWakil);

            if ($userId) {
                $query->where('user_id', '!=', $userId);
            }

            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            return !$query->exists();
        } catch (Exception $e) {
            Log::error('Error validating jabatan unique: ' . $e->getMessage());
            // Return false to be safe - don't allow if we can't validate
            return false;
        }
    }

    /**
     * Check if user has any active positions
     */
    public static function userHasActivePosition($userId, $excludeId = null)
    {
        try {
            $query = self::where('user_id', $userId)->where('is_aktif', true);

            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            return $query->exists();
        } catch (Exception $e) {
            Log::error('Error checking user active position: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get detailed validation result with message
     */
    public static function validateJabatanWithMessage($jabatan, $isWakil = false, $userId = null, $excludeId = null)
    {
        try {
            // Check if position is already occupied
            $existingPengurus = self::aktif()
                ->byJabatan($jabatan)
                ->where('is_wakil', $isWakil)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->with('user')
                ->first();

            if ($existingPengurus) {
                $jabatanLabel = self::$jabatan_options[$jabatan] ?? $jabatan;
                $jabatanFull = $isWakil ? "Wakil {$jabatanLabel}" : $jabatanLabel;

                return [
                    'valid' => false,
                    'message' => "Jabatan {$jabatanFull} sudah diisi oleh {$existingPengurus->user->name}",
                    'existing_pengurus' => $existingPengurus
                ];
            }

            // Check if user already has active position
            if ($userId) {
                $userActivePengurus = self::where('user_id', $userId)
                    ->where('is_aktif', true)
                    ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                    ->with('user')
                    ->first();

                if ($userActivePengurus) {
                    return [
                        'valid' => false,
                        'message' => "Pengurus ini sudah memiliki jabatan aktif: {$userActivePengurus->jabatan_label}",
                        'existing_pengurus' => $userActivePengurus
                    ];
                }
            }

            return ['valid' => true, 'message' => 'Valid'];
        } catch (Exception $e) {
            Log::error('Error in detailed validation: ' . $e->getMessage());
            return [
                'valid' => false,
                'message' => 'Terjadi kesalahan saat validasi',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Enhanced non-aktifkan method with error handling
     */
    public function nonAktifkan($keterangan = null, $tanggalSelesai = null)
    {
        try {
            return $this->update([
                'is_aktif' => false,
                'selesai_jabatan' => $tanggalSelesai ?: now()->toDateString(),
                'keterangan' => $keterangan ?: 'Dinonaktifkan pada ' . now()->format('d/m/Y H:i')
            ]);
        } catch (QueryException $e) {
            Log::error('Database error in nonAktifkan: ' . $e->getMessage());
            throw new Exception('Gagal menonaktifkan pengurus karena kesalahan database');
        } catch (Exception $e) {
            Log::error('Error in nonAktifkan: ' . $e->getMessage());
            throw new Exception('Terjadi kesalahan saat menonaktifkan pengurus');
        }
    }

    /**
     * Safe aktifkan method with validation
     */
    public function aktifkanKembali($keterangan = null)
    {
        try {
            // Check if position is available
            $validation = self::validateJabatanWithMessage(
                $this->jabatan,
                $this->is_wakil,
                $this->user_id,
                $this->id
            );

            if (!$validation['valid']) {
                throw new Exception($validation['message']);
            }

            return $this->update([
                'is_aktif' => true,
                'selesai_jabatan' => null,
                'keterangan' => $keterangan ?: 'Diaktifkan kembali pada ' . now()->format('d/m/Y H:i')
            ]);
        } catch (QueryException $e) {
            Log::error('Database error in aktifkanKembali: ' . $e->getMessage());
            throw new Exception('Gagal mengaktifkan pengurus karena kesalahan database');
        } catch (Exception $e) {
            Log::error('Error in aktifkanKembali: ' . $e->getMessage());
            throw $e; // Re-throw to preserve the specific error message
        }
    }

    /**
     * Safe delete method
     */
    public function safeDelete()
    {
        try {
            // Check if this pengurus has any related data that would prevent deletion
            // You can add more checks here based on your relationships

            return $this->delete();
        } catch (QueryException $e) {
            Log::error('Database error in safeDelete: ' . $e->getMessage());

            if ($e->getCode() === '23000') {
                throw new Exception('Tidak dapat menghapus pengurus karena masih terkait dengan data lain');
            }

            throw new Exception('Gagal menghapus pengurus karena kesalahan database');
        } catch (Exception $e) {
            Log::error('Error in safeDelete: ' . $e->getMessage());
            throw new Exception('Terjadi kesalahan saat menghapus pengurus');
        }
    }

    /**
     * Utility Methods
     */
    public function isUtama()
    {
        return !$this->is_wakil;
    }

    public function isWakil()
    {
        return $this->is_wakil;
    }

    /**
     * Get conflicting pengurus for a given position
     */
    public static function getConflictingPengurus($jabatan, $isWakil = false, $excludeId = null)
    {
        try {
            return self::aktif()
                ->byJabatan($jabatan)
                ->where('is_wakil', $isWakil)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->with('user')
                ->get();
        } catch (Exception $e) {
            Log::error('Error getting conflicting pengurus: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Check if current model can be safely updated
     */
    public function canBeUpdated($newData = [])
    {
        try {
            $jabatan = $newData['jabatan'] ?? $this->jabatan;
            $isWakil = $newData['is_wakil'] ?? $this->is_wakil;
            $userId = $newData['user_id'] ?? $this->user_id;
            $isAktif = $newData['is_aktif'] ?? $this->is_aktif;

            // Only validate if the record will be active
            if (!$isAktif) {
                return ['can_update' => true, 'message' => 'OK'];
            }

            $validation = self::validateJabatanWithMessage($jabatan, $isWakil, $userId, $this->id);

            return [
                'can_update' => $validation['valid'],
                'message' => $validation['message'],
                'existing_pengurus' => $validation['existing_pengurus'] ?? null
            ];
        } catch (Exception $e) {
            Log::error('Error in canBeUpdated: ' . $e->getMessage());
            return [
                'can_update' => false,
                'message' => 'Terjadi kesalahan saat memvalidasi data'
            ];
        }
    }

    /**
     * Get summary of pengurus statistics
     */
    public static function getStatistics()
    {
        try {
            return [
                'total_pengurus' => self::count(),
                'active_pengurus' => self::aktif()->count(),
                'inactive_pengurus' => self::where('is_aktif', false)->count(),
                'utama_pengurus' => self::aktif()->utama()->count(),
                'wakil_pengurus' => self::aktif()->wakil()->count(),
                'available_positions' => count(self::$jabatan_options) * 2 - self::aktif()->count()
            ];
        } catch (Exception $e) {
            Log::error('Error getting statistics: ' . $e->getMessage());
            return [
                'total_pengurus' => 0,
                'active_pengurus' => 0,
                'inactive_pengurus' => 0,
                'utama_pengurus' => 0,
                'wakil_pengurus' => 0,
                'available_positions' => 0,
                'error' => 'Gagal mengambil statistik'
            ];
        }
    }
}
