<?php

namespace App\Filament\Resources\PendudukResource\Pages;

use App\Filament\Resources\PendudukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPenduduk extends EditRecord
{
    protected static string $resource = PendudukResource::class;

    protected static ?string $title = 'Edit Data Penduduk';

    protected function getUpdatedNotificationTitle(): ?string
    {
        return 'Data penduduk berhasil diperbarui!';
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['user'] = [
            'name' => $this->record->user->name,
            'email' => $this->record->user->email,
            'phone' => $this->record->user->phone,
            'photo' => $this->record->user->photo,
        ];

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $userData = $data['user'] ?? [];
        if (!empty($userData)) {
            if (empty($userData['password'])) {
                unset($userData['password']);
            }
            $record->user->update($userData);
        }
        unset($data['user']);
        $record->update($data);

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_profile')
                ->label('Lihat Profil')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->url(fn() => PendudukResource::getUrl('index')),

            Actions\Action::make('toggle_status')
                ->label(fn() => $this->record->status_nyawa === 'hidup' ? 'Tandai Meninggal' : 'Tandai Hidup')
                ->icon(fn() => $this->record->status_nyawa === 'hidup' ? 'heroicon-o-x-circle' : 'heroicon-o-heart')
                ->color(fn() => $this->record->status_nyawa === 'hidup' ? 'danger' : 'success')
                ->action(function () {
                    $this->record->update([
                        'status_nyawa' => $this->record->status_nyawa === 'hidup' ? 'meninggal' : 'hidup'
                    ]);
                    $this->refreshFormData(['status_nyawa']);
                })
                ->requiresConfirmation()
                ->modalDescription('Apakah Anda yakin ingin mengubah status hidup penduduk ini?'),

            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus Data Penduduk')
                ->modalDescription('Apakah Anda yakin ingin menghapus data penduduk ini? Data yang sudah dihapus tidak dapat dikembalikan.')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
