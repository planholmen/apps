<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    public function index()
    {
        $jobs = DB::table('jobs')->get();

        return view('jobs.index', compact('jobs'));
    }
}
