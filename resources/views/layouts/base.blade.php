<!DOCTYPE html>
<html lang="da">
    <head>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        @yield('headers')
        <title>@yield('page_title')</title>
    </head>
    <body>
        @yield('content')
    </body>
</html>
