<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendudukExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Penduduk::with('user')->get()->map(function ($penduduk) {
            return [
                'nama_lengkap'       => $penduduk->user->name ?? '-',
                'nik'                => $penduduk->nik,
                'jenis_kelamin'      => $penduduk->jenis_kelamin,
                'email'              => $penduduk->user->email ?? '-',
                'no_telepon'         => $penduduk->user->phone ?? '-',
                'tempat_lahir'       => $penduduk->tempat_lahir,
                'tanggal_lahir'      => $penduduk->tanggal_lahir,
                'alamat'             => $penduduk->alamat,
                'rt'                 => $penduduk->rt,
                'rw'                 => $penduduk->rw,
                'agama'              => $penduduk->agama,
                'status_perkawinan'  => $penduduk->status_perkawinan,
                'pekerjaan'          => $penduduk->pekerjaan,
                'pendidikan'         => $penduduk->pendidikan,
                'catatan'            => $penduduk->catatan_penduduk,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIK',
            'Jenis Kelamin',
            'Email',
            'No Telepon',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'RT',
            'RW',
            'Agama',
            'Status Perkawinan',
            'Pekerjaan',
            'Pendidikan',
            'Catatan',
        ];
    }
}


