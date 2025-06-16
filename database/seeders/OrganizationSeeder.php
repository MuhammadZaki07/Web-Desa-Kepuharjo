<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        Organization::updateOrCreate(
            ['type' => 'pkk'],
            [
                'content' => 'PKK adalah gerakan nasional dalam pembangunan masyarakat yang tumbuh dari bawah, dengan wanita sebagai penggerak utama.',
                'structure' => json_encode([
                    ['jabatan' => 'Ketua', 'nama' => 'Ibu Sri Wahyuni'],
                    ['jabatan' => 'Wakil Ketua', 'nama' => 'Ibu Rina Astuti'],
                    ['jabatan' => 'Sekretaris', 'nama' => 'Ibu Lestari'],
                    ['jabatan' => 'Bendahara', 'nama' => 'Ibu Wati'],
                ]),
                'programs' => json_encode([
                    'Pendidikan dan Keterampilan',
                    'Kesehatan',
                    'Pengembangan Kehidupan Berkoperasi',
                ]),
                'activities' => json_encode([
                    'Posyandu Balita dan Lansia',
                    'Pelatihan menjahit',
                    'Kelas remaja sehat',
                ]),
                'contact_phone' => '081234567890',
            ]
        );

        Organization::updateOrCreate(
            ['type' => 'karang_taruna'],
            [
                'content' => 'Karang Taruna adalah wadah pengembangan generasi muda di bidang kesejahteraan sosial yang tumbuh atas dasar kesadaran dan rasa tanggung jawab sosial.',
                'structure' => json_encode([
                    ['jabatan' => 'Ketua', 'nama' => 'Budi Santoso'],
                    ['jabatan' => 'Wakil Ketua', 'nama' => 'Rian Hidayat'],
                    ['jabatan' => 'Sekretaris', 'nama' => 'Siti Aminah'],
                    ['jabatan' => 'Bendahara', 'nama' => 'Joko Prasetyo'],
                ]),
                'programs' => json_encode([
                    'Pelatihan kewirausahaan',
                    'Pendidikan karakter pemuda',
                    'Gotong royong dan sosial masyarakat',
                ]),
                'activities' => json_encode([
                    'Bakti sosial dan donor darah',
                    'Turnamen olahraga antar RT',
                    'Pengajian pemuda rutin',
                ]),
                'contact_phone' => '082345678901',
            ]
        );
    }
}
