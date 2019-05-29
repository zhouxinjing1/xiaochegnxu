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

        // 是否支付
        static::addGlobalScope(function(Builder $builder) {
            $builder->where('pay_status',1);
        });
    }

    /**
     * 通过
     * @param $query
     * @return mixed
     */
    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

    /**
     * 推荐
     * @param $query
     * @return mixed
     */
    public function scopeReco($query)
    {
        return $query->where('reco', 1);
    }

    /**
     * 推荐排序
     * @param $query
     * @return mixed
     */
    public function scopeRecommend($query)
    {
        return $query->orderBy('orders', 'desc')->orderBy('price', 'desc')->orderBy('created_at', 'desc');
    }

    /**
     *  免费发布
     */
    public function scopeFree($query)
    {
        return $query->orderBy('orders', 'desc')->orderBy('created_at', 'desc');
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
