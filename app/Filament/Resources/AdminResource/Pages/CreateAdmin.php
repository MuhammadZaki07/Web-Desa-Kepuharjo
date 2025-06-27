<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    public function getTitle(): string
    {
        return 'Buat Admin Baru';
    }

    public function getHeading(): string
    {
        return 'Buat Admin Baru';
    }

    public function getSubheading(): ?string
    {
        return 'Pilih penduduk untuk dijadikan admin dan tentukan jabatannya';
    }

    protected function authorizeAccess(): void
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403, 'Only super admin can create new admins.');
        }
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $createdCount = 0;

        DB::transaction(function () use ($data, &$createdCount) {
            foreach ($data['admin_details'] as $detail) {
                $user = User::find($detail['user_id']);

                if ($user && $user->role === 'penduduk') {
                    $user->update([
                        'email' => $detail['email'],
                        'password' => Hash::make($detail['password']),
                        'role' => $this->mapJabatanToRole($detail['role']),
                        'is_active' => true,
                        'email_verified_at' => now(),
                    ]);
                    $createdCount++;
                }
            }
        });

        Notification::make()
            ->title('Admin Created Successfully')
            ->body("Successfully created {$createdCount} admin(s) with their respective positions")
            ->success()
            ->send();

        return new User();
    }

    /**
     * Map jabatan to role for backward compatibility
     */
    private function mapJabatanToRole(string $jabatan): string
    {
        return match ($jabatan) {
            'super_admin' => 'super_admin',
            'admin' => 'admin',
            default => 'admin',
        };
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['admin_details'])) {
            throw new \Exception('No admin details provided');
        }

        foreach ($data['admin_details'] as $detail) {
            if (empty($detail['role'])) {
                throw new \Exception('Jabatan must be selected for all admins');
            }

            if ($detail['role'] === 'super_admin' && Auth::user()->jabatan !== 'super_admin') {
                throw new \Exception('Only super admin can create another super admin');
            }
        }

        return $data;
    }
}
