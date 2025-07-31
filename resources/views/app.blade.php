<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBot-AI-Generate</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    {{-- Replace this in production --}}
    <link rel="stylesheet" href="{{ asset('build/assets/app-Oyg81shz.css') }}">
    <script src="{{ asset('build/assets/app-BI-zCyJ0.js') }}" defer></script>

</head>
<body class="bg-gradient-to-b from-purple-100 to-white">

    <div id="app" class="flex flex-col items-center justify-center h-screen"></div>

    <script>
        window.Laravel = {
            isLoggedIn: {{ auth()->check() ? 'true' : 'false' }},
            user: @json(auth()->check() ? auth()->user() : null)
        }
    </script>

</body>
</html>
