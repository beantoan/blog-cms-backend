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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', 'Auth\RegisterController@register');

    Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout');
    Route::get('refresh', 'Auth\AuthController@refresh');
    Route::get('me', 'Auth\AuthController@me');

});

Route::middleware('auth:api')->group(function () {
    Route::resource('posts', 'PostController')->except([
        'create', 'edit'
    ]);
});
