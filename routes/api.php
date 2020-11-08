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
    });
});



Route::group(['namespace' => 'Api'], function () {
    Route::resource('categories', 'CategoryController');
    Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
        Route::post('edit-category', function () {
            return response()->json([
                'message' => 'Admin access',
                'status_code' => 200
            ], 200);
        })->middleware('scope:do_anything');
        Route::post('create-category', function () {
            return response()->json([
                'message' => 'Everyone access',
                'status_code' => 200
            ], 200);
        })->middleware('scope:do_anything,can_create');
    });
});
