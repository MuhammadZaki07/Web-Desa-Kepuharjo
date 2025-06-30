<?php

namespace App\Http\Controllers;

use App\Helpers\ProfileDesa;
use App\Helpers\TimeHelper;
use App\Models\Penduduk;
use App\Services\ArticleService;
use Illuminate\Support\Facades\DB;

class ProfileDataPendudukController extends Controller
{
    public function index()
    {
        $laki = Penduduk::where('jenis_kelamin', 'L')->count();
        $perempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $total = $laki + $perempuan;

        $dataPenduduk = [
            ['jumlah' => $laki, 'label' => 'Kelamin Laki-Laki', 'warna' => 'green', 'icon' => 'bi-gender-male'],
            ['jumlah' => $perempuan, 'label' => 'Kelamin Perempuan', 'warna' => 'red', 'icon' => 'bi-gender-female'],
            ['jumlah' => $total, 'label' => 'Total Penduduk Desa', 'warna' => 'blue', 'icon' => 'bi-gender-ambiguous'],
        ];

        $chartData = Penduduk::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('SUM(CASE WHEN jenis_kelamin = "L" THEN 1 ELSE 0 END) as laki'),
            DB::raw('SUM(CASE WHEN jenis_kelamin = "P" THEN 1 ELSE 0 END) as perempuan')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $series1Data = array_fill(0, 12, 0);
        $series2Data = array_fill(0, 12, 0);

        foreach ($chartData as $data) {
            $series1Data[$data->bulan - 1] = (int) $data->laki;
            $series2Data[$data->bulan - 1] = (int) $data->perempuan;
        }
        
        $viralBlogs = ArticleService::getViralBlogs(5);
        $title = 'Profile Data Penduduk';

        return view('pages.profile-data-penduduk', compact(
            'viralBlogs',
            'dataPenduduk',
            'title',
            'series1Data',
            'series2Data',
            'categories'
        ));
    }
}
