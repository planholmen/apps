@extends('layouts.base')

@section('page_title', 'Dashboard')

@section('headers')
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
@endsection

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full pb-20">

        @auth

            <div class="nav sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">
                <a href="/">Indstillinger</a>
            </div>


            @if ( Gate::inspect('accessAdmin', $user)->allowed() )

                <div class="mt-8 pl-3 lg:w-1/3 sm:w-5/6 mx-auto text-gray-600">
                    Google
                </div>

                @component('components.module')
                    @slot('link', '/driveapi/auth')
                    @slot('icon', 'logo-google')
                    @slot('text', 'Google Auth')
                @endcomponent

                <div class="mt-8 pl-3 lg:w-1/3 sm:w-5/6 mx-auto text-gray-600">
                    Custom Options
                </div>

                @component('components.module')
                    @slot('link', 'settings/options')
                    @slot('icon', 'options')
                    @slot('text', 'Se Custom Options')
                @endcomponent

                @component('components.module')
                    @slot('link', 'settings/options/create')
                    @slot('icon', 'options')
                    @slot('text', 'Opret ny Custom Option')
                @endcomponent

            @endif

        @endauth

    </div>

@endsection
