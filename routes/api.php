<?php

use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'Api'
],function (Router $router){
    $router->get('/common/getBanner', 'CommonController@getBanner')->where(['type' => '[0-9]+']);
    $router->get('/common/getSystem','CommonController@getSystem');
    $router->post('/login/login','LoginController@login');
    $router->get('/login/getOpenid','LoginController@getOpenid');
});




