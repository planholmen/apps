@extends('layouts.base')

@section('page_title', 'Dine kørsler')

@section('content')


    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">

            <div>
                <a href="/">Dine kørsler</a>
            </div>

            @if( $drives->count() === 0 )

                <div class="w-2/3 mx-auto text-2xl mt-6 p-8 bg-white rounded-lg">
                    Du har ikke registreret nogle kørsler endnu.<br><a href="/drive/create">Vil du registrere en?</a>
                </div>

            @else

                <table>

                    <tr>
                        <th>Dato</th>
                        <th>Fra</th>
                        <th>Til</th>
                        <th>Antal km</th>
                    </tr>

                    @foreach($drives as $drive)

                        <tr>
                            <td>{{ $drive->date }}</td>
                            <td>{{ $drive->from }}</td>
                            <td>{{ $drive->Til }}</td>
                            <td>{{ $drive->distance }}</td>
                        </tr>

                    @endforeach

                </table>

            @endif

        </div>

    </div>

@endsection
