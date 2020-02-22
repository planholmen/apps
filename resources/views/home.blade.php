@extends('layouts.base')

@section('page_title', 'Dashboard')

@section('headers')
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
@endsection

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full pb-20">

        @guest

            <div class="w-full min-h-screen flex items-center justify-center">

                <div>
                    <a href="/login"><button class="px-20 py-8 rounded-lg text-white bg-pink-400">Login!</button></a>
                </div>

            </div>

        @endguest

        @auth

        <div class="nav sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">
            <a href="/">{{ env('APP_NAME') }}</a>
        </div>

        @if ( ($user->address == '' || $user->address == null) || ($user->license_plate == '' || $user->license_plate == null) )
            <div class="sm:w-full lg:w-3/5 mx-auto text-center bg-red-200 text-red-800 p-6 rounded-lg">
                Du har endnu ikke sat din adresse og nummerplade. Hvis du vil registrere kørsler og indsende en kørebog, skal dette tilføjes først.<br>
                Du kan tilføje det under "Opdater oplysninger"
            </div>
        @endif

        @if ($count > 0 && Gate::inspect('accessApprovals', $user)->allowed())
            <div class="sm:w-full lg:w-1/2 mx-auto bg-orange-100 border-t-4 border-orange-500 rounded-b text-orange-900 px-4 py-3 mb-6 shadow-md" role="alert">
                <div class="flex items-center">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-orange-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                        <p class="font-bold">Der er {{ $count }} bilag, der venter på at blive godkendt.</p>
                    </div>
                </div>
            </div>
        @endif

        @component('components.module')
            @slot('link', '/expense/create')
            @slot('icon', 'copy')
            @slot('text', 'Upload bilag')
        @endcomponent

        @component('components.module')
            @slot('link', '/drive')
            @slot('icon', 'car')
            @slot('text', 'Se kørsler')
        @endcomponent

        @component('components.module')
            @slot('link', '/user/me')
            @slot('icon', 'person')
            @slot('text', 'Opdater oplysninger')
        @endcomponent

        @component('components.module')
            @slot('link', 'http://mandskab.planholmen.dk')
            @slot('icon', 'people')
            @slot('text', 'Se mandskabsplan')
        @endcomponent

        @if ( Gate::inspect('accessApprovals', $user)->allowed() )

        <div class="mt-8 pl-3 lg:w-1/3 sm:w-5/6 mx-auto text-gray-600">
            Økonomi
        </div>

        @component('components.module')
            @slot('link', '/expense/approve')
            @slot('icon', 'cash')
            @slot('text', 'Godkend bilag')
        @endcomponent

        @component('components.module')
            @slot('link', '/expenses')
            @slot('icon', 'filing')
            @slot('text', 'Bilagsoversigt')
        @endcomponent

        @endif

        @if ( Gate::inspect('accessAdmin', $user)->allowed() )

        <div class="mt-8 pl-3 lg:w-1/3 sm:w-5/6 mx-auto text-gray-600">
            Admin
        </div>

        @component('components.module')
            @slot('link', '/queue')
            @slot('icon', 'hammer')
            @slot('text', 'Opgaveliste')
        @endcomponent

        @component('components.module')
            @slot('link', '/settings')
            @slot('icon', 'settings')
            @slot('text', 'Indstillinger')
        @endcomponent

        @endif

        @endauth

    </div>

@endsection
