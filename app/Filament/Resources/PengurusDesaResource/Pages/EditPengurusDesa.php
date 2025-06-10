<?php

namespace App\Filament\Resources\PengurusDesaResource\Pages;

use App\Filament\Resources\PengurusDesaResource;
use App\Models\PengurusDesa;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class EditPengurusDesa extends EditRecord
{
    protected static string $resource = PengurusDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus Pengurus')
                ->modalSubheading('Apakah Anda yakin ingin menghapus data pengurus ini?')
                ->action(function () {
                    try {
                        $namaUser = $this->record->user->name;
                        $this->record->delete();

                        Notification::make()
                            ->title('Berhasil Dihapus')
                            ->body("Data pengurus {$namaUser} telah berhasil dihapus.")
                            ->success()
                            ->send();

                        return redirect($this->getResource()::getUrl('index'));
                    } catch (QueryException $e) {
                        // Handle database constraint errors
                        if ($e->getCode() === '23000') {
                            Notification::make()
                                ->title('Tidak Dapat Menghapus')
                                ->body('Data pengurus tidak dapat dihapus karena masih terkait dengan data lain. Coba nonaktifkan pengurus ini sebagai gantinya.')
                                ->warning()
                                ->duration(8000)
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Gagal Menghapus')
                                ->body('Terjadi kesalahan saat menghapus data. Silakan coba lagi atau hubungi administrator.')
                                ->danger()
                                ->send();
                        }
                        $this->halt();
                    } catch (Exception $e) {
                        Notification::make()
                            ->title('Terjadi Kesalahan')
                            ->body('Gagal menghapus data pengurus. Silakan coba lagi.')
                            ->danger()
                            ->send();
                        $this->halt();
                    }
                }),

            Actions\Action::make('nonaktifkan')
                ->label('Non-aktifkan')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Non-aktifkan Pengurus')
                ->modalSubheading('Pengurus akan dinonaktifkan dan masa jabatan akan berakhir hari ini.')
                ->form([
                    \Filament\Forms\Components\Textarea::make('keterangan')
                        ->label('Alasan Non-aktif')
                        ->required()
                        ->placeholder('Masukkan alasan pengurus dinonaktifkan...')
                ])
                ->action(function (array $data) {
                    try {
                        $this->record->nonAktifkan($data['keterangan']);

                        Notification::make()
                            ->title('Berhasil Dinonaktifkan')
                            ->body("Pengurus {$this->record->user->name} telah dinonaktifkan.")
                            ->success()
                            ->send();

                        return redirect($this->getResource()::getUrl('index'));
                    } catch (QueryException $e) {
                        if (str_contains($e->getMessage(), 'Duplicate entry')) {
                            Notification::make()
                                ->title('Gagal Menonaktifkan')
                                ->body('Terjadi konflik data. Ada kemungkinan pengurus ini sudah memiliki status yang sama.')
                                ->warning()
                                ->duration(6000)
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Gagal Menonaktifkan')
                                ->body('Terjadi kesalahan database. Silakan refresh halaman dan coba lagi.')
                                ->danger()
                                ->send();
                        }
                        $this->halt();
                    } catch (Exception $e) {
                        Notification::make()
                            ->title('Terjadi Kesalahan')
                            ->body('Gagal menonaktifkan pengurus. Silakan coba lagi.')
                            ->danger()
                            ->send();
                        $this->halt();
                    }
                })
                ->visible(fn(): bool => $this->record->is_aktif),

            Actions\Action::make('aktifkan')
                ->label('Aktifkan Kembali')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Aktifkan Kembali Pengurus')
                ->modalSubheading('Apakah Anda yakin ingin mengaktifkan kembali pengurus ini?')
                ->action(function () {
                    try {
                        // Check if position is already occupied
                        $existingActive = PengurusDesa::where('jabatan', $this->record->jabatan)
                            ->where('is_wakil', $this->record->is_wakil)
                            ->where('is_aktif', true)
                            ->where('id', '!=', $this->record->id)
                            ->exists();

                        if ($existingActive) {
                            Notification::make()
                                ->title('Tidak Dapat Diaktifkan')
                                ->body('Jabatan ini sudah diisi oleh pengurus lain yang masih aktif. Nonaktifkan pengurus yang lama terlebih dahulu.')
                                ->warning()
                                ->duration(8000)
                                ->send();
                            $this->halt();
                            return;
                        }

                        $this->record->update([
                            'is_aktif' => true,
                            'selesai_jabatan' => null,
                            'keterangan' => 'Diaktifkan kembali pada ' . now()->format('d/m/Y H:i')
                        ]);

                        Notification::make()
                            ->title('Berhasil Diaktifkan')
                            ->body("Pengurus {$this->record->user->name} telah diaktifkan kembali.")
                            ->success()
                            ->send();

                        return redirect($this->getResource()::getUrl('index'));
                    } catch (QueryException $e) {
                        if (str_contains($e->getMessage(), 'Duplicate entry')) {
                            Notification::make()
                                ->title('Tidak Dapat Diaktifkan')
                                ->body('Jabatan ini sudah diisi oleh pengurus lain. Silakan periksa data pengurus yang aktif.')
                                ->warning()
                                ->duration(6000)
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Gagal Mengaktifkan')
                                ->body('Terjadi kesalahan database. Silakan coba lagi.')
                                ->danger()
                                ->send();
                        }
                        $this->halt();
                    } catch (Exception $e) {
                        Notification::make()
                            ->title('Terjadi Kesalahan')
                            ->body('Gagal mengaktifkan pengurus. Silakan coba lagi.')
                            ->danger()
                            ->send();
                        $this->halt();
                    }
                })
                ->visible(fn(): bool => !$this->record->is_aktif),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        try {
            if ($data['user_id'] != $this->record->user_id) {
                $hasActivePosition = PengurusDesa::where('user_id', $data['user_id'])
                    ->where('is_aktif', true)
                    ->where('id', '!=', $this->record->id)
                    ->exists();

                if ($hasActivePosition) {
                    Notification::make()
                        ->title('Tidak Dapat Mengubah Pengurus')
                        ->body('Pengurus yang dipilih sudah memiliki jabatan aktif lainnya. Satu orang tidak boleh memiliki lebih dari satu jabatan aktif.')
                        ->warning()
                        ->duration(8000)
                        ->send();
                    $this->halt();
                }
            }

            $conflictExists = PengurusDesa::where('jabatan', $data['jabatan'])
                ->where('is_wakil', $data['is_wakil'])
                ->where('is_aktif', $data['is_aktif'] ?? true)
                ->where('id', '!=', $this->record->id)
                ->exists();

            if ($conflictExists) {
                $jabatanLabel = PengurusDesa::$jabatan_options[$data['jabatan']] ?? $data['jabatan'];
                $jabatanFull = ($data['is_wakil'] ?? false) ? "Wakil {$jabatanLabel}" : $jabatanLabel;

                Notification::make()
                    ->title('Jabatan Sudah Terisi')
                    ->body("Jabatan {$jabatanFull} sudah diisi oleh pengurus lain yang masih aktif. Silakan pilih jabatan lain atau nonaktifkan pengurus yang lama terlebih dahulu.")
                    ->warning()
                    ->duration(8000)
                    ->send();
                $this->halt();
            }

            return $data;
        } catch (Exception $e) {
            Notification::make()
                ->title('Terjadi Kesalahan')
                ->body('Tidak dapat memvalidasi data. Silakan coba lagi.')
                ->danger()
                ->send();
            $this->halt();
        }

        return $data;
    }


    protected function handleRecordUpdate($record, array $data): Model
    {
        try {
            return parent::handleRecordUpdate($record, $data);
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                Notification::make()
                    ->title('Data Konflik')
                    ->body('Terjadi konflik data saat menyimpan. Kemungkinan ada pengurus lain dengan jabatan yang sama sedang diproses bersamaan. Silakan refresh halaman dan coba lagi.')
                    ->warning()
                    ->duration(8000)
                    ->send();
            } elseif (str_contains($e->getMessage(), 'foreign key constraint')) {
                Notification::make()
                    ->title('Data Terkait')
                    ->body('Tidak dapat mengubah data karena terkait dengan data lain di sistem. Silakan hubungi administrator.')
                    ->warning()
                    ->duration(6000)
                    ->send();
            } else {
                Notification::make()
                    ->title('Gagal Menyimpan')
                    ->body('Terjadi kesalahan database saat menyimpan data. Silakan coba lagi.')
                    ->danger()
                    ->send();
            }

            $this->halt();
        } catch (Exception $e) {
            Notification::make()
                ->title('Terjadi Kesalahan')
                ->body('Gagal menyimpan perubahan data pengurus. Silakan coba lagi.')
                ->danger()
                ->send();

            $this->halt();
        }

        // fallback agar tidak error di IDE/Static Analysis (tidak akan dijalankan karena $this->halt)
        return $record;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Berhasil Diperbarui')
            ->body('Data pengurus desa telah berhasil diperbarui.')
            ->duration(4000);
    }
}
