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

    </div>

    <script type="text/javascript">

        function postAlert() {

            if (confirm("Er du sikker på, at du vil indsende din kørebog? Dette kan ikke gøres om") === true) {
                window.location = '/drive/post';
            }
        };

    </script>

@endsection
