<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ти особливий</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @filamentStyles
    @filamentScripts
</head>
<body class="bg-light-purple font-sans">

@include('blocks.header')

<main class="container mx-auto px-4 py-8">
    @yield('content')
</main>


@include('blocks.footer')
</body>
</html>
