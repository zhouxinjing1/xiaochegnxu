<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Tool\UploadTool;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\ReturnJson;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $url = UploadTool::upload_once($request, 'name');
        if (empty($url)) {
            return ReturnJson::response('300','上传出错!');
        }

        $data['url']  = $url;
        $data['name'] = $request->user;
        return ReturnJson::response($data);
    }
}
