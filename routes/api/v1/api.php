<?php

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

Route::get('/', function () {
    return response()->json([
        env('APP_NAME') => 'api ' . env('APP_VERSION')
    ]);
});

Route::prefix('/auth')->group(function () {
    Route::post('/', 'V1\Admin\AuthController@store');
    Route::delete('/', 'V1\Admin\AuthController@destroy')->middleware('auth:api');
});

Route::middleware(['auth:api', 'scope:access-admin'])->get('/users', 'V1\Admin\UserController@index');
