<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Good;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password', 'openid',
    ];


    public function getTypeAttribute($type)
    {
        switch ($type) {
            case 1:
                return ['入驻客户', '<span class="label label-success">入驻客户</span>', 1];
            case 2:
                return ['授权客户', '<span class="label label-warning">授权客户</span>', 2];
        }
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = encrypt($value);
    }


    public function good()
    {
        return $this->hasOne(Good::class);
    }
}
