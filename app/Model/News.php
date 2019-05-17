<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class News extends Model
{
    protected $table = 'news';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(function(Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }
}
