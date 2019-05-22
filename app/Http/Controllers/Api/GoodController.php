<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Good;

class GoodController extends Controller
{
    public function createGood(Request $request)
    {
        $good = new Good();
        $good->brand = $request->brand;
        $good->displacement = $request->displacement;
        $good->transmission = $request->transmission;
        $good->year = $request->year;
        $good->mileage = $request->mileage;
        $good->city = $request->city;
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
        $good->save();
    }
}
