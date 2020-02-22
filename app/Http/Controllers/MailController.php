<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Mail\ApprovedExpenses;
use App\Mail\NewExpenses;
use App\User;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function emailApprovedExpenses()
    {
        $expenses = Expense::where([
            ['approved_at', '>=', \Carbon\Carbon::now()->subHours(24)]
        ])->get();

        $users = [];

        foreach ($expenses as $expense) {
            if ( ! in_array($expense->user_id, $users))
                array_push($users, $expense->user_id);
        }

        foreach ($users as $userId) {

            $mailExpenses = Expense::where([
                ['user_id', $userId],
                ['approved_at', '>=', \Carbon\Carbon::now()->subHours(24)]
            ])->get();

            $user = User::find($userId);
            Mail::to($user->email)->send(new ApprovedExpenses($mailExpenses, $user));
        }

    }

    public static function emailNewExpenses()
    {
        $expenses = Expense::where('approved', 0)->get();
        $users = User::all();

        if ( ! empty($expenses) ) {

            foreach ($users as $user) {

                if ($user->isApprover())
                    Mail::to($user->email)->send(new NewExpenses($user, sizeof($expenses)));

            }

        }
    }
}
