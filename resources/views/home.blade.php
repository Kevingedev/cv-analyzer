<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Documeto</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/validators.js'])
        
        
    </head>
    <body class="font-sans antialiased bg-gradient-to-r from-cyan-800 to-gray-800 dark:text-white/50"> 
  
    
    
        <div class="">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 dark:bg-gray-800 dark:border-gray-700 p-6">
                    <div class="">
                        <a href="/" class="text-white text-xl font-semibold">CV Analyzer</a>
                    </div>
                    <div class="">
                        <a href="/all-documents" class="text-gray-100 hover:text-white px-3 py-2 rounded-md text-lg font-medium">
                            Documentos</a>
                    </div>
                    <div class="">
                        <a href="{{ route('import.cv') }}" class="text-gray-100 hover:text-white px-3 py-2 rounded-md text-lg font-medium">
                            Importar CV</a>
                    </div>
            </div>


            <div class="grid grid-cols-1 place-content-center content-center h-100 justify-center">
                <div>
                    <p class="animate__animated animate__backInUp animate__faster font-sans text-4xl text-center pt-8 mt-8 font-bold text-white">
                        <span class="text-4xl sm:text-5xl md:text-4xl lg:text-7xl xl:text-8xl text-cyan-300">Valida </span> el Curriculum según el
                    </p>
                    <p class="animate__animated animate__backInUp animate__fast font-sans text-4xl text-center pt-4 font-bold text-white">
                        Puesto que <span class="text-4xl sm:text-5xl md:text-4xl lg:text-7xl xl:text-8xl text-cyan-300">Tú</span> escojas.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-1 place-content-center content-center h-100 justify-center">
                <div class="w-10/12 text-center mx-auto">
                    <br><br><br>
                    <p class="animate__animated animate__backInUp font-sans text-sm sm:text-sm md:text-base lg:text-lg xl:text-xl text-center pt-8  text-white">
                        <i>"A través de un análisis inteligente del currículum utilizando redes neuronales nuestro sistema predice las áreas o los puestos con los que el postulante califica. 
                            Puedes validar el currículum con los puestos de trabajos disponibles y validar si el postulante cumple con las habilidades requeridas."</i>
                    </p>
                </div>
            </div>
        </div>
        
    
    </body>
</html>
            
        
        
        
        
        