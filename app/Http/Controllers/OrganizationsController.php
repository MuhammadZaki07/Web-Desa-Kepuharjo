<?php

namespace App\Http\Controllers;

use App\Helpers\TimeHelper;
use App\Models\Banner;
use App\Models\Gallery;
use App\Models\Organization;
use App\Services\ArticleService;

class OrganizationsController extends Controller
{
    public function index()
    {
        $timeData = $this->getTimeData();
        $headlines = ArticleService::getHeadlines();
        $blogs = ArticleService::getLatestPublishedBlogs();
        $banner = $this->getBanner('PKK');
        $dataPkk = $this->getPkkData();
        $gallery = $this->getGalleryTypePkk();

        $dummyPkk = [
            'content' => 'Pemberdayaan dan Kesejahteraan Keluarga (PKK) adalah gerakan nasional dalam pembangunan masyarakat yang tumbuh dari bawah, dengan wanita sebagai penggerak utamanya. Di Desa Kepuharjo, PKK menjadi mitra strategis pemerintah desa dalam mendukung pembangunan, khususnya dalam bidang keluarga, kesehatan, pendidikan, ekonomi, dan lingkungan.',
            'structure' => [
                ['jabatan' => 'Ketua', 'nama' => 'Ibu Sri Wahyuni'],
                ['jabatan' => 'Wakil Ketua', 'nama' => 'Ibu Rina Astuti'],
                ['jabatan' => 'Sekretaris', 'nama' => 'Ibu Lestari'],
                ['jabatan' => 'Bendahara', 'nama' => 'Ibu Wati'],
                ['jabatan' => 'Koordinator Pokja I', 'nama' => 'Ibu Dewi Sari'],
                ['jabatan' => 'Koordinator Pokja II', 'nama' => 'Ibu Nina Kartika'],
                ['jabatan' => 'Koordinator Pokja III', 'nama' => 'Ibu Erna Sulastri'],
                ['jabatan' => 'Koordinator Pokja IV', 'nama' => 'Ibu Yuni Rahayu'],
            ],
            'programs' => [
                'Penghayatan dan Pengamalan Pancasila',
                'Gotong Royong',
                'Pangan',
                'Sandang',
                'Perumahan dan Tata Laksana Rumah Tangga',
                'Pendidikan dan Keterampilan',
                'Kesehatan',
                'Pengembangan Kehidupan Berkoperasi',
                'Kelestarian Lingkungan Hidup',
                'Perencanaan Sehat',
            ],
            'activities' => [
                'Posyandu Balita dan Lansia setiap bulan',
                'Pelatihan keterampilan ibu rumah tangga (menjahit, memasak, dll)',
                'Pembinaan remaja melalui kelas remaja sehat',
                'Pengelolaan kebun PKK dan bank sampah',
                'Arisan dan pertemuan bulanan antar kader',
            ],
            'contact_phone' => '0812-3456-7890',
            'updated_at' => '4 Mei 2025',
        ];

        $galleryImages = $gallery->map(function ($item) {
            return $item->path;
        })->toArray();

        $dataPkk = $dataPkk ? [
            'content' => $dataPkk->content ?? $dummyPkk['content'],
            'structure' => $dataPkk->structure ?? $dummyPkk['structure'],
            'programs' => $dataPkk->programs ?? $dummyPkk['programs'],
            'activities' => $dataPkk->activities ?? $dummyPkk['activities'],
            'contact_phone' => $dataPkk->contact_phone ?? $dummyPkk['contact_phone'],
            'gallery' =>  $galleryImages,
            'updated_at' => $dataPkk->updated_at->translatedFormat('d F Y') ?? $dummyPkk['updated_at'],
        ] : $dummyPkk;

        return view('pages.pkk', array_merge(
            $timeData,
            [
                'title' => 'PKK',
                'headlines' => $headlines,
                'blogs' => $blogs,
                'banner' => $banner,
                'bannerImagePath' => $this->getBannerImagePath($banner),
                'data' => $dataPkk,
            ]
        ));
    }

    private function getTimeData()
    {
        $time = TimeHelper::getFormattedTime();
        return [
            'tanggal' => $time['tanggal'],
            'jam' => $time['jam'],
            'format' => $time['format'],
        ];
    }

    private function getBanner($type)
    {
        return Banner::where('type', $type)->first();
    }

    private function getBannerImagePath($banner)
    {
        return $banner && $banner->images
            ? asset('storage/' . $banner->images)
            : asset('assets/banners/preview-1.png');
    }

    private function getGalleryTypePkk()
    {
        return Gallery::where('type', 'pkk')->get();
    }

    private function getPkkData()
    {
        return Organization::where('type', 'pkk')->first();
    }
}
