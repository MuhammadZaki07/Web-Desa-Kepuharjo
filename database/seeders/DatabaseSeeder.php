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
        $sourcePath = public_path('assets/images/profile.jpg');
        $storagePath = 'photo/profile.png';
        Storage::disk('public')->put($storagePath, file_get_contents($sourcePath));

        $this->call(BannerSeeder::class);
        $this->call(ProfileDesaSeeder::class);

        // ============ ADMIN USERS ============

        // 1. Super Admin
        $superAdmin = User::create([
            'photo' => $storagePath,
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

        // 2. Admin Desa (existing)
        $adminDesa = User::create([
            'photo' => $storagePath,
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

        // 3. Operator
        $operator = User::create([
            'photo' => $storagePath,
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

        // ============ PENDUDUK USERS (untuk testing promote) ============

        // Penduduk 1 - Calon Admin
        $penduduk1 = User::create([
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad.wijaya@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'penduduk',
            'phone' => '085123456789',
            'jabatan' => 'normal',
        ]);

        Penduduk::create([
            'user_id' => $penduduk1->id,
            'nik' => '3273010101850001',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1985-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Merdeka No. 123, RT 01/RW 02',
            'RT' => 1,
            'RW' => 2,
            'agama' => 'Islam',
            'status_perkawinan' => 'Kawin',
            'pekerjaan' => 'Pegawai Swasta',
            'pendidikan' => 'S1',
            'status_nyawa' => 'hidup',
            'catatan_penduduk' => 'Calon admin desa yang potensial'
        ]);

        // Penduduk 2 - Calon Admin
        $penduduk2 = User::create([
            'name' => 'Rina Marlina',
            'email' => 'rina.marlina@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'penduduk',
            'phone' => '086234567890',
            'jabatan' => 'normal',
        ]);

        Penduduk::create([
            'user_id' => $penduduk2->id,
            'nik' => '3273010202900002',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1990-02-02',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Sudirman No. 456, RT 03/RW 04',
            'RT' => 3,
            'RW' => 4,
            'agama' => 'Islam',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'Guru',
            'pendidikan' => 'S1',
            'status_nyawa' => 'hidup',
            'catatan_penduduk' => 'Memiliki pengalaman administrasi'
        ]);

        // Penduduk 3 - Calon Admin
        $penduduk3 = User::create([
            'name' => 'Joko Susilo',
            'email' => 'joko.susilo@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'penduduk',
            'phone' => '087345678901',
            'jabatan' => 'normal',
        ]);

        Penduduk::create([
            'user_id' => $penduduk3->id,
            'nik' => '3273010303880003',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1988-03-03',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Gatot Subroto No. 789, RT 05/RW 06',
            'RT' => 5,
            'RW' => 6,
            'agama' => 'Islam',
            'status_perkawinan' => 'Kawin',
            'pekerjaan' => 'Wiraswasta',
            'pendidikan' => 'SMA',
            'status_nyawa' => 'hidup',
            'catatan_penduduk' => 'Aktif di kegiatan RT/RW'
        ]);

        // Penduduk 4 - Calon Admin
        $penduduk4 = User::create([
            'name' => 'Maria Magdalena',
            'email' => 'maria.magdalena@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'penduduk',
            'phone' => '088456789012',
            'jabatan' => 'normal',
        ]);

        Penduduk::create([
            'user_id' => $penduduk4->id,
            'nik' => '3273010404920004',
            'tempat_lahir' => 'Medan',
            'tanggal_lahir' => '1992-04-04',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Ahmad Yani No. 321, RT 07/RW 08',
            'RT' => 7,
            'RW' => 8,
            'agama' => 'Kristen',
            'status_perkawinan' => 'Kawin',
            'pekerjaan' => 'Perawat',
            'pendidikan' => 'D3',
            'status_nyawa' => 'hidup',
            'catatan_penduduk' => 'Berpengalaman di bidang kesehatan'
        ]);

        // Penduduk 5 - Calon Admin
        $penduduk5 = User::create([
            'name' => 'Bambang Pamungkas',
            'email' => 'bambang.pamungkas@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'penduduk',
            'phone' => '089567890123',
            'jabatan' => 'normal',
        ]);

        Penduduk::create([
            'user_id' => $penduduk5->id,
            'nik' => '3273010505870005',
            'tempat_lahir' => 'Yogyakarta',
            'tanggal_lahir' => '1987-05-05',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Diponegoro No. 654, RT 09/RW 10',
            'RT' => 9,
            'RW' => 10,
            'agama' => 'Islam',
            'status_perkawinan' => 'Kawin',
            'pekerjaan' => 'PNS',
            'pendidikan' => 'S2',
            'status_nyawa' => 'hidup',
            'catatan_penduduk' => 'Memiliki pengalaman di pemerintahan'
        ]);

        // ============ PENDUDUK BIASA (tidak akan dijadikan admin) ============

        // Penduduk Biasa 1
        $pendudukBiasa1 = User::create([
            'name' => 'Sari Dewi',
            'email' => 'sari.dewi@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'penduduk',
            'phone' => '081111111111',
            'jabatan' => 'normal',
        ]);

        Penduduk::create([
            'user_id' => $pendudukBiasa1->id,
            'nik' => '3273010606950006',
            'tempat_lahir' => 'Solo',
            'tanggal_lahir' => '1995-06-06',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Pahlawan No. 111, RT 11/RW 12',
            'RT' => 11,
            'RW' => 12,
            'agama' => 'Islam',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'Mahasiswa',
            'pendidikan' => 'SMA',
            'status_nyawa' => 'hidup',
        ]);

        // Penduduk Biasa 2
        $pendudukBiasa2 = User::create([
            'name' => 'Agus Salim',
            'email' => 'agus.salim@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'penduduk',
            'phone' => '082222222222',
            'jabatan' => 'normal',
        ]);

        Penduduk::create([
            'user_id' => $pendudukBiasa2->id,
            'nik' => '3273010707800007',
            'tempat_lahir' => 'Malang',
            'tanggal_lahir' => '1980-07-07',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Veteran No. 222, RT 13/RW 14',
            'RT' => 13,
            'RW' => 14,
            'agama' => 'Islam',
            'status_perkawinan' => 'Kawin',
            'pekerjaan' => 'Petani',
            'pendidikan' => 'SD',
            'status_nyawa' => 'hidup',
        ]);

        // Penduduk Biasa 3
        $pendudukBiasa3 = User::create([
            'name' => 'Lestari Indah',
            'email' => 'lestari.indah@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'penduduk',
            'phone' => '083333333333',
            'jabatan' => 'normal',
        ]);

        Penduduk::create([
            'user_id' => $pendudukBiasa3->id,
            'nik' => '3273010808930008',
            'tempat_lahir' => 'Semarang',
            'tanggal_lahir' => '1993-08-08',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Kartini No. 333, RT 15/RW 16',
            'RT' => 15,
            'RW' => 16,
            'agama' => 'Islam',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'Karyawan Toko',
            'pendidikan' => 'SMP',
            'status_nyawa' => 'hidup',
        ]);
    }
}
