<?php
/**
 * Created by PhpStorm.
 * User: Aaron
 * Date: 2019/5/14
 * Time: 17:38
 */

namespace App\Tool;

class ImageTool
{

    public static function deleteJson($url, $key)
    {
        unset($url[$key]);
        return json_encode($url);
    }

    public static function addJson($url , $data)
    {
        if (is_null($url)) {
            $url = [];
        }
        return json_encode(array_merge($url, $data));
    }

}