@extends('layouts.base')

@section('page_title', 'Bilagsoversigt')

@section('headers')
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
@endsection

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="nav sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">
            <a href="/">Biler</a>
        </div>

        <div class="w-1/2 mx-auto p-6 bg-white rounded-lg">

            <table class="w-full text-left">
                <tr>
                    <th>ID</th>
                    <th>Nummerplade</th>
                    <th>Ejer</th>
                </tr>

                @foreach( $cars as $car )

                    <tr>

                        <td>{{ $car->id }}</td>
                        <td>{{ $car->license_plate }}</td>
                        <td>{{ $car->owner->name }}</td>

                    </tr>


                @endforeach

            </table>

        </div>

    </div>

@endsection
