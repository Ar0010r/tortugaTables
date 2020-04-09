<?php

namespace App\Http\Controllers;

use App\Courier;
use App\GoogleTable;
use App\Http\Requests\CourierStoreRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Order;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        return view('content');
    }

    public function storeCouriers(CourierStoreRequest $request)
    {
        return Courier::store($request);
    }

    public function storeOrders(OrderStoreRequest $request)
    {
        //return $request;
        return Order::store($request);
    }

}
