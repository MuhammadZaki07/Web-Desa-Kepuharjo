<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['beranda', 'gallery', 'pemerintahan', 'sejarah', 'pkk', 'karang_taruna'];

        foreach ($types as $type) {
            $isSejarah = $type === 'sejarah';

            DB::table('banners')->insert([
                'title' => json_encode(['Banner ' . ucfirst($type)]),

                'title_sejarah' => $isSejarah
                    ? json_encode([
                        'Judul Gambar 1',
                        'Judul Gambar 2',
                        'Judul Gambar 3',
                        'Judul Gambar 4',
                        'Judul Gambar 5',
                    ])
                    : null,

                'description' => 'Ini adalah deskripsi untuk banner ' . $type,
                'type' => $type,
                'images' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
