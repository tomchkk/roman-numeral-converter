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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get(
    '/conversions/convert/{integer}',
    'ConversionController@convert'
)->where('integer', '[0-9]+');

Route::get(
    'conversions/all',
    'ConversionController@all'
);

Route::get(
    'conversions/top-ten',
    'ConversionController@topTen'
);
