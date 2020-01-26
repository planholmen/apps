@extends('layouts.base')

@section('page_title', 'Custom Option')

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="nav sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">
            <a href="/">Custom Option</a>
        </div>

        <div class="w-1/2 mx-auto text-center py-8 rounded-lg bg-white">

        @if( sizeof($options) === 0 )

            <p class="text-2xl">Der er ingen custom options</p>

        @else

            <table class="w-full text-left mx-4">

                <tr>
                    <th>Key</th>
                    <th>Value</th>
                </tr>

            @foreach($options as $option)

                    <tr>
                        <td>{{ $option->key }}</td>
                        <td>{{ $option->value }}</td>
                    </tr>

            @endforeach

            </table>

        @endif

        </div>

    </div>

@endsection
