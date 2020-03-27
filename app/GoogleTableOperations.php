<?php

namespace App;

use Google\Spreadsheet\Batch\BatchRequest;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;
use Google_Service_Sheets_ClearValuesRequest;
use Illuminate\Database\Eloquent\Model;

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService as SpreadsheetService;
use Illuminate\Support\Facades\Auth;

class GoogleTableOperations extends Model
{
    protected const ORDERS_SPREADSHEET_ID = '1Hj4x_QRGoDotJNAFYm1hjKI7YZLHbjAwe2vsuUdMWv0';
    protected const COURIERS_SPREADSHEET_ID = '1PhmQ1_MZHCE8zKrVhG6bvg0DAWtAD4M0U_Db8dDHjOY';
    protected const ORDERS_TABLE_TITLE = 'orders';
    protected const COURIERS_TABLE_TITLE = 'couriers';
    protected $tableTitle = 'orders';
    protected $couriersTableColumns = ['email', 'paypal', 'address', 'city', 'state', 'zip', 'phone 1', 'phone 2'];
    protected $ordersTableColumns = ['courier name', 'content', 'quantity', 'price', 'tracking', 'holder', "", ""];

    protected $workSheetTitle;
    protected $workSheet;

    protected $service;
    protected $client;
    protected static $instance;

    protected function __construct()
    {
        $this->client = new \Google_Client();
        $this->client->setApplicationName('tables');
        $this->client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $this->client->setAccessType('offline');
        $this->client->setAuthConfig('../credentials.json');
        $this->service = new \Google_Service_Sheets($this->client);
        $this->workSheetTitle = Auth::user()->login;
    }

    protected function newWorkSheet()
    {
        //if ($this->getCurrentWorkSheet()->getTitle() == $this->workSheetTitle) {
       /* if ($this->getCurrentWorkSheet()) {
            $result = true;
        } else {*/
            $body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array(
                'requests' => array('addSheet' => array('properties' => array('title' => $this->workSheetTitle)))
            ));
            $currentGoogleTable = $this->getGoogleTable();
            $spreadsheetId = $currentGoogleTable['spreadSheetId'];

            $result = $this->service->spreadsheets->batchUpdate($spreadsheetId, $body);
        //}

        $this->workSheet = $this->getCurrentWorkSheet();

        return $result;
    }

    protected function deleteWorkSheet()
    {
        //$this->findWorkSheet()->delete();
        $this->workSheet->delete();
    }

    /**
     * @param $title
     * @return \Google\Spreadsheet\Worksheet
     * @throws \Google\Spreadsheet\Exception\SpreadsheetNotFoundException
     * @throws \Google\Spreadsheet\Exception\WorksheetNotFoundException
     */
    protected function getCurrentWorkSheet()
    {
        $accessToken = $this->client->fetchAccessTokenWithAssertion()["access_token"];
        $serviceRequest = new DefaultServiceRequest($accessToken);
        ServiceRequestFactory::setInstance($serviceRequest);
        $spreadsheetService = new SpreadsheetService();
        $spreadsheetFeed = $spreadsheetService->getSpreadsheetFeed();
        
        $currentGoogleTable = $this->getGoogleTable();
        $tableTitle= strval($currentGoogleTable['tableTitle']);
        $spreadsheet = $spreadsheetFeed->getByTitle($tableTitle);
        //$spreadsheet = $spreadsheetFeed->getByTitle($tableTitle)->getId();

        $worksheetFeed = $spreadsheet->getWorksheetFeed();
        return $worksheetFeed->getByTitle($this->workSheetTitle);
    }

    protected function setTableHead($columnNames)
    {
        //$this->clearWorkSheet();
        //$worksheet = $this->findWorkSheet();
        $cellFeed = $this->getCurrentWorkSheet()->getCellFeed();
        $batchRequest = new BatchRequest();

        foreach ($columnNames as $key => $value) {
            $batchRequest->addEntry($cellFeed->createCell(1, $key + 1, $value));
        }
        return $cellFeed->insertBatch($batchRequest);
    }

    protected function clearWorkSheet()
    {
        $requestBody = new Google_Service_Sheets_ClearValuesRequest();
        $this->service->spreadsheets_values
            ->clear($this->spreadsheetId, 'A1:H1', $requestBody);
    }

    protected function getGoogleTable()
    {
        $referer = request()->headers->get('referer');

        if (strpos($referer, '/table/couriers') == true) {
            return [
                'name' => 'Курьеры',
                'columns' => $this->couriersTableColumns,
                'tableTitle' => self::COURIERS_TABLE_TITLE,
                'spreadSheetId' => self::COURIERS_SPREADSHEET_ID];


        }

        if (strpos($referer, '/table/orders') == true) {
            return ['name' => 'Заказы',
                'columns' => array_diff($this->ordersTableColumns, ['']),
                'tableTitle' => self::ORDERS_TABLE_TITLE,
                'spreadSheetId' => self::ORDERS_SPREADSHEET_ID];
        }

        return false;
    }

    protected function validateDataSize($columns)
    {
        $data = $this->getCurrentWorkSheet()->getCellFeed()->toArray();

        foreach ($data as $value) {
            if (count($value) > count($columns)) {
                return false;
            }
        }

        return $data;
    }

    protected function removeTableHead($data, $columns)
    {
        $diff = array_diff($data[1], $columns);

        if ($diff == []) {
            unset($data[1]);
            return $data;
        }
        return $data;
    }


}
