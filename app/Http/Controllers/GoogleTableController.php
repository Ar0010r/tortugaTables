<?php

namespace App\Http\Controllers;

use App\GoogleTable;

class GoogleTableController extends Controller
{
    public function showTable()
    {
        request()->headers->set('accept', 'application/json');
        return GoogleTable::init()->showTable();
    }

    public function readData()
    {
        return GoogleTable::init()->readData();
    }

}
