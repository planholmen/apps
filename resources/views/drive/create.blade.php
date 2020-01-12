@extends('layouts.base')

@section('page_title', 'Opret ny kørsel')

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

@endsection
