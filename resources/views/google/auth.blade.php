@extends('layouts.base')

@section('page_title', 'Google Auth')

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full pb-20">

        <div class="nav sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">
            <a href="/">Google Auth</a>
        </div>

        <div class="w-3/5 mx-auto text-center">

            <div class="w-1/2 bg-orange-200 text-orange-800 rounded-lg p-8 mb-8 mx-auto text-left">
                1. Klik på nedenstående URL og log in. <br>
                2. Indtast koden i feltet nedenfor
            </div>

            <div class="w-full bg-white p-12 mx-auto">

                <div>
                    <a href="{{ $url }}" class="text-pink-600" target="_blank">{{ $url }}</a>
                </div>

                <div class="w-full pt-4">
                    <form action="/driveapi/auth/code" method="post">
                        @csrf
                        <input type="text" class="w-3/4 border-blue-200 border-2 mt-4 mb-8 rounded-lg p-4" name="auth_code">
                        <input type="submit" class="block mx-auto p-4 px-12 rounded-lg bg-green-500" value="Indsend!">
                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection
