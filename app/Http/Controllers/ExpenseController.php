<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;

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
            'file' => 'required|mimes:jpeg,bmp,png,gif,pdf'
        ]);

        $user = Auth::user();

        //TODO File upload

        Expense::create([
           'activity' => $data->activity,
           'amount' => $data->amount,
           'creditor' => $user->name
        ]);

    }
}
