<?php

namespace App\Http\Controllers;

use App\Helpers\ProfileDesa;
use App\Helpers\TimeHelper;
use App\Models\Banner;
use App\Models\PengurusDesa;
use App\Services\ArticleService;
use App\Services\BannersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class PemerintahController extends Controller
{

    protected BannersService $bannersService;

    public function __construct(BannersService $bannersService)
    {
        $this->bannersService = $bannersService;
    }

    public function index()
    {
        $ProfileDesa = ProfileDesa::GetProfileDesa();
        $Time = TimeHelper::getFormattedTime();
        $jam = $Time['jam'];
        $tanggal = $Time['tanggal'];
        $format = $Time['format'];
        $banner = $this->bannersService->getBanner("pemerintahan");
        $imagesPathBanner = $this->bannersService->getBannerImagePath($banner);
        $kepalaDesa = PengurusDesa::where('jabatan', 'kepala_desa')->with('user')->first();
        $kepalaDesa = $kepalaDesa->user->name ?? '-';
        $pengurusDesa = PengurusDesa::where('is_aktif', true)->get();
        $headlines = ArticleService::getHeadlines();
        $pengurus = [];

        foreach ($pengurusDesa as $data) {
            $pengurus[] = [
                "name" => $data->user->name,
                "jabatan" => str_replace("_", " ", $data->jabatan),
                "foto" => $this->getImage($data->user->photo)
            ];
        }

        return view('pages.pemerintahan', compact('ProfileDesa', 'jam', 'tanggal', 'format', 'headlines', 'banner', 'imagesPathBanner', 'kepalaDesa', 'pengurus'));
    }

    private function getImage($data): string
    {
        if ($data && Storage::disk('public')->exists($data)) {
            return asset('storage/' . $data);
        }

        return asset('assets/images/user-unkown.png');
    }
}
