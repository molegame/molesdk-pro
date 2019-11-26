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

// Route::group(['middleware' => 'api'], function () {
//     // 渠道列表
//     Route::apiResource('channels', 'ChannelController')->only(['index', 'show']);
//     // 管理员
//     Route::group(["prefix" => "administrator"], function () {
//         Route::post('login', 'Administrator\LoginController@login');
//         Route::post('logout', 'Administrator\LoginController@logout')->name('logout');
//         Route::post('refresh_token','Administrator\LoginController@refreshToken');

//         // 开发者列表
//         Route::apiResource('developers', 'Administrator\DeveloperController');
//     });
//     // 开发者
//     Route::group(["prefix" => "developer"], function () {
//         Route::post('register', 'Developer\RegisterController@register');
//         Route::post('login', 'Developer\LoginController@login');
//         Route::post('logout', 'Developer\LoginController@logout')->name('logout');
//         Route::post('refresh_token','Developer\LoginController@refreshToken');

//         Route::group(['middleware' => ['auth:developer']], function () {
//             // 玩家列表
//             Route::apiResource('players', 'Developer\PlayerController');
//             // 游戏列表
//             Route::post('games/{id}/restore', 'Developer\GameController@restore');
//             Route::apiResource('games', 'Developer\GameController');
//             // 游戏渠道列表
//             Route::apiResource('games.channels', 'Developer\Game\ChannelController');
//             // 游戏测试账号列表
//             Route::apiResource('games.accounts', 'Developer\GameAccountController');
//         });
//     });
//     // 玩家
//     Route::group(["prefix" => "player"], function () {
//     });
// });

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    // 渠道列表
    $api->resource('channels', '\App\Http\Controllers\ChannelController', ['only' => ['index', 'show']]);
    // 管理员
    $api->group(["prefix" => "administrator"], function ($api) {
        $api->post('login', '\App\Http\Controllers\Administrator\LoginController@login');
        $api->post('logout', '\App\Http\Controllers\Administrator\LoginController@logout');
        $api->post('refresh_token','\App\Http\Controllers\Administrator\LoginController@refreshToken');

        // 开发者列表
        $api->resource('developers', '\App\Http\Controllers\Administrator\DeveloperController');
    });
    // 开发者
    $api->group(["prefix" => "developer"], function ($api) {
        $api->post('register', '\App\Http\Controllers\Developer\RegisterController@register');
        $api->post('login', '\App\Http\Controllers\Developer\LoginController@login');
        $api->post('logout', '\App\Http\Controllers\Developer\LoginController@logout');
        $api->post('refresh_token','\App\Http\Controllers\Developer\LoginController@refreshToken');

        $api->group(['middleware' => ['auth:developer']], function ($api) {
            // 玩家列表
            $api->resource('players', '\App\Http\Controllers\Developer\PlayerController');
            // 游戏列表
            $api->post('games/{id}/restore', '\App\Http\Controllers\Developer\GameController@restore');
            $api->resource('games', '\App\Http\Controllers\Developer\GameController');
            // 游戏渠道列表
            $api->resource('games.channels', '\App\Http\Controllers\Developer\Game\ChannelController');
            // 游戏测试账号列表
            //$api->resource('games.accounts', '\App\Http\Controllers\Developer\GameAccountController');
        });
    });
    // 玩家
    $api->group(["prefix" => "player"], function ($api) {
    });
});