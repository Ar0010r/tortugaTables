<?php

namespace App\Http\Controllers;

use App\Courier;
use App\GoogleTable;
use App\Order;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        return view('content');
    }

    public function storeCouriers()
    {
        return Courier::store();
    }

    public function storeOrders()
    {
        return Order::store();
    }

}
