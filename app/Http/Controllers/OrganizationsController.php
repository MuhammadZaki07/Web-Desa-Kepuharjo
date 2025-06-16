<?php

namespace App\Http\Controllers;

use App\Helpers\ProfileDesa;
use App\Helpers\TimeHelper;
use App\Models\Banner;
use App\Models\Gallery;
use App\Models\Organization;
use App\Services\ArticleService;

class OrganizationsController extends Controller
{
    public function index()
    {
        return $this->renderOrganizationPage(
            type: 'pkk',
            title: 'PKK',
            view: 'pages.pkk'
        );
    }

    public function halamanKarangtaruna()
    {
        return $this->renderOrganizationPage(
            type: 'karang_taruna',
            title: 'Karang Taruna',
            view: 'pages.karangtaruna'
        );
    }

    private function renderOrganizationPage(string $type, string $title, string $view)
    {
        $timeData = $this->getTimeData();
        $headlines = ArticleService::getHeadlines();
        $blogs = ArticleService::getLatestPublishedBlogs();
        $banner = $this->getBanner($type);
        $data = $this->getOrganizationData($type);
        $gallery = $this->getGalleryByType($type);
        $articles = ArticleService::getViralBlogs();
        $ProfileDesa = ProfileDesa::GetProfileDesa();
        $galleryImages = $gallery->pluck('path')->toArray();
        $dataFormatted = [
            'content' => $data->content ?? $this->getDummyData($type)['content'],
            'structure' => $data->structure ?? $this->getDummyData($type)['structure'],
            'programs' => $data->programs ?? $this->getDummyData($type)['programs'],
            'activities' => $data->activities ?? $this->getDummyData($type)['activities'],
            'contact_phone' => $data->contact_phone ?? $this->getDummyData($type)['contact_phone'],
            'gallery' => $galleryImages,
            'updated_at' => optional($data)->updated_at?->translatedFormat('d F Y') ?? $this->getDummyData($type)['updated_at'],
        ];

        return view($view, array_merge(
            $timeData,
            [
                'title' => $title,
                'headlines' => $headlines,
                'blogs' => $blogs,
                'banner' => $banner,
                'ProfileDesa' => $ProfileDesa,
                'articles' => $articles,
                'bannerImagePath' => $this->getBannerImagePath($banner),
                'data' => $dataFormatted,
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

    private function getGalleryByType($type)
    {
        return Gallery::where('type', $type)->get();
    }

    private function getOrganizationData($type)
    {
        return Organization::where('type', $type)->first();
    }

    private function getDummyData($type)
    {
        return match ($type) {
            'pkk' => [
                'content' => 'Pemberdayaan dan Kesejahteraan Keluarga (PKK) adalah ...',
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
                    'Pelatihan keterampilan ibu rumah tangga',
                    'Pembinaan remaja melalui kelas remaja sehat',
                    'Pengelolaan kebun PKK dan bank sampah',
                    'Arisan dan pertemuan bulanan antar kader',
                ],
                'contact_phone' => '0812-3456-7890',
                'updated_at' => '4 Mei 2025',
            ],
            'karang_taruna' => [
                'content' => 'Karang Taruna adalah organisasi kepemudaan yang ...',
                'structure' => [
                    ['jabatan' => 'Ketua', 'nama' => 'Bapak Agus Santoso'],
                    ['jabatan' => 'Wakil Ketua', 'nama' => 'Bapak Doni Pratama'],
                    ['jabatan' => 'Sekretaris', 'nama' => 'Ibu Fitri Yani'],
                    ['jabatan' => 'Bendahara', 'nama' => 'Ibu Riska Dewi'],
                ],
                'programs' => [
                    'Pelatihan Wirausaha Muda',
                    'Kegiatan Olahraga Pemuda',
                    'Pengembangan Kreativitas dan Seni',
                    'Penyuluhan Bahaya Narkoba',
                ],
                'activities' => [
                    'Turnamen sepak bola antar dusun',
                    'Pelatihan desain grafis untuk pemuda',
                    'Pertunjukan seni budaya lokal',
                    'Bakti sosial ke panti asuhan',
                ],
                'contact_phone' => '0822-1122-3344',
                'updated_at' => '10 Mei 2025',
            ],
            default => [],
        };
    }
}
