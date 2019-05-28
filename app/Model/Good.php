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


    public function getTypeAttribute($value)
    {
        switch ($value) {
            case 1:
                return '拍卖';
            case 0:
                return '免费发布';
        }
    }

}
