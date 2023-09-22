<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Weather App') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        body {
            background-image: url('{{ asset('img/wallpaper.png') }}');
            object-fit: cover;
        }

        @media (max-width: 768px) {
            body {
                background-image: url('{{ asset('img/wallpaper-mobile.png') }}');
                background-size: cover;
                background-repeat: no-repeat;
            }
        }

        /* Use the original wallpaper photo for larger screens */
        @media (min-width: 769px) {
            body {
                background-image: url('{{ asset('img/wallpaper.png') }}');
            }
        }
        
    </style>
</head>

<body>
    @yield('content')
</body>

</html>

</html>
