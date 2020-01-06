<?php

namespace App\Http\Controllers;

use App\Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriveController extends Controller
{
    public function index()
    {
        $drives = Auth::user()->drives;
        return view('drive.index', compact('drives'));
    }

    public function create()
    {
        return view('drive.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'from' => 'required|min:2',
            'to' => 'required|min:2',
            'purpose' => 'required|min:2',
            'distance' => 'required'
        ]);

        Drive::create([
           'date' => $data['date'],
           'from' => $data['from'],
           'to' => $data['to'],
           'purpose' => $data['purpose'],
           'distance' => round($data['distance'], 0),
           'user_id' => Auth::id()
        ]);

    }

    public function post()
    {

        $user = Auth::user();
        $drives = $user->drives()->where('posted', false)->get();
        $title = str_replace(" ", "_", $user->name) . "_Koerebog_" . date('Y-m-d_H:i:s');

        $service = GoogleSheetsController::getService();

        $tempSheet = GoogleSheetsController::createSheet($title);
        $sheet = GoogleDriveController::copyFile($tempSheet->spreadsheetId, new Google_Service_Drive_DriveFile([
            'name' => $title,
            'parents' => explode(",", env("SHEETS_DRIVE_LEDGER_PARENT"))
        ]));

        GoogleDriveController::deleteFile($tempSheet->spreadsheetId);

        $values = [
            ['', 'DDS Kørebog', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['Navn: ', $user->name, '', '', '', ''],
            ['Adresse: ', '', '', '', '', ''],
            ['Registreringsnr.', '', '', '', '', ''],
            ['Bilagsnr. på afregningsark', '', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['Dato', 'Kørslens mål', 'Kørslens formål', 'Antal KM', 'KM-sats', 'I alt']
        ];

        $sumKm = 0;$sumMoney = 0;

        foreach ($drives as $drive) {
            $sumKm += $drive->distance;
            $sumMoney += ((int) $drive->distance * (double) env('KM_SATS'));

            $val = [
                $drive->date->format('d/m/Y'),
                $drive->from . " -> " . $drive->to,
                $drive->purpose,
                $drive->distance,
                env('KM_SATS'),
                ((int) $drive->distance * (double) env('KM_SATS'))
            ];

            array_push($values, $val);
        }

        $footer = [
            ['', '', '', '', '', ''],
            ['I alt', '', '', $sumKm, '', $sumMoney],
            ['', '', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['Underskrift', $user->name, '', '', '', ''],
            ['', '', '', '', '', ''],
            ['Attesteret af:', '', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['Underskrift', '', '', '', '', '']
        ];

        foreach ($footer as $line) {
            array_push($values, $line);
        }

        $service->spreadsheets_values->update($sheet->spreadsheetId, 'A1:Z1000', new \Google_Service_Sheets_ValueRange([
            'values' => $values
        ]), ['valueInputOption' => 'RAW']);

    }

    public static function unposted()
    {
        return Drive::where('posted', false)->get();
    }

}
