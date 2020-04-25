<?php

namespace App;

use Google\Spreadsheet\Batch\BatchRequest;
use Google\Spreadsheet\Batch\BatchResponse;
use Google\Spreadsheet\Exception\SpreadsheetNotFoundException;
use Google\Spreadsheet\Worksheet;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;
use Google_Service_Sheets_ClearValuesRequest;
use Illuminate\Database\Eloquent\Model;

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService as SpreadsheetService;
use Illuminate\Support\Facades\Auth;
use Google\Spreadsheet\Exception\WorksheetNotFoundException;

class GoogleTableOperations extends Model
{
    protected const ORDERS_SPREADSHEET_ID = '1Hj4x_QRGoDotJNAFYm1hjKI7YZLHbjAwe2vsuUdMWv0';
    protected const COURIERS_SPREADSHEET_ID = '1PhmQ1_MZHCE8zKrVhG6bvg0DAWtAD4M0U_Db8dDHjOY';
    protected const ORDERS_TABLE_TITLE = 'orders';
    protected const COURIERS_TABLE_TITLE = 'couriers';

    protected \Google_Service_Sheets $service;
    protected \Google_Client $client;

    protected \Google\Spreadsheet\Worksheet $workSheet;
    protected string $workSheetTitle;
    protected static GoogleTable $instance;

    protected array $couriersTableColumns =
        ['name', 'email', 'paypal', 'address', 'city', 'state', 'zip', 'phone 1', 'phone 2'];
    protected array $ordersTableColumns =
        ['courier name', 'content', 'quantity', 'price', 'tracking', 'holder'];


    /**
     * Здесь происходит подключение к сервису гугл таблиц
     *
     * GoogleTableOperations constructor.
     */
    protected function __construct()
    {
        try {
            $this->client = new \Google_Client();
            $this->client->setApplicationName('tables');
            $this->client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
            $this->client->setAccessType('offline');
            $this->client->setAuthConfig('../credentials.json');
            $this->service = new \Google_Service_Sheets($this->client);
            $this->workSheetTitle = Auth::user()->login;
        } catch (\Google_Exception $e) {
            return response('Ошибка при подключении' . $e->getMessage(), 500);
        }
    }

