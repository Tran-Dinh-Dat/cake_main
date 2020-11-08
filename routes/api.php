<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('profile', 'AuthController@profile');
    });
});



Route::group(['namespace' => 'Api'], function () {
    Route::resource('categories', 'CategoryController');
    Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
        Route::group(['middleware' => 'scopes:user'], function () {
            Route::get('user-scope', function () {
                return response()->json([
                    'message' => 'Người dùng có thể truy cập!',
                    'status_code' => 200
                ], 200);
            });
        });
        Route::group(['middleware' => 'scope:administrator'], function () {
            Route::get('admin-scope', function () {
                return response()->json([
                    'message' => 'Admin có thể truy cập!',
                    'status_code' => 200
                ], 200);
            });
        });
    });
});
