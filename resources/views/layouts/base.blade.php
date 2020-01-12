<!DOCTYPE html>
<html lang="da">
    <head>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        @yield('headers')
        <title>@yield('page_title')</title>
    </head>
    <body>
        <div class="w-full bg-gray-100 py-2">
            <div class="pl-8">
                <a href="/auth/logout">{{ Auth::user()->name }}</a>
            </div>
        </div>
        @yield('content')
    </body>
</html>
