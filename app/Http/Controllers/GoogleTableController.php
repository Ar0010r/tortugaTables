<?php

namespace App\Http\Controllers;

use App\GoogleTable;

class GoogleTableController extends Controller
{
    /**
     * В зависимости от текущего урл, функция подготавливает лист для заполнения данными курьеров/заказов
     *
     * @return \Illuminate\Http\Response
     */
    public function showWorkSheet()
    {
        request()->headers->set('accept', 'application/json');
        return GoogleTable::init()->showWorkSheet();
    }

    /**
     * Функция считывает данные из Гугл Таблицы, для последующеге заполнения формы
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function readData()
    {
        return GoogleTable::init()->readData();
    }
}
