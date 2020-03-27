<?php

namespace App;

class GoogleTable extends GoogleTableOperations
{
    public function couriersTable()
    {
        /*$this->newWorkSheet();
        $this->setTableHead($this->couriersTableColumns);*/
        //return $this->newWorkSheet();
        return $this->newWorkSheet();
    }

    public function ordersTable()
    {
       //return $this->newWorkSheet();
        return $this->getCurrentWorkSheet();
       /* $this->newWorkSheet();
        $this->setTableHead($this->ordersTableColumns);*/
    }

    public function readData()
    {
        $googleTable = $this->getGoogleTable();
        $name = $googleTable['name'];
        $columns = $googleTable['columns'];

        $data = $this->validateDataSize($columns);

        if ($data) {
            return $this->removeTableHead($data, $columns);
        }
        return 'В строке таблицы ' . "'" . $name . "'" . ' должно быть ' . count($columns) . ' или меньше ячеек';
    }

    public static function init(): GoogleTable
    {
        if (empty(self::$instance)) {
            return self::$instance = new self();
        }
        return self::$instance;
    }
}
