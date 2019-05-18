<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;

use App\Http\Controllers\Common\ReturnJson;
use App\Tool\CurlTool;

class LoginController extends Controller
{
    /**
     * 账号登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            return ReturnJson::response([],'300','查无此账号');
        }

        if (decrypt($user->password) === $request->password) {
            if (empty($user->status)) {
                return ReturnJson::response([],'300','账号已关闭, 请联系管理员');
            }
            return ReturnJson::response($user,'200','成功');
        }
        return ReturnJson::response([],'300','密码错误');
    }

    /**
     *  获取openid
     * @param Request $request
     */
    public function getOpenid(Request $request)
    {
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.config('other.appid').
            '&secret='.config('other.secret').'&js_code='.$request->code.'&grant_type=authorization_code';

        $data = CurlTool::getCurl($url);
        if (!isset($data['openid'])) {
            return ReturnJson::response([],'300',$data['errcode'].'/'.$data['errmsg']);
        }

        $user = User::updateOrCreate(
            ['openid' => $data['openid']],
            [
                'name' => $request->nickName,
                'sex'  => $request->gender,
                'city' => $request->city,
                'img'  => $request->avatarUrl,
                'type' => 2
            ]
        );

        return ReturnJson::response($user,'200','成功');
    }






}
