<?php

namespace App;

class GoogleTable extends GoogleTableOperations
{
    /**
     * В зависимости от текущего урл, функция подготавливает лист для заполнения данными курьеров/заказов
     *
     * @return \Illuminate\Http\Response
     */
    public function showWorkSheet(): \Illuminate\Http\Response
    {
        try {
            //по урл, определяем используемую сейчас таблицу и получаем ее данные
            $googleTable = $this->getCurrentGoogleTable();
            $columns = $googleTable['columns'];

            //если лист соответствующий имени курьера не создан - создаем его
            $this->setUpWorkSheet();

            //если лист пуст - добавляем шапку с названиями столбцов
            $this->setUpWorkSheetHead($columns);
            return response('ok', 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Функция считывает данные из Гугл Таблицы, для последующеге заполнения формы
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function readData(): \Illuminate\Http\Response
    {
        try {
            //по урл, определяем используемую сейчас таблицу и получаем ее данные
            $googleTable = $this->getCurrentGoogleTable();
            $name = $googleTable['name'];
            $columns = $googleTable['columns'];

            //считываем данные с листа соответствующего имени курьера
            $data = $this->getValidatedData($columns, $name);
            return response($data, 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }


    /**
     * Функия возвращающает класс для работы с Гугл Таблицами
     *
     * @return GoogleTable
     */
    public static function init(): GoogleTable
    {
        if (empty(self::$instance)) {
            return self::$instance = new self();
        }
        return self::$instance;
    }
}
