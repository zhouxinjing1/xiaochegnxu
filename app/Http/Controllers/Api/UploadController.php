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
        $data = UploadTool::upload_once($request, $request->name);
        if (empty($data)) {
            return ReturnJson::response('300','上传出错!');
        }
        return ReturnJson::response($data);
    }
}
