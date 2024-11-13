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
<body class="font-sans bg-gradient-to-r from-cyan-800 to-gray-800 text-cyan-300"> 

    <div class="md:container md:mx-auto mt-4 pt-4 mb-4">
        <h2 class="text-center mt-4 text-3xl animate__animated animate__backInUp animate__fast mb-4">
            El Curriculum pertenece a un Perfil <br><b><span class="text-5xl">"{{ $prediction }}"</span></b>
        </h2>
        <br>
        {{-- <p>Predicción: {{ $prediction }}</p> --}}
            @if(count($matches) > 0)

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($matches as $match)
                    <div class="w-11/12 text-cyan-300 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-h-[200px] hover:scale-105 duration-300">
                        <p>
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-cyan-100">{{ $match->name }}</h5>
                        </p>
                        <p class="mb-3 font-normal text-gray-400 mt-4">{{ $match->description ? $match->description : 'N/A' }}</p>
                    </div>
                @endforeach
            </div>



                {{-- @foreach($matches as $match)

                <div class="max-w-xs p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $match->name }}</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">N/A</p>
                    
                </div>

                @endforeach --}}
            @else
                Ninguna
            @endif

<br>
    </div>
</body>
</html>