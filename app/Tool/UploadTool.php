<?php
/**
 * Created by PhpStorm.
 * User: Aaron
 * Date: 2019/5/16
 * Time: 13:18
 */

namespace App\Tool;

class UploadTool
{
    public static function upload_once($request, $param)
    {
        $disk = \Storage::disk('qiniu');
        $data = $request->file($param);
        $filename = $disk->put(date('Y/m/d'), $data);
        return spellUrl($filename);
    }

    public static function upload_many($request, $param)
    {
        $disk = \Storage::disk('qiniu');
        $data = $request->file($param);

        $array = [];
        foreach ($data as $v) {
            $filename = $disk->put(date('Y/m/d'), $v);
            $array[] = spellUrl($filename);
        }
        return $array;
    }
}