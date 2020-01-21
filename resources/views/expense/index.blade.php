@extends('layouts.base')

@section('page_title', 'Bilagsoversigt')

@section('headers')
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
@endsection

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="nav sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">
            <a href="/">Bilagsoversigt</a>
        </div>

        <div class="w-1/2 mx-auto p-6 bg-white rounded-lg">

            <table class="w-full text-left">
                <tr>
                    <th>ID</th>
                    <th>Udlægsholder</th>
                    <th>Udvalg</th>
                    <th>Aktivitet</th>
                    <th>Godkendt?</th>
                </tr>

                @foreach( $expenses as $expense )

                    <tr>

                        <td>{{ $expense->ph_id }}</td>
                        <td>{{ $expense->creditor }}</td>
                        <td>{{ $expense->department }}</td>
                        <td>{{ $expense->activity }}</td>
                        <td class="text-lg">
                            @if ( $expense->approved == 1 )
                                <ion-icon class="text-green-500" name="checkmark"></ion-icon>
                            @elseif ( $expense->approved == 0 )
                                <ion-icon class="text-orange-500" name="help"></ion-icon>
                            @elseif ( $expense->approved == -1 )
                                <ion-icon class="text-red-500" name="close"></ion-icon>
                            @endif
                        </td>

                    </tr>


                @endforeach

            </table>

        </div>

    </div>

@endsection
