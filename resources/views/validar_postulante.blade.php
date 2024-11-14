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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 dark:bg-gray-800 dark:border-gray-700 p-6">
        <div class="">
            <a href="/" class="text-white text-xl font-semibold">CV Analyzer</a>
        </div>
        <div class="">
            <a href="/all-documents" class="text-gray-100 hover:text-white px-3 py-2 rounded-md text-lg font-medium">
                Documentos</a>
        </div>
        <div class="">
            <a href="/import-cv" class="text-gray-100 hover:text-white px-3 py-2 rounded-md text-lg font-medium">
                Importar CV</a>
        </div>
    </div>
    <br><br><br>

    <div class="md:container md:mx-auto mt-4 pt-4 mb-4">
        <h2 class="text-center mt-4 text-3xl animate__animated animate__backInUp animate__fast mb-4">
            El Currículum {{ $result ? 'coincide' : 'no coincide' }} con un Perfil de <b>{{ $position }}</b>
            <br><span class="text-4xl font-medium">Predicción de CV Analizer: <b>"{{ $prediction }}"</b></span>
        </h2>
        <br>
        <br>
        
        {{-- <p>Predicción: {{ $prediction }}</p> --}}
            @if(count($matches) > 0 && $result)
            <div class="">
                <form action="{{ route('documents.approve', $id) }}" method="POST">
                    @csrf
                    <button type="submit" class="drop-shadow-lg transition-all ease-in duration-75 text-white bg-cyan-700 hover:bg-cyan-900 focus:outline-none focus:ring-4 focus:ring-cyan-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-900">
                        Aprobar
                    </button>
                </form>
                <h5 class="mb-2 text-gray-100">El Curriculum de esta persona coincide con ({{ count($matches) }}) 
                    habilidades encontradas obteniendo un porcentaje de aprobación estimado de <b>{{ number_format($approvalPercentage, 2) }}%
                    ({{ $approvalPercentage > 50 ? 'Aprobado' : 'Reprobado' }})</b>
                </h5>
            </div>
            <br>

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
            <div class="text-center">
                    <div class="w-100 text-cyan-300 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-h-[200px] hover:scale-105 duration-300">
                        <h5 class="mb-2 text-gray-200">El Curriculum de esta persona coincide con ({{ count($matches) }}) 
                            habilidades encontradas obteniendo un porcentaje de aprobación estimado de <b>{{ number_format($approvalPercentage, 2) }}%
                            ({{ $approvalPercentage > 50 ? 'Aprobado' : 'Reprobado' }})</b>
                        </h5>
                        <p class="text-center">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-cyan-100 text-center">Ninguna habilidad encontrada para este perfil <b>({{ $position }})</b>.</h5>
                            <br><br>
                            <a href="{{ route('documents.delete', ['id' => $id]) }}" title="Eliminar Curriculum"
                                class="drop-shadow-lg mt-4 text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                               Eliminar
                            </a>
                        </p>
                        
                    </div>
            </div>
            @endif

<br>
    </div>
</body>
</html>