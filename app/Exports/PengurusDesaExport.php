<?php

namespace App\Exports;

use App\Models\PengurusDesa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengurusDesaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return PengurusDesa::with('user')->get()->map(function ($item) {
            return [
                'nama_lengkap'      => $item->user->name ?? '-',
                'jabatan'           => $item->jabatan,
                'is_wakil'          => $item->is_wakil ? 'Ya' : 'Tidak',
                'mulai_jabatan'     => $item->mulai_jabatan,
                'selesai_jabatan'   => $item->selesai_jabatan,
                'is_aktif'          => $item->is_aktif ? 'Aktif' : 'Nonaktif',
                'keterangan'        => $item->keterangan,
                'tugas_pokok'       => $item->tugas_pokok,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Jabatan',
            'Wakil?',
            'Mulai Jabatan',
            'Selesai Jabatan',
            'Status',
            'Keterangan',
            'Tugas Pokok',
        ];
    }
}
