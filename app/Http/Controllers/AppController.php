<?php

namespace App\Http\Controllers;

use App\Courier;
use App\Http\Requests\CourierStoreRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Order;

class AppController extends Controller
{
    /**
     * Функция возвращает лейаут сайта
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('content');
    }

    /**
     * Функция сохраняет курьеров в бд
     *
     * @param CourierStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeCouriers(CourierStoreRequest $request)
    {
        return Courier::store($request);
    }

    /**
     * Функция сохраняет заказы в бд
     *
     * @param OrderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrders(OrderStoreRequest $request)
    {
        return Order::store($request);
    }
}
