@extends('layouts.base')

@section('page_title', 'Dine kørsler')

@section('content')


    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="nav sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">
            <a href="/">Dine kørsler</a>
        </div>

        @if ( ($user->address == '' || $user->address == null) || ($user->license_plate == '' || $user->license_plate == null) )
            <div class="sm:w-full lg:w-3/5 mx-auto text-center bg-red-200 text-red-800 p-6 rounded-lg">
                Du har endnu ikke sat din adresse og nummerplade. Dette skal gøres før du kan registrere kørsler<br>
                Du kan tilføje det under "Opdater oplysninger" på forsiden
            </div>
        @else

            <div class="sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl">

            @if( $drives->count() === 0 )

                <div class="w-2/3 mx-auto text-2xl mt-6 p-8 bg-white rounded-lg">
                    Du har ikke registreret nogle kørsler endnu.<br><a href="/drive/create">Vil du registrere en?</a>
                </div>

            @else

                <div class="w-full bg-white mt-8 p-4 rounded-lg">
                    <table class="w-full text-left text-xl">

                        <tr>
                            <th>Dato</th>
                            <th>Fra</th>
                            <th>Til</th>
                            <th>Antal km</th>
                        </tr>

                        @foreach($drives as $drive)

                            <tr>
                                <td>{{ $drive->date->format('d/m/y') }}</td>
                                <td>{{ $drive->from }}</td>
                                <td>{{ $drive->to }}</td>
                                <td>{{ $drive->distance }}</td>
                            </tr>

                        @endforeach

                    </table>

                </div>

                <div class="p-6 rounded-lg mt-8">
                    <a href="/drive/create"><button class="mx-auto px-12 py-4 bg-orange-500 text-xl text-white rounded-lg cursor-pointer">Registrér kørsel!</button></a>
                    <button onclick="postAlert()" class="mx-auto px-12 py-4 bg-green-500 text-xl text-white rounded-lg cursor-pointer">Indsend kørebog!</button>
                </div>
            @endif

        </div>

        @endif

    </div>

    <script type="text/javascript">

        function postAlert() {

            if (confirm("Er du sikker på, at du vil indsende din kørebog? Dette kan ikke gøres om") === true) {
                window.location = '/drive/transfer';
            }
        };

    </script>

@endsection
