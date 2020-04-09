<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'web'], function () {

    Auth::routes();

    Route::get('api/table/couriers', 'GoogleTableController@showTable');
    Route::get('api/table/orders', 'GoogleTableController@showTable');
    Route::get('api/table/read', 'GoogleTableController@readData');
    Route::post('api/couriers/store', 'AppController@storeCouriers');
    Route::post('api/orders/store', 'AppController@storeOrders');

    Route::get('{vue_capture?}', 'AppController@index')->where('vue_capture', '^(?!storage).*$')->middleware('auth');

});