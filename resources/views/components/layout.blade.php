<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/app/favicon.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    @yield('css')
</head>

<body>
    @include('include.header')
    @yield('content')
    @yield('script')
    <script src={{ asset('js/header/burgerMenuHandling.js') }}></script>
</body>

</html>
