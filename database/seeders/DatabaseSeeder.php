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
                'role' => 'admin',
                'is_active' => true,
                'phone' => '083846871126',
                'jabatan' => 'super_admin',
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

        $this->createUserWithPenduduk(
            [
                'name' => 'Budi Santoso',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'phone' => '082123456789',
                'jabatan' => 'admin_desa',
            ],
            [
                'nik' => '327102' . rand(100000000, 999999999),
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-05-15',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Desa No.2',
                'RT' => 2,
                'RW' => 2,
                'agama' => 'Islam',
                'status_perkawinan' => 'Menikah',
                'pekerjaan' => 'Admin Desa',
                'pendidikan' => 'S1',
            ]
        );

        $this->createUserWithPenduduk(
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'operator@gmail.com',
                'password' => Hash::make('password'),
                'is_active' => true,
                'role' => 'admin',
                'phone' => '081987654321',
                'jabatan' => 'operator',
            ],
            [
                'nik' => '327103' . rand(100000000, 999999999),
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1990-03-22',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Operasi No.3',
                'RT' => 3,
                'RW' => 3,
                'agama' => 'Islam',
                'status_perkawinan' => 'Belum Menikah',
                'pekerjaan' => 'Operator',
                'pendidikan' => 'D3',
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
