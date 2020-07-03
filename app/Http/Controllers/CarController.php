<?php

namespace App\Http\Controllers;

use App\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function index()
    {
        $cars = Car::all();

        return view('car.index', compact('cars'));
    }

    public function create()
    {
        return view('car.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest();
        $data['owner_id'] = \Auth::id();

        Car::create($data);

        return redirect()->back();
    }

    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);

        $data = $this->validateRequest();

        $car->update($data);

        return redirect()->back();
    }

    private function validateRequest()
    {
        return request()->validate([
            'license_plate' => 'required|string|min:6'
        ]);
    }

}
