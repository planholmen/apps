<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function settings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }

    public function update(Request $request)
    {

        $user = Auth::user();

        $user->address = $request->address;
        $user->license_plate = $request->license_plate;

        $user->save();

        return redirect()->to('/user/me');

    }
}
