<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;

use App\Http\Controllers\Common\ReturnJson;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            return ReturnJson::response($user,'300','查无此账号');
        }

        if (decrypt($user->password) === $request->password) {

            if (empty($user->status)) {
                return ReturnJson::response($user,'300','账号已关闭, 请联系管理员');
            }

            return ReturnJson::response($user,'200','成功');
        }

        return ReturnJson::response($user,'300','密码错误');
    }
}
