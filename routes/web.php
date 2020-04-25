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

    //роутинг для логина/регистриции
    Auth::routes();

    //роутинг для обращения к апи
    Route::get('api/table/couriers', 'GoogleTableController@showWorkSheet');
    Route::get('api/table/orders', 'GoogleTableController@showWorkSheet');
    Route::get('api/table/read', 'GoogleTableController@readData');
    Route::post('api/couriers/store', 'AppController@storeCouriers');
    Route::post('api/orders/store', 'AppController@storeOrders');

    //роутинг для всех страниц сайта (кроме логина и регистрации). Здесь управление перехватывает Vue JS
    Route::get('{vue_capture?}', 'AppController@index')->where('vue_capture', '^(?!storage).*$')->middleware('auth');
});