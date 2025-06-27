<?php

namespace App\Imports;

use App\Models\Penduduk;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PendudukImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    public function model(array $row)
    {
        $user = User::create([
            'name' => $row['nama_lengkap'],
            // 'email' => $row['email'] ?? strtolower(str_replace(' ', '.', $row['nama_lengkap'])) . '@example.com',
            'phone' => $row['no_telepon'] ?? null,
            // 'password' => Hash::make($row['password'] ?? 'password123'),
            'role' => 'penduduk'
        ]);

        return new Penduduk([
            'user_id' => $user->id,
            'nik' => $row['nik'],
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $this->parseDate($row['tanggal_lahir'] ?? null),
            'jenis_kelamin' => strtoupper($row['jenis_kelamin']),
            'alamat' => $row['alamat'] ?? null,
            'RT' => $row['rt'] ?? null,
            'RW' => $row['rw'] ?? null,
            'agama' => $row['agama'] ?? null,
            'status_perkawinan' => $row['status_perkawinan'] ?? null,
            'pekerjaan' => $row['pekerjaan'] ?? null,
            'pendidikan' => $row['pendidikan'] ?? null,
            'catatan_penduduk' => $row['catatan'] ?? null,
            'status_nyawa' => 'hidup',
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:penduduks,nik',
            'jenis_kelamin' => 'required|in:L,P,Laki-laki,Perempuan',
            // 'email' => 'nullable|email|unique:users,email',
            'no_telepon' => 'nullable|string|max:20|unique:users,phone',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'jenis_kelamin.in' => 'Jenis kelamin harus L/P atau Laki-laki/Perempuan',
            // 'email.email' => 'Format email tidak valid',
            // 'email.unique' => 'Email sudah terdaftar',
            'no_telepon.unique' => 'No telepon sudah terdaftar',
        ];
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            if (is_numeric($date)) {
                return Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($date - 2);
            }

            $formats = ['Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y', 'Y/m/d'];

            foreach ($formats as $format) {
                try {
                    return Carbon::createFromFormat($format, $date);
                } catch (\Exception $e) {
                    continue;
                }
            }

            return Carbon::parse($date);
        } catch (\Exception $e) {
            return null;
        }
    }
}
