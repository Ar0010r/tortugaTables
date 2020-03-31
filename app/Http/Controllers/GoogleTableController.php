<?php

namespace App\Http\Controllers;

use App\GoogleTable;

class GoogleTableController extends Controller
{
    public function ordersTable()
    {
        request()->headers->set('accept', 'application/json');
        return GoogleTable::init()->ordersTable();
    }

    public function couriersTable()
    {
        request()->headers->set('accept', 'application/json');
        return GoogleTable::init()->couriersTable();
    }

    public function readData()
    {
        return GoogleTable::init()->readData();
    }

}
