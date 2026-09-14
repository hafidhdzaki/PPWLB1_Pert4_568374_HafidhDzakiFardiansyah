<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'Portfolio | Hafidh Dzaki Fardiansyah')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    @include('partials.navbar')

    <main style="min-height: 80vh; padding: 20px;">
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>