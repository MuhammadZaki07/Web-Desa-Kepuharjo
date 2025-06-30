<?php

namespace App\Http\Controllers;

use App\Models\PengurusDesa;
use App\Services\BannersService;
use Illuminate\Support\Facades\Storage;


class PemerintahController extends Controller
{

    protected BannersService $bannersService;

    public function __construct(BannersService $bannersService)
    {
        $this->bannersService = $bannersService;
    }

    public function index()
    {
        $banner = $this->bannersService->getBanner("pemerintahan");
        $imagesPathBanner = $this->bannersService->getBannerImagePath($banner);
        $kepalaDesa = PengurusDesa::where('jabatan', 'kepala_desa')->with('user')->first();
        $namaKepalaDesa = $kepalaDesa->user->name ?? '-';
        $pengurusDesa = PengurusDesa::where('is_aktif', true)->get();
        $pengurus = [];

        foreach ($pengurusDesa as $data) {
            $pengurus[] = [
                "name" => $data->user->name,
                "jabatan" => str_replace("_", " ", $data->jabatan),
                "foto" => $this->getImage($data->user->photo)
            ];
        }

        return view('pages.pemerintahan', compact('namaKepalaDesa', 'banner', 'imagesPathBanner', 'kepalaDesa', 'pengurus'));
    }

    private function getImage($data): string
    {
        if ($data && Storage::disk('public')->exists($data)) {
            return asset('storage/' . $data);
        }

        return asset('assets/images/user-unkown.png');
    }
}
