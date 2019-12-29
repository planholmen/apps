<?php

namespace App\Http\Controllers;

use App\Expense;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function create()
    {
        return view('expense.create');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'activity' => 'required|min:2',
            'amount' => 'required|min:0',
            'file' => 'required|file|mimes:jpeg,bmp,png,gif,pdf'
        ]);

        $user = Auth::user();

        $expense = Expense::create([
           'activity' => $data['activity'],
           'amount' => $data['amount'],
           'creditor' => $user->name
        ]);

        $expense->fresh();

        $path = Storage::putFileAs('expenses', $request->file('file'), $expense->id . "." . $request->file('file')->extension());

        $expense->file_path = $path;

        $expense->save();

        return redirect('/expense/create');

    }

    public static function transfer() {

        $client = new GoogleController();
        $client = $client->getClient();
        $service = new Google_Service_Drive($client);

        // Get all non-uploaded files
        $expenses = Expense::where('uploaded', '=', false)->get();

        foreach ($expenses as $expense) {

            $file = $expense->file_path;
            $path = Storage::path($file);

            $metadata = new Google_Service_Drive_DriveFile(array(
                'name' => File::name($file),
                'parents' => [
                    env('DRIVE_EXPENSE_PARENT')
                ]
            ));

            $content = Storage::get($file);

            $service->files->create($metadata, array(
                'data' => $content,
                'mimeType' => File::mimeType($path),
                'uploadType' => 'multipart'
            ));

            $expense->uploaded = true;
            $expense->save();

        }

    }

}
