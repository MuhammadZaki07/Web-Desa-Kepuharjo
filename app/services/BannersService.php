<?php

namespace App\Services;

use App\Models\Banner;

class BannersService
{
    public function getBanner($type)
    {
        return Banner::where('type', $type)->first();
    }

    public function getBannerImagePath($banner)
    {
        return $banner && $banner->images
            ? asset('storage/' . $banner->images)
            : asset('assets/banners/preview-1.png');
    }
}
