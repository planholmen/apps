@extends('layouts.base')

@section('page_title', 'Opret nyt bilag')

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">

            <div>
                <a href="/">Opret nyt bilag</a>
            </div>

            <form action="/expense/store" method="post" enctype="multipart/form-data">
                @csrf
                <div class="text-2xl mt-6 text-left w-10/12 mx-auto bg-white p-4 px-8 rounded-lg">

                    <div class="my-8 py-4">
                        <label for="department">Udvalg</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg" type="text" name="department">
                    </div>

                    <div class="my-8 py-4">
                        <label for="activity">Aktivitet</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg" type="text" name="activity">
                    </div>

                    <div class="my-8 py-4">
                        <label for="amount">Beløb</label>
                        <input class="w-full border-solid border-gray-400 border-2 rounded-lg" type="number" step="any" name="amount">
                    </div>

                    <div class="my-8 py-4">
                        <input class="block mx-auto border-solid border-gray-400 border-2 rounded-lg" type="file" name="file">
                    </div>

                    <div class="my-8 py-4">
                        <input class="block mx-auto px-12 py-4 bg-green-500 text-white rounded-lg cursor-pointer" type="submit" name="submit" value="Upload!">
                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
