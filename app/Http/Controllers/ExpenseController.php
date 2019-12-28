<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
