<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use App\Models\Admin;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['form_mode']) && $data['form_mode'] === 'promote_existing') {
            if (isset($data['existing_user_id']) && $data['existing_user_id']) {
                $user = User::find($data['existing_user_id']);
                if ($user) {
                    $user->update([
                        'email' => $data['admin_email'],
                        'password' => Hash::make($data['admin_password']),
                        'jabatan' => $data['new_jabatan'],
                        'photo' => $data['admin_photo'] ?? $user->photo,
                        'role' => 'admin',
                    ]);

                    $data['user_id'] = $user->id;
                }
            }
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        if (isset($data['form_mode']) && $data['form_mode'] === 'create_new') {
            if (isset($data['user']) && is_array($data['user'])) {
                $user = User::create([
                    'name' => $data['user']['name'],
                    'email' => $data['user']['email'],
                    'phone' => $data['user']['phone'] ?? null,
                    'password' => $data['user']['password'],
                    'jabatan' => $data['user']['jabatan'],
                    'photo' => $data['user']['photo'] ?? null,
                    'role' => 'admin',
                ]);

                return Admin::create([
                    'user_id' => $user->id,
                    'position' => $data['position'] ?? null,
                    'is_active' => $data['is_active'] ?? true,
                ]);
            }
        }

        if (isset($data['form_mode']) && $data['form_mode'] === 'promote_existing') {
            if (isset($data['user_id'])) {
                return Admin::create([
                    'user_id' => $data['user_id'],
                    'position' => $data['position'] ?? null,
                    'is_active' => $data['is_active'] ?? true,
                ]);
            }
        }

        throw new \Exception('Invalid form data: Unable to determine creation mode');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
