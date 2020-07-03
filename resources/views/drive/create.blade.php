@extends('layouts.base')

@section('page_title', 'Opret ny kørsel')

@section('headers')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
@endsection

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">

            <div>
                <a href="/">Opret ny kørsel</a>
            </div>

            <form action="/drive/store" method="post" enctype="multipart/form-data">
                @csrf
                <div class="text-2xl mt-6 text-left w-10/12 mx-auto bg-white p-4 px-8 rounded-lg">

                    <div class="my-8 py-4">
                        <label for="car">Bil</label>
                        <select class="w-full border-solid border-gray-400 border-2 rounded-lg p-2" id="car" name="car" onchange="onChangeCar()">
                            <option value="" selected>Vælg venligst en bil...</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}">{{ $car->license_plate }}</option>
                            @endforeach
                            <option value="extraCar">Opret ny bil...</option>
                        </select>
                    </div>

                    <div class="my-8 py-4">
                        <label for="date">Dato</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg p-2" type="date" name="date">
                    </div>

                    <div class="my-8 py-4">
                        <label for="from">Fra</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg p-2" type="text" name="from" placeholder="Eksempelvis: Arsenalvej 10, 1436 København K">
                    </div>

                    <div class="my-8 py-4">
                        <label for="to">Til</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg p-2" type="text" name="to" placeholder="Eksempelvis: Arsenalvej 10, 1436 København K">
                    </div>

                    <div class="my-8 py-4">
                        <label for="purpose">Formål</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg p-2" type="text" name="purpose">
                    </div>

                    <div class="my-8 py-4">
                        <label for="purpose">Antal km</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg p-2" type="number" step="any" name="distance">
                    </div>

                    <div class="my-8 py-4">
                        <input class="block mx-auto px-12 py-4 bg-green-500 text-white rounded-lg cursor-pointer" type="submit" name="submit" value="Registrér!">
                    </div>

                </div>

            </form>

        </div>

    </div>


    <script type="text/javascript">

        function onChangeCar() {

            let value = $('#car option:selected').val();

            if (value == "extraCar") {
                window.location.href = '/cars/create';
            }

        }

    </script>

@endsection
