<?php

namespace App\Http\Controllers;

use App\GoogleTable;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        return view('content');
    }

}
