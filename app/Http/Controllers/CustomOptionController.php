<?php

namespace App\Http\Controllers;

use App\CustomOption;
use Illuminate\Http\Request;

class CustomOptionController extends Controller
{
    public function index()
    {
        $options = CustomOption::all();
        return view('customoption.index', compact('options'));
    }

    public function create()
    {
        return view('customoption.create');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'key' => 'required|min:2',
            'value' => 'required|min:2'
        ]);

        $option = CustomOption::create([
            'key' => $data['key'],
            'value' => $data['value']
        ]);

    }

}
