<?php

namespace App\Filament\Resources\PengurusDesaResource\Pages;

use App\Filament\Resources\PengurusDesaResource;
use App\Models\PengurusDesa;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class CreatePengurusDesa extends CreateRecord
{
    protected static string $resource = PengurusDesaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            Log::info('Form data before create:', [
                'data' => $data,
                'is_wakil' => $data['is_wakil'] ?? 'not set',
            ]);

            $hasActivePosition = PengurusDesa::where('user_id', $data['user_id'])
                ->where('is_aktif', true)
                ->exists();

            if ($hasActivePosition) {
                $user = User::find($data['user_id']);
                $existingPengurus = PengurusDesa::where('user_id', $data['user_id'])
                    ->where('is_aktif', true)
                    ->first();

                Notification::make()
                    ->title('Tidak Dapat Menambah Pengurus')
                    ->body("User {$user->name} sudah memiliki jabatan aktif: {$existingPengurus->jabatan_label}. Satu orang hanya boleh memiliki satu jabatan aktif.")
                    ->warning()
                    ->duration(8000)
                    ->send();

                $this->halt();
                return $data;
            }

            // 2. Pastikan is_wakil ada nilainya
            $isWakil = isset($data['is_wakil']) ? (bool) $data['is_wakil'] : false;
            $data['is_wakil'] = $isWakil; // Ensure it's explicitly set

            // Debug: Log the position being checked
            Log::info('Checking position conflict:', [
                'jabatan' => $data['jabatan'],
                'is_wakil' => $isWakil,
            ]);

            // 3. Validasi jabatan sudah terisi
            $conflictExists = PengurusDesa::where('jabatan', $data['jabatan'])
                ->where('is_wakil', $isWakil)
                ->where('is_aktif', true)
                ->exists();

            if ($conflictExists) {
                $jabatanLabel = PengurusDesa::$jabatan_options[$data['jabatan']] ?? $data['jabatan'];
                $jabatanFull = $isWakil ? "Wakil {$jabatanLabel}" : $jabatanLabel;

                $existingPengurus = PengurusDesa::where('jabatan', $data['jabatan'])
                    ->where('is_wakil', $isWakil)
                    ->where('is_aktif', true)
                    ->with('user')
                    ->first();

                Notification::make()
                    ->title('Jabatan Sudah Terisi')
                    ->body("Posisi {$jabatanFull} sudah diisi oleh {$existingPengurus->user->name}. Silakan pilih jabatan lain atau nonaktifkan pengurus yang lama terlebih dahulu. <a href='/admin/pengurus-desa' class='underline'>Kelola pengurus</a>.")
                    ->warning()
                    ->duration(8000)
                    ->send();

                $this->halt();
                return $data;
            }

            // 4. Validasi untuk wakil - pastikan jabatan utama sudah ada
            if ($isWakil) {
                $utamaExists = PengurusDesa::where('jabatan', $data['jabatan'])
                    ->where('is_wakil', false)
                    ->where('is_aktif', true)
                    ->exists();

                if (!$utamaExists) {
                    $jabatanLabel = PengurusDesa::$jabatan_options[$data['jabatan']] ?? $data['jabatan'];

                    Notification::make()
                        ->title('Tidak Dapat Menambah Wakil')
                        ->body("Tidak dapat menambah Wakil {$jabatanLabel} karena {$jabatanLabel} utama belum ada. Silakan tambahkan {$jabatanLabel} utama terlebih dahulu.")
                        ->warning()
                        ->duration(8000)
                        ->send();

                    $this->halt();
                    return $data;
                }
            }

            // 5. Validasi tanggal
            if (!empty($data['selesai_jabatan']) && !empty($data['mulai_jabatan'])) {
                $mulai = \Carbon\Carbon::parse($data['mulai_jabatan']);
                $selesai = \Carbon\Carbon::parse($data['selesai_jabatan']);

                if ($selesai->lte($mulai)) {
                    Notification::make()
                        ->title('Tanggal Tidak Valid')
                        ->body('Tanggal selesai jabatan harus setelah tanggal mulai jabatan.')
                        ->warning()
                        ->duration(6000)
                        ->send();

                    $this->halt();
                    return $data;
                }
            }

            // 6. Auto-set tanggal selesai jika non-aktif
            $isAktif = $data['is_aktif'] ?? true;
            if (!$isAktif && empty($data['selesai_jabatan'])) {
                $data['selesai_jabatan'] = now()->toDateString();
                $data['keterangan'] = ($data['keterangan'] ?? '') . ' (Tanggal selesai diset otomatis karena status non-aktif)';
            }

            if ($isAktif && !empty($data['selesai_jabatan'])) {
                $selesai = \Carbon\Carbon::parse($data['selesai_jabatan']);
                if ($selesai->isPast()) {
                    $data['is_aktif'] = false;
                    $data['keterangan'] = ($data['keterangan'] ?? '') . ' (Status diset non-aktif karena tanggal selesai sudah lewat)';
                }
            }

            Log::info('Creating PengurusDesa with validated data:', $data);

            return $data;
        } catch (Exception $e) {
            Log::error('Error in mutateFormDataBeforeCreate: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString(),
            ]);

            Notification::make()
                ->title('Terjadi Kesalahan')
                ->body('Terjadi kesalahan saat memproses data. Silakan coba lagi atau hubungi admin.')
                ->danger()
                ->send();

            $this->halt();
            return $data;
        }
    }
}
