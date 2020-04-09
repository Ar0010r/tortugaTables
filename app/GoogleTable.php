<?php

namespace App;

class GoogleTable extends GoogleTableOperations
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function showTable(): \Illuminate\Http\Response
    {
        try {
            $googleTable = $this->getGoogleTable();
            $columns = $googleTable['columns'];
            $this->newWorkSheet();
            $this->setTableHead($columns);
            return response('ok', 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function readData(): \Illuminate\Http\Response
    {
        try {
            $googleTable = $this->getGoogleTable();
            $name = $googleTable['name'];
            $columns = $googleTable['columns'];
            $data = $this->getValidatedData($columns, $name);
            return response($data, 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
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
