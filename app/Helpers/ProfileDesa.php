<?php

namespace App\Helpers;

use App\Models\ProfileDesa as ModelsProfileDesa;

class ProfileDesa
{
    public static function GetProfileDesa()
    {
        return cache()->remember('profile_desa', 3600, function () {
            return ModelsProfileDesa::first();
        });
    }
}
