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
    Route::post('reset-password-request', 'AuthController@resetPasswordRequest');
    Route::post('reset-password', 'AuthController@resetPassword');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('profile', 'AuthController@profile');
    });
});



Route::group(['namespace' => 'Api'], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['middleware' => 'scope:user'], function () {
            Route::get('get-categories', 'ProductController@categories');
            Route::resource('products', 'ProductController');
        });
        Route::group(['middleware' => 'scope:administrator'], function () {
            Route::resource('categories', 'CategoryController');
        });
    });
});
