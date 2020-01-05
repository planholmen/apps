<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriveController extends Controller
{
    public function index()
    {
        $drives = Auth::user()->drives();
        return view('drive.index', compact('drives'));
    }

    public function create()
    {
        return view('drive.create');
    }

    public function store()
    {
        // Code to save the drive
    }

}
