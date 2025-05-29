<?php

namespace App\Filament\Resources\PendudukResource\Pages;

use App\Filament\Resources\PendudukResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePenduduk extends CreateRecord
{
    protected static string $resource = PendudukResource::class;

    protected static ?string $title = 'Tambah Data Penduduk';

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data penduduk berhasil ditambahkan!';
    }

    protected function handleRecordCreation(array $data): Model
    {
        $userData = $data['user'] ?? [];
        $userData['role'] = 'penduduk';

        $user = User::create($userData);
        unset($data['user']);
        $data['user_id'] = $user->id;

        return static::getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status_nyawa'] = $data['status_nyawa'] ?? 'hidup';

        return $data;
    }
}
