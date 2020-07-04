<?php

namespace App\Http\Controllers;

use App\Sound;
use Illuminate\Http\Request;

class SoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sounds = Sound::all();

        return view('soundboard.index', compact('sounds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('soundboard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $this->validateRequest();
        $data['uploaded_by'] = \Auth::id();

        $data['path'] = \Storage::putFileAs('public/sounds', $request->file('file'), $request->file('file')->getClientOriginalName() . $request->file('file')->getExtension());
        unset($data['file']);

        Sound::create($data);

        return redirect()->back()->with('message', 'Lydeffekt uploadet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sound $sound)
    {
        //
    }

    private function validateRequest()
    {
        return request()->validate([
            'name' => 'required|string|min:1',
            'file' => 'required|file'
        ]);
    }
}
