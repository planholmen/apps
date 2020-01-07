<?php

namespace App\Http\Controllers;

use App\Expense;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();

        return view('expense.index', compact('expenses'));
    }

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

        $path = Storage::putFileAs('public/expenses', $request->file('file'), $expense->id . "." . $request->file('file')->extension());
        $path = str_replace('public/', '', $path);

        $expense->file_path = $path;

        $expense->save();

        return redirect('/expense/create');

    }

    public function approve($id = 0)
    {
        $expenses = Expense::where([
            ['uploaded', '=', 0],
            ['approved', '=', 0]
        ])->get()->toArray();

        return view('expense.approve', compact('expenses', 'id'));
    }

    public function accept($id, $next = false)
    {
        $expense = Expense::find($id);
        $expense->approved = 1;
        $expense->save();

        if ( $next != false ) {
            return redirect()->to('/expense/approve' . $next);
        }

        return redirect()->to('/expense/approve');

    }

    public function decline($id, $next = false)
    {
        $expense = Expense::find($id);
        $expense->approved = -1;
        $expense->save();

        if ( $next != false ) {
            return redirect()->to('/expense/approve' . $next);
        }

        // TODO Send email to teamster saying their expense godt declined

        return redirect()->to('/expense/approve');
    }

    public static function transfer() {

        // Get all non-uploaded files
        $expenses = Expense::where([
            ['uploaded', '=', 0],
            ['approved', '=', 1]
        ])->get();

        foreach ($expenses as $expense) {

            $file = $expense->file_path;

            $metadata = new Google_Service_Drive_DriveFile(array(
                'name' => File::name($file),
                'parents' => explode(",", env('DRIVE_EXPENSE_PARENT'))
            ));

            $content = Storage::get($file);

            GoogleDriveController::createFile($metadata, array(
                'data' => $content,
                'mimeType' => File::mimeType(Storage::path($file)),
                'uploadType' => 'multipart'
            ));

            $expense->uploaded = true;
            $expense->save();

        }

    }

}
