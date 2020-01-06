@extends('layouts.base')

@section('page_title', 'PLan Holmen Apps')

@section('headers')
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
@endsection

@section('content')

    <div class="main bg-gray-100 min-h-screen w-full">

        <div class="nav sm:w-full lg:w-1/2 mx-auto text-center sm:text-6xl lg:text-4xl py-12">
            <a href="/">{{ env('APP_NAME') }}</a>
        </div>

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

    </div>

@endsection
