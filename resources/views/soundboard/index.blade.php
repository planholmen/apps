@extends('layouts.base')

@section('page_title', 'Soundboard')

@section('headers')
    <script type="module" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
@endsection

@section('content')


    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="nav sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">
            <a href="/">Soundboard</a>
        </div>

        <div class="sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl">

            @if(count($sounds) == 0)

                <p class="text-center text-xl">Ingen lydeffekter... :(</p>

            @endif

            <div class="row w-3/4 mx-auto">
                <a href="/sounds/create"><button class="block mx-auto px-8 py-4 mb-4 bg-green-500 text-white text-xl rounded-lg cursor-pointer">Upload ny effekt!</button></a>
            </div>

            <div class="row w-3/4 mx-auto flex flex-wrap justify-center">

                @foreach($sounds as $sound)

                    <div class="sound w-1/4 cursor-pointer shadow p-8 px-12 mx-4 mt-8 rounded-lg" data-path="{!! $sound->web_path !!}">

                        <ion-icon name="musical-notes-outline"></ion-icon>
                        <p class="text-xl">{{ $sound->name }}</p>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

    <script type="text/javascript">

        $('body').ready(function () {

            let playing = false;

            $('.sound').click(function () {

                console.log(playing);

                if (playing !== true) {

                    let sound = new Audio($(this).data('path'));
                    sound.play();
                    playing = true;

                    sound.addEventListener('ended', function () {
                        playing = false;
                    });

                }

            });


        });

    </script>

@endsection
