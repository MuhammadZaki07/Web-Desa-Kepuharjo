<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourcePath = public_path('assets/logo/Logo_Kabupaten_Malang.png');
        $storagePath = 'logos/Logo_Kabupaten_Malang.png';
        Storage::disk('public')->put($storagePath, file_get_contents($sourcePath));

        DB::table('profile_desas')->insert([
            'name' => 'Desa kepuharjo',
            'logo_desa' => $storagePath,
            'email' => 'kepuharjo@gmail.com',
            'no_tlp' => '083846871126'
        ]);

        DB::table('sosial_media')->insert([
            [
                'platform' => 'whatsapp',
                'url' => 'https://wa.me/6282112345678',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'platform' => 'instagram',
                'url' => 'https://instagram.com/desakepuharjo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'platform' => 'facebook',
                'url' => 'https://facebook.com/desakepuharjo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'platform' => 'youtube',
                'url' => 'https://youtube.com/desakepuharjo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'platform' => 'tiktok',
                'url' => 'https://tiktok.com/desakepuharjo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'platform' => 'threeads',
                'url' => 'https://threeads.com/Kepuharjo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
