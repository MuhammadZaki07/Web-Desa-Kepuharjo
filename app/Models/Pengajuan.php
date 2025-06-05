<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'no_tlp',
        'description',
        'images',
        'status'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function getFormattedPhoneAttribute()
    {
        $phone = $this->no_tlp;

        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    public function getWhatsappUrlAttribute()
    {
        $message = "Halo {$this->name}, terkait pengajuan Anda dengan ID #{$this->id} sedang kami proses. Terima kasih telah menghubungi Desa kami.";

        return "https://wa.me/{$this->formatted_phone}?text=" . urlencode($message);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'diproses' => 'info',
            'selesai' => 'success',
            'ditolak' => 'danger',
            default => 'secondary'
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => 'Unknown'
        };
    }
}
