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
use App\Model\News;
use App\Http\Resources\NewCollection;

class CommonController extends Controller
{
    private $limit = 2;

    /**
     * 轮播图
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBanner(Request $request)
    {
        $data = ShiftImage::where('type', $request->type)->first();

        if (!is_null($data)) {
            $data = $data->toArray();
        }

        return ReturnJson::response($data);
    }

    /**
     * 系统信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSystem()
    {
        $data = SystemOther::find(1);

        return ReturnJson::response($data);
    }

    /**
     * 新闻列表
     * @param Request $request
     * @return NewCollection
     */
    public function getNewList(Request $request)
    {
        $data = News::select('id', 'title', 'image', 'created_at', 'summary')->offset($request->page)->paginate($this->limit);

        return new NewCollection($data);
    }

    /**
     * 新闻资讯
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNewInfo(Request $request)
    {
        $data = News::find($request->id);

        return ReturnJson::response($data);
    }

    public function getOpenid(Request $request)
    {
        Operation::getOpenid($request->code);

    }

}