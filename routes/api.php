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
    $router->get('/common/page/getNewList','CommonController@getNewList')->where(['page' => '[0-9]+']);
    $router->get('/common/getNewInfo','CommonController@getNewInfo')->where(['id' => '[0-9]+']);
    $router->post('/login/login','LoginController@login');
    $router->post('/login/getOpenid','LoginController@getOpenid');

    $router->post('/good/createGood', 'GoodController@createGood')->middleware('verificationLogin');
    $router->post('/upload/uploadImage', 'UploadController@uploadImage');
});




