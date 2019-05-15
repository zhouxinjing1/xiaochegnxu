<?php
/**
 * Created by PhpStorm.
 * User: Aaron
 * Date: 2019/5/15
 * Time: 13:22
 */
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\ReturnJson;
use App\Model\SystemOther;
use App\Model\ShiftImage;
use App\Handlers\Operation;

class CommonController extends Controller
{
    public function getBanner(Request $request)
    {
        $data = ShiftImage::where('type', $request->type)->first();

        if (!is_null($data)) {
            $data = $data->toArray();
        }

        return ReturnJson::response($data);
    }

    public function getSystem()
    {
        $data = SystemOther::find(1);

        return ReturnJson::response($data);
    }

    public function getOpenid(Request $request)
    {
        Operation::getOpenid($request->code);

    }

}