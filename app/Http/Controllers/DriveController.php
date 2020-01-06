<?php

namespace App\Http\Controllers;

use App\Drive;
use App\Expense;
use App\Jobs\PostDriveBook;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriveController extends Controller
{
    public function index()
    {
        $drives = Auth::user()->drives->where('posted', false);
        return view('drive.index', compact('drives'));

        // TODO Remove or grey-out currently being processed.
    }

    public function create()
    {
        return view('drive.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'from' => 'required|min:2',
            'to' => 'required|min:2',
            'purpose' => 'required|min:2',
            'distance' => 'required'
        ]);

        Drive::create([
           'date' => $data['date'],
           'from' => $data['from'],
           'to' => $data['to'],
           'purpose' => $data['purpose'],
           'distance' => round($data['distance'], 0),
           'user_id' => Auth::id()
        ]);

        return redirect()->to('/drive');

    }

    /**
     * Method to post an array of drives
     * Input can be either an instance of App\Drive or the id of the drive
     * @param $drives
     */
    public static function post($drives)
    {
        foreach ($drives as $drive) {
            if ($drive instanceof Drive) {
                $drive->posted = true;
                $drive->save();
            } else {
                $drive = Drive::find($drive);
                $drive->save();
            }
        }
    }

    public function transfer()
    {

        $user = Auth::user();
        $drives = $user->drives->where('posted', false);

        if ($drives->count() == 0) {
            return;
        }

        PostDriveBook::dispatch($drives);

        return redirect()->to('/drive');

    }

    public static function unposted()
    {
        return Drive::where('posted', false)->get();
    }

}
