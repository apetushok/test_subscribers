<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="route" content="{{ Route::currentRouteName() }}" />

        <title>@yield('title')</title>

        <link href="/css/sb-admin-2.min.css" rel="stylesheet">
        <link href="/css/fontawesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <div id="wrapper">
            @yield('content')
        </div>
    </body>
</html>
