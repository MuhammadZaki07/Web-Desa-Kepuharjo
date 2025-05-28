<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use App\Models\Admin;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['user'] = [
            'name' => $this->record->user->name,
            'email' => $this->record->user->email,
            'phone' => $this->record->user->phone,
            'jabatan' => $this->record->user->jabatan,
            'photo' => $this->record->user->photo,
        ];

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $userData = $data['user'] ?? [];
        $adminData = array_diff_key($data, ['user' => null, 'form_mode' => null]);

        if (!empty($userData)) {
            $record->user->update($userData);
        }

        $record->update($adminData);

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(function () {
                    return Auth::user() && Auth::user()->jabatan === 'super_admin';
                })
                ->action(function () {
                    $record = $this->record;
                    $totalActiveAdmins = Admin::whereHas('user', function ($query) {
                        $query->where('is_active', true);
                    })->count();
                    if ($record->is_active && $totalActiveAdmins <= 1) {
                        Notification::make()
                            ->title('Gagal Menghapus')
                            ->body('Tidak dapat menghapus admin terakhir yang aktif. Minimal harus ada 1 admin aktif untuk mengelola sistem.')
                            ->danger()
                            ->send();
                        return false;
                    }
                    $totalAdmins = Admin::count();
                    if ($totalAdmins <= 1) {
                        Notification::make()
                            ->title('Gagal Menghapus')
                            ->body('Tidak dapat menghapus admin terakhir. Sistem membutuhkan minimal 1 admin.')
                            ->danger()
                            ->send();
                        return false;
                    }
                    $record->delete();

                    Notification::make()
                        ->title('Berhasil')
                        ->body('Admin berhasil dihapus.')
                        ->success()
                        ->send();
                    return redirect()->to(AdminResource::getUrl('index'));
                })
                ->requiresConfirmation()
                ->modalHeading('Hapus Admin')
                ->modalDescription('Apakah Anda yakin ingin menghapus admin ini? Tindakan ini tidak dapat dibatalkan.')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->color('danger')
                ->icon('heroicon-o-trash'),
        ];
    }
}
