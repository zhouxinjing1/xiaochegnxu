<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\User;
use Illuminate\Database\Eloquent\Builder;

class Good extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(function(Builder $builder) {
            $builder->where('pay_status',1);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTransmissionAttribute ($value)
    {
        switch ($value) {
            case 1:
                return '手动变速箱';
            case 2:
                return '自动变速箱';
            case 3:
                return '手自一体';
            case 4:
                return '无极变速箱';
            case 5:
                return 'DSG变速箱';
            case 6:
                return '序列变速箱';
        }
    }

}
