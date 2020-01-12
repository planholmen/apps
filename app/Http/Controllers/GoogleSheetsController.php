<?php

namespace App\Http\Controllers;

use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Illuminate\Http\Request;

class GoogleSheetsController extends Controller
{

    private static $client;

    private static function setClient()
    {
        if ( ! GoogleSheetsController::$client)
            GoogleSheetsController::$client = (new GoogleController())->getClient();
    }

    public static function createSheet($title)
    {
        self::setClient();

        $sheetsService = new Google_Service_Sheets(GoogleSheetsController::$client);
        $sheetsRequest = new Google_Service_Sheets_Spreadsheet([
            'properties' => [
                'title' => $title,
                'timeZone' => config('app.timezone')
            ]
        ]);

        return $sheetsService->spreadsheets->create($sheetsRequest);
    }

    public static function getService()
    {
        self::setClient();

        return new \Google_Service_Sheets(GoogleSheetsController::$client);
    }

}
