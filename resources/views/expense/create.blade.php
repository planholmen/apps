@extends('layouts.base')

@section('page_title', 'Opret nyt bilag')

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">

            <div>
                Opret nyt bilag
            </div>

            <form action="/expense/store" method="post" enctype="multipart/form-data">
                @csrf
                <div class="text-2xl mt-6 text-left w-10/12 mx-auto">
                    <div class="my-8 py-4">
                        <label for="activity">Aktivitet</label>
                        <input class="w-full" type="text" name="activity">
                    </div>

                    <div class="my-8 py-4">
                        <label for="amount">Beløb</label>
                        <input class="w-full" type="number" step="any" name="amount">
                    </div>

                    <div class="my-8 py-4">
                        <input class="block mx-auto" type="file" name="file">
                    </div>

                    <div class="my-8 py-4">
                        <input type="submit" name="submit" value="Upload!">
                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
