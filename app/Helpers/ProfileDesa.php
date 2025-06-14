<?php

namespace App\Helpers;

use App\Models\ProfileDesa as ModelsProfileDesa;

class ProfileDesa {
    public static function GetProfileDesa(){
        $ProfileDesa = ModelsProfileDesa::first();
        return [
            'ProfileDesa' => $ProfileDesa
        ];
    }
}
