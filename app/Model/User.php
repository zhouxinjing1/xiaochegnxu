<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

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
                return ['入驻客户', '<span class="label label-success">入驻客户</span>'];
            case 2:
                return ['授权客户', '<span class="label label-warning">授权客户</span>'];
        }
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = encrypt($value);
    }
}
