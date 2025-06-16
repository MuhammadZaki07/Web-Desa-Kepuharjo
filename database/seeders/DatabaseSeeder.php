<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BannerSeeder::class);
        $this->call(ProfileDesaSeeder::class);
        $this->call(OrganizationSeeder::class);



        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'phone' => '083846871126',
            'jabatan' => 'super_admin',
        ]);

        Admin::create([
            'user_id' => $superAdmin->id,
            'is_active' => true,
            'position' => 'Super Administrator'
        ]);

        $adminDesa = User::create([
            'name' => 'Budi Santoso',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'phone' => '082123456789',
            'jabatan' => 'admin_desa',
        ]);

        Admin::create([
            'user_id' => $adminDesa->id,
            'is_active' => true,
            'position' => 'Kepala Desa'
        ]);

        $operator = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'phone' => '081987654321',
            'jabatan' => 'operator',
        ]);

        Admin::create([
            'user_id' => $operator->id,
            'is_active' => true,
            'position' => 'Operator Data'
        ]);
    }
}
