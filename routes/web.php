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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::group(['middleware' => 'web'], function () {

    Auth::routes();

    Route::get('api/table/couriers', 'GoogleTableController@couriersTable');
    Route::get('api/table/orders', 'GoogleTableController@ordersTable');
    Route::get('api/table/read', 'GoogleTableController@readData');

    Route::get('{vue_capture?}', 'AppController@index')->where('vue_capture', '^(?!storage).*$')
        ->middleware('auth')
    ;

});