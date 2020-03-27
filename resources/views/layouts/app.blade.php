<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="/css/styles.css">


        <title>Laravel</title>

    </head>
    <body>
    <div class="wrapper" id = "app">
        <header class="header container">

            <div class="header_block">
                <div class="header_name">т о р т у г а </div>
                <div class="header_logo">
                    <img class="header_logo-img" src="/images/logo.png" alt="">
                </div>
                <div class="header_name">т е й б л с</div>
            </div>

        </header>
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}" > </script>
    </body>
</html>
