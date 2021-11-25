<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset("css/fonts.css") }}">
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">

    <script src="{{ asset("js/app.js") }}" defer></script>

    <title>Maxmoll ТЗ</title>

</head>
<body>

    <div class="dashboard">

        @include('components/menu')

        @yield('content')

    </div>

</body>
</html>