<?php

namespace App\Http\Controllers;

use App\Helpers\ProfileDesa;
use App\Helpers\TimeHelper;
use App\Models\Banner;
use App\Services\ArticleService;
use App\Services\BannersService;
use Illuminate\Http\Request;

class PemerintahController extends Controller
{

    protected BannersService $bannersService;

    public function __construct(BannersService $bannersService){
        $this->bannersService = $bannersService;
    }

    public function index(){
        $ProfileDesa = ProfileDesa::GetProfileDesa();
        $Time = TimeHelper::getFormattedTime();
        $jam = $Time['jam'];
        $tanggal = $Time['tanggal'];
        $format = $Time['format'];
        $banner = $this->bannersService->getBanner("pemerintahan");
        $imagesPathBanner = $this->bannersService->getBannerImagePath($banner);

        $headlines = ArticleService::getHeadlines();
        return view('pages.pemerintahan', compact('ProfileDesa','jam','tanggal','format','headlines','banner','imagesPathBanner'));
    }
}
