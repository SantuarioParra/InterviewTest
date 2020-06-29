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

Route::post('/login', 'Auth\AuthController@login')->name('login');
Route::post('signup', 'Auth\AuthController@signUp')->name('signup');
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/logout', 'Auth\AuthController@logOut')->name('logout');
});
Route::group(['prefix' => 'auth'], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'Auth\AuthController@user')->name('auth.user');
        Route::apiResource('/users', 'User\UserController');
        Route::post('/users/restore/{id}', 'User\UserController@restore')->name('products.restore');
    });
});
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/products', 'Product\ProductController');
    Route::post('/products/restore/{id}', 'Product\ProductController@restore')->name('products.restore');
});

