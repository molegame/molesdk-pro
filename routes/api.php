<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    // 渠道列表
    $api->resource('channels', 'App\Http\Controllers\ChannelController', ['only' => ['index', 'show']]);
    // 管理员
    $api->group(["prefix" => "administrator"], function ($api) {
        $api->post('login', 'App\Http\Controllers\Administrator\LoginController@login');
        
        $api->group(['middleware' => ['auth:administrator']], function ($api) {
            $api->post('logout', 'App\Http\Controllers\Administrator\LoginController@logout');
            $api->post('refresh_token','App\Http\Controllers\Administrator\LoginController@refreshToken');

            // 开发者列表
            $api->resource('developers', 'App\Http\Controllers\Administrator\DeveloperController');
        });
    });
    // 开发者
    $api->group(["prefix" => "developer"], function ($api) {
        $api->post('register', 'App\Http\Controllers\Developer\RegisterController@register');
        $api->post('login', 'App\Http\Controllers\Developer\LoginController@login');
        $api->post('logout', 'App\Http\Controllers\Developer\LoginController@logout');
        $api->post('refresh_token','App\Http\Controllers\Developer\LoginController@refreshToken');

        $api->group(['middleware' => ['auth:developer']], function ($api) {
            // 玩家列表
            $api->resource('players', 'App\Http\Controllers\Developer\PlayerController');
            // 游戏列表
            $api->post('games/{game}/restore', 'App\Http\Controllers\Developer\GameController@restore');
            $api->resource('games', 'App\Http\Controllers\Developer\GameController');
            // 游戏渠道列表
            $api->resource('games.channels', 'App\Http\Controllers\Developer\Game\ChannelController');
            // 游戏测试账号列表
            // $api->resource('games.accounts', 'App\Http\Controllers\Developer\GameAccountController');
        });
    });
    // 玩家
    $api->group(['middleware' => 'signed.client'], function ($api) {
        $api->post('initialize', 'App\Http\Controllers\Player\GameController@initialize');
        $api->post('login', 'App\Http\Controllers\Player\LoginController@login');
        $api->post('logout', 'App\Http\Controllers\Player\LoginController@logout');
        $api->post('order/create', 'App\Http\Controllers\Player\OrderController@create');
    });
    // 游戏服
    // Api for server
    $api->group(['middleware' => ['signed.server', 'auth:player']], function ($api) {
        $api->post('user/verify', 'App\Http\Controllers\PlayerController@verify');
    });
    // 渠道回调
    $api->any('pay_callback/{channel}/{game}', 'App\Http\Controllers\SdkController@callback');
});