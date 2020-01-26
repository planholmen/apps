@extends('layouts.base')

@section('page_title', 'Opret ny Custom Option')

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="nav sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">
            <a href="/">Opret ny Custom Option</a>
        </div>

        <div class="w-1/2 mx-auto bg-white py-8 rounded-lg">

            <form action="/options/store" method="post" class="w-full px-4 text-lg">

                @csrf

                <div class="w-3/4 mx-auto">

                    <div class="my-8 flex justify-around">
                        <label for="key" class="w-1/5 block">Key</label>
                        <div class="w-4/5 ">
                            <input type="text" name="key" class="w-full border-solid border-gray-400 border-2 rounded-lg">
                            @error('key')
                                <div class="w-full mt-1 ml-2 text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <div class="my-8 flex justify-around">
                        <label for="value" class="w-1/5 block">Value</label>
                        <div class="w-4/5">
                            <input type="text" name="value" class="w-full border-solid border-gray-400 border-2 rounded-lg">
                            @error('value')
                            <div class="w-full mt-1 ml-2 text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="my-8 mt-12">
                        <input type="submit" value="Gem!" class="block mx-auto p-8 px-20 text-white bg-green-500 rounded-lg cursor-pointer">
                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
