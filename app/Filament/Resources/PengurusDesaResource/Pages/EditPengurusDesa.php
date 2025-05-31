<?php

namespace App\Filament\Resources\PengurusDesaResource\Pages;

use App\Filament\Resources\PengurusDesaResource;
use App\Models\PengurusDesa;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPengurusDesa extends EditRecord
{
    protected static string $resource = PengurusDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus Pengurus')
                ->modalSubheading('Apakah Anda yakin ingin menghapus data pengurus ini?'),

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
                    $this->record->nonAktifkan($data['keterangan']);

                    Notification::make()
                        ->title('Berhasil')
                        ->body("Pengurus {$this->record->user->name} telah dinonaktifkan.")
                        ->success()
                        ->send();

                    return redirect($this->getResource()::getUrl('index'));
                })
                ->visible(fn (): bool => $this->record->is_aktif),

            Actions\Action::make('aktifkan')
                ->label('Aktifkan Kembali')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update([
                        'is_aktif' => true,
                        'selesai_jabatan' => null,
                        'keterangan' => 'Diaktifkan kembali pada ' . now()->format('d/m/Y H:i')
                    ]);

                    Notification::make()
                        ->title('Berhasil')
                        ->body("Pengurus {$this->record->user->name} telah diaktifkan kembali.")
                        ->success()
                        ->send();
                })
                ->visible(fn (): bool => !$this->record->is_aktif),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Validate unique position before update (exclude current record)
        if (!PengurusDesa::validateJabatanUnik($data['jabatan'], $data['is_wakil'], $this->record->user_id)) {
            Notification::make()
                ->title('Gagal Mengupdate Pengurus')
                ->body('Jabatan ini sudah diisi oleh pengurus lain yang masih aktif.')
                ->danger()
                ->send();

            $this->halt();
        }

        return $data;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Pengurus Berhasil Diperbarui')
            ->body('Data pengurus desa telah berhasil diperbarui.');
    }
}
