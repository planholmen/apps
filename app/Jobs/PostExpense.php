<?php

namespace App\Jobs;

use App\CustomOption;
use App\Expense;
use App\Http\Controllers\GoogleSheetsController;
use Google_Service_Sheets_BatchUpdateValuesRequest;
use Google_Service_Sheets_ValueRange;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostExpense implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $expense;

    /**
     * Create a new job instance.
     *
     * @param Expense $expense
     */
    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $sheetId = CustomOption::get('SHEET_UK_SPREADSHEET_ID');
        $service = GoogleSheetsController::getService();
        $data = [];

        $row = (string) $this->getNextRow();

        $data[] = new Google_Service_Sheets_ValueRange([
            'range' => "'Bogføring'!B" . $row,
            'values' => [[$this->expense->ph_id]],
        ]);

        $data[] = new Google_Service_Sheets_ValueRange([
            'range' => "'Bogføring'!E" . $row . ":F" . $row,
            'values' => [
                [
                    $this->expense->activity,
                    $this->expense->amount
                ]
            ]
        ]);

        $data[] = new Google_Service_Sheets_ValueRange([
            'range' => "'Bogføring'!H" . $row . ":I" . $row,
            'values' => [
                [
                    $this->expense->creditor,
                    'Nej'
                ]
            ]
        ]);

        $body = new Google_Service_Sheets_BatchUpdateValuesRequest([
            'valueInputOption' => 'USER_ENTERED',
            'data' => $data
        ]);

        $res = $service->spreadsheets_values->batchUpdate($sheetId, $body);

        $this->expense->fresh();
        $this->expense->posted = true;
        $this->expense->save();

    }

    private function getNextRow()
    {
        return (sizeof(Expense::where('posted', true)->get()) + 9);
    }
}
