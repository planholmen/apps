<?php

namespace App\Http\Controllers;

use App\Expense;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();
        $count = sizeof(Expense::where([
            ['approved', '=', 0],
            ['approved_at', '=', null]
        ])->get());
        return view('home', compact('user', 'count'));
    }

    /**
     * Show the settings dashboard for admins
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings()
    {
        $user = \Auth::user();
        return view('settings', compact('user'));
    }
}
