<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShiftImage extends Model
{
    public function getTypeAttribute($type)
    {
        switch ($type) {
            case 1:
                return ['首页', '<span class="label label-warning">首页</span>'];
            case 2:
                return ['卖车', '<span class="label label-danger">卖车</span>'];
            case 3:
                return ['买车', '<span class="label label-success">买车</span>'];
        }
    }

    public function getUrlAttribute($url)
    {
        return json_decode($url, true);
    }
}
