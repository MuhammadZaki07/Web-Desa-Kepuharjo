<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileDesa extends Model
{
    protected $guarded = [];

    public function images(){
        return $this->morphMany(Images::class,'imageable');
    }
}
