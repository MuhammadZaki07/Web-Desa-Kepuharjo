<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BannerSeeder::class,
            ProfileDesaSeeder::class,
            OrganizationSeeder::class,
        ]);

        $this->createUserWithPenduduk(
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'is_active' => true,
                'phone' => '083846871126',
            ],
            [
                'nik' => '327101' . rand(100000000, 999999999),
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1980-01-01',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Raya No.1',
                'RT' => 1,
                'RW' => 1,
                'agama' => 'Islam',
                'status_perkawinan' => 'Menikah',
                'pekerjaan' => 'PNS',
                'pendidikan' => 'S2',
            ]
        );
    }

    private function createUserWithPenduduk(array $userData, array $pendudukData): void
    {
        $user = User::create($userData);

        Penduduk::create(array_merge($pendudukData, [
            'user_id' => $user->id,
            'status_nyawa' => 'hidup',
        ]));
    }
}
