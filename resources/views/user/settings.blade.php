@extends('layouts.base')

@section('page_title', 'Opdater indstillinger')

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">

            <div>
                <a href="/">Opdater oplysninger</a>
            </div>

            <form action="/user/me/update" method="post" enctype="multipart/form-data">
                @csrf
                <div class="text-2xl mt-6 text-left w-10/12 mx-auto bg-white p-4 px-8 rounded-lg">

                    <div class="my-8 py-4">
                        <label for="address">Adresse (til kørebog):</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg" type="text" name="address" value="{{ $user->address }}">
                    </div>

                    <div class="my-8 py-4">
                        <input class="block mx-auto px-12 py-4 bg-green-500 text-white rounded-lg cursor-pointer" type="submit" name="submit" value="Opdater!">
                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
