<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShiftImage extends Model
{
    public function getUrlAttribute($url)
    {
        return json_decode($url, true);
    }
}
