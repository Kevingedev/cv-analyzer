<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Validacion</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/validators.js'])
        
        
    </head>
<body>

    <h2 class="text-center mt-4">
        AQUI SE HACE LA VALIDACION
    </h2>
    <p>Predicción: {{ $prediction }}</p>
    <p>Coincidencias: 
        @if(is_array($matches) && count($matches) > 0)
            <ul>
                @foreach($matches as $match)
                    <li>{{ $match }}</li>
                @endforeach
            </ul>
        @else
            Ninguna
        @endif
    </p>
</body>
</html>