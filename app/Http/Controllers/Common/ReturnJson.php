<?php

namespace App\Http\Controllers\Common;

trait ReturnJson
{
    public static function response($data, $code = 200, $message = '成功')
    {
        return response()->json(['code' => $code, 'message' => $message, 'data' => $data]);
    }
}
