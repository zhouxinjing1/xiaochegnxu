<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Good;
use App\Http\Controllers\Common\ReturnJson;
use App\Http\Resources\GoodCollection;

class GoodController extends Controller
{
    private $limit = 3;

    /**
     * 发布商品
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createGood(Request $request)
    {
        $good = new Good();
        $good->brand = $request->brand;
        $good->displacement = $request->displacement;
        $good->transmission = $request->transmission;
        $good->year = spellCity($request->year,0,'-');
        $good->mileage = $request->mileage;
        $good->city = $request->city[1];
        $good->change_number = $request->change_number;
        $good->overview = $request->overview;
        $good->car_is = $request->car_is;
        $good->car_right = $request->car_right;
        $good->car_left = $request->car_left;
        $good->car_after = $request->car_after;
        $good->car_engine = $request->car_engine;
        $good->car_backup = $request->car_backup;
        $good->car_central = $request->car_central;
        $good->car_front = $request->car_front;
        $good->car_back = $request->car_back;
        $good->choose_license = $request->choose_license;
        $good->choose_tire = $request->choose_tire;
        $good->choose_headlight = $request->choose_headlight;
        $good->choose_report =$request->choose_report;
        $good->choose_right = $request->choose_right;
        $good->choose_left =$request->choose_left;
        $good->user_id  = $request->user_id;
        $good->type = $request->type;
        $good->price = $request->price;
        $good->money = $request->money;
        $good->bond  = $request->bond;

        if ($good->save()) {
            return ReturnJson::response([],'200','发布成功');
        }
        return ReturnJson::response([],'300','发布失败');
    }

    /**
     * 排序方式 : 推荐 -> 自定义排序 -> 设置保留价 ->创建时间
     * 推荐商品
     */
    public function Recommend(Request $request, Good $good)
    {
        $data = $good->status()->reco()->recommend()->offset($request->page)->paginate($this->limit);

        return new GoodCollection($data);
    }

}
