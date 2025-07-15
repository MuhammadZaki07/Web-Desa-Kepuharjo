<?php

namespace App\Filament\Imports;

use App\Models\Penduduk;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PendudukImporter extends Importer
{
    protected static ?string $model = Penduduk::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nik')
                ->requiredMapping()
                ->rules(['required', 'max:255', 'unique:penduduks,nik']),
            ImportColumn::make('tempat_lahir')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('tanggal_lahir')
                ->rules(['nullable', 'date_format:d/m/Y']),
            ImportColumn::make('jenis_kelamin')
                ->requiredMapping()
                ->rules(['required', 'in:Laki-laki,Perempuan']),
            ImportColumn::make('alamat')
                ->rules(['nullable']),
            ImportColumn::make('RT')
                ->numeric()
                ->rules(['nullable', 'integer']),
            ImportColumn::make('RW')
                ->numeric()
                ->rules(['nullable', 'integer']),
            ImportColumn::make('agama')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('status_perkawinan')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('pekerjaan')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('pendidikan')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('status_nyawa')
                ->rules(['nullable', 'in:hidup,meninggal']),
            ImportColumn::make('catatan_penduduk')
                ->rules(['nullable']),
        ];
    }

    public function resolveRecord(): ?Penduduk
    {
        return Penduduk::firstOrNew([
            'nik' => $this->data['nik'],
        ]);
    }

    protected function beforeFill(): void
    {
        // Transform data sebelum disimpan ke database

        // 1. Buat user baru berdasarkan name dari CSV
        $user = User::firstOrCreate([
            'name' => $this->data['name'],
        ], [
            'email' => null, // Email bisa null sesuai migrasi
            'phone' => null, // Phone bisa null sesuai migrasi
            'is_active' => true,
            'role' => 'penduduk',
        ]);

        // 2. Set user_id
        $this->data['user_id'] = $user->id;

        // 3. Transform tanggal_lahir dari dd/mm/yyyy ke yyyy-mm-dd
        if (!empty($this->data['tanggal_lahir'])) {
            $date = \DateTime::createFromFormat('d/m/Y', $this->data['tanggal_lahir']);
            if ($date) {
                $this->data['tanggal_lahir'] = $date->format('Y-m-d');
            }
        }

        // 4. Transform jenis_kelamin dari "Laki-laki"/"Perempuan" ke "L"/"P"
        if ($this->data['jenis_kelamin'] === 'Laki-laki') {
            $this->data['jenis_kelamin'] = 'L';
        } elseif ($this->data['jenis_kelamin'] === 'Perempuan') {
            $this->data['jenis_kelamin'] = 'P';
        }


        unset($this->data['name']);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your penduduk import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
