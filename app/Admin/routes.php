<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    // 轮播图
    $router->resource('/system/shift-image', 'ShiftImageController');

    // 其他设置
    $router->get('/system/system-other', 'SystemOtherController@index');
    $router->put('/system/system-other','SystemOtherController@update');

    // 客户
    $router->resource('/user','UserController');

    // 新闻资讯
    $router->resource('/new','NewController');


});