    /**
     * Функция подготавливает лист с нужной таблицей. Если такового нет - создает его
     *
     * @return bool
     * @throws \Exception
     */
    protected function setUpWorkSheet(): bool
    {
        try {
            $this->getCurrentWorkSheet();
            return true;
        } catch (\Exception $e) {
            try {
                $this->createWorkSheet();
                $this->workSheet = $this->getCurrentWorkSheet();
                return true;
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }
    }

    /**
     * Функция возвращает объект листа, который использует менеджер
     *
     * @return \Google\Spreadsheet\Worksheet
     * @throws \Exception
     */
    protected function getCurrentWorkSheet(): Worksheet
    {
        try {
            //находим список всех таблиц (их только две: orders и couriers)
            $accessToken = $this->client->fetchAccessTokenWithAssertion()["access_token"];
            $serviceRequest = new DefaultServiceRequest($accessToken);
            ServiceRequestFactory::setInstance($serviceRequest);
            $spreadsheetService = new SpreadsheetService();
            $spreadsheetFeed = $spreadsheetService->getSpreadsheetFeed();

            //выбираем соответствующую таблицу, соответствующую текущему урл
            $currentGoogleTable = $this->getCurrentGoogleTable();
            $tableTitle = strval($currentGoogleTable['tableTitle']);
            $spreadsheet = $spreadsheetFeed->getByTitle($tableTitle);

            //выбираем из этой таблицы лист соответствующий имени менеджера
            $worksheetFeed = $spreadsheet->getWorksheetFeed();
            return $worksheetFeed->getByTitle($this->workSheetTitle);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        } catch (\Google\Spreadsheet\Exception\WorksheetNotFoundException $e) {
            throw new \Exception($e->getMessage());
        } catch (\Google\Spreadsheet\Exception\SpreadsheetNotFoundException $e) {
            throw new \Exception('таблица не найдена:' . $e->getMessage());
        }
    }

    /**
     * Функция создает шапку с названием столбцов в используемом менеджером листе
     *
     * @param array $columnNames
     * @return \Google\Spreadsheet\Batch\BatchResponse
     * @throws \Exception
     */
    protected function setUpWorkSheetHead(array $columnNames)
    {
        try {
            $cellFeed = $this->getCurrentWorkSheet()->getCellFeed();

            if (empty($cellFeed->toArray())) {
                $batchRequest = new BatchRequest();

                foreach ($columnNames as $key => $value) {
                    $batchRequest->addEntry($cellFeed->createCell(1, $key + 1, $value));
                }

                return $cellFeed->insertBatch($batchRequest);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * В зависимости от текущего урл, функция возвращает данные используемой сейчас таблицы
     *
     * @return array
     * @throws \Exception
     */
    protected function getCurrentGoogleTable(): array
    {
        //из HTTP заголовков получаем урл с котрого пришел запрос
        $referer = request()->headers->get('referer');

        //если в полученном урл есть слово 'couriers', возвращаем соответствующие данные
        if (strpos($referer, 'couriers') == true) {
            return [
                'name' => 'Курьеры',
                'columns' => $this->couriersTableColumns,
                'tableTitle' => self::COURIERS_TABLE_TITLE,
                'spreadSheetId' => self::COURIERS_SPREADSHEET_ID
            ];

        // аналогично
        } elseif (strpos($referer, 'orders') == true) {
            return [
                'name' => 'Заказы',
                'columns' => $this->ordersTableColumns,
                'tableTitle' => self::ORDERS_TABLE_TITLE,
                'spreadSheetId' => self::ORDERS_SPREADSHEET_ID
            ];
        }

        throw new \Exception('Не получилось определить текущую таблицу. Пожалуйста обновите страницу');
    }

    /**
     * Функция создает лист, соответствующий логину менеджера
     *
     * @throws \Exception
     */
    protected function createWorkSheet()
    {
        try {
            $body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array(
                'requests' => array('addSheet' => array('properties' => array('title' => $this->workSheetTitle)))
            ));
            $currentGoogleTable = $this->getCurrentGoogleTable();
            $spreadsheetId = $currentGoogleTable['spreadSheetId'];

            $this->service->spreadsheets->batchUpdate($spreadsheetId, $body);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * По количеству заполненых столбцов, функция проверяет корректность ввода данных в Гугл Таблицу
     *
     * @param array $columns
     * @param string $name
     * @return array
     * @throws \Exception
     */
    protected function getValidatedData(array $columns, string $name): array
    {
        try {
            //считываем данные с используемого сейчас листа
            $data = $this->getCurrentWorkSheet()->getCellFeed()->toArray();

            //валидируем данные
            foreach ($data as $value) {
                if (count($value) > count($columns)) {
                    throw new \Exception('В строке таблицы ' . "'" . $name . "'"
                        . ' должно быть ' . count($columns) . ' или меньше ячеек ');
                }
            }

            //проверяем лист на заполненность
            $data = $this->removeWorkSheetHead($data, $columns);
            if (empty($data)) {
                throw new \Exception('Гугл таблица пуста, заполните ее данными. ' . PHP_EOL .
                    'Используйте лист соответствующий вашему логину');
            }

            return $data;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Функция убирает из массива с данными, шапку с именами столбцов (которые добавляются setUpWorkSheetHead())
     *
     * @param array $data
     * @param array $columns
     * @return array
     */
    protected function removeWorkSheetHead(array $data, array $columns): array
    {
        $diff = array_diff($data[1], $columns);

        if ($diff == []) {
            unset($data[1]);
            return $data;
        }
        return $data;
    }
}

// на всяк случай, вдруг надо будет, функции для отчистки и удаления листов
/*
protected function clearWorkSheet()
{
    $requestBody = new Google_Service_Sheets_ClearValuesRequest();
    $this->service->spreadsheets_values
        ->clear($this->spreadsheetId, 'A1:H1', $requestBody);
}

protected function deleteWorkSheet()
{
    $this->workSheet->delete();
}
*/
