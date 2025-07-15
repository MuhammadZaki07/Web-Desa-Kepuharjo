<?php

namespace App\Filament\Exports;

use App\Models\Penduduk;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PendudukExporter extends Exporter
{
    protected static ?string $model = Penduduk::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('user.name')
                ->label('Nama Lengkap'),

            ExportColumn::make('nik')
                ->label('NIK'),

            ExportColumn::make('jenis_kelamin')
                ->label('Jenis Kelamin'),

            ExportColumn::make('user.phone')
                ->label('No. Telepon'),

            ExportColumn::make('user.email')
                ->label('Email'),

            ExportColumn::make('tempat_lahir')
                ->label('Tempat Lahir'),

            ExportColumn::make('tanggal_lahir')
                ->label('Tanggal Lahir'),

            ExportColumn::make('alamat')
                ->label('Alamat'),

            ExportColumn::make('RT')
                ->label('RT'),

            ExportColumn::make('RW')
                ->label('RW'),

            ExportColumn::make('agama')
                ->label('Agama'),

            ExportColumn::make('status_perkawinan')
                ->label('Status Perkawinan'),

            ExportColumn::make('pekerjaan')
                ->label('Pekerjaan'),

            ExportColumn::make('pendidikan')
                ->label('Pendidikan'),

            ExportColumn::make('catatan_penduduk')
                ->label('Catatan'),

            ExportColumn::make('status_nyawa')
                ->label('Status Hidup'),

            ExportColumn::make('created_at')
                ->label('Tanggal Dibuat'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export data penduduk telah selesai dan ' . number_format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' berhasil diexport.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diexport.';
        }

        return $body;
    }
}
