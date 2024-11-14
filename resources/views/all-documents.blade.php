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
                        <a href="/import-cv" class="text-gray-100 hover:text-white px-3 py-2 rounded-md text-lg font-medium">
                            Importar CV</a>
                    </div>
            </div>
            <br><br><br>

            <div class="w-11/12 text-cyan-300 p-6 rounded-lg border-gray-200 rounded-lg shadow dark:border-gray-700 min-h-[200px] mx-auto">

                <div class="relative overflow-x-auto rounded-lg mx-auto">
                    @if (count($documents) > 0)
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-400 dark:bg-gray-400 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-bold text-white text-base">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 font-bold text-white text-base">
                                    Nombre Documento
                                </th>
                                <th scope="col" class="px-6 py-3 font-bold text-white text-base">
                                    Contenido
                                </th>
                                <th scope="col" class="px-6 py-3 font-bold text-white text-base">
                                    Puesto Aplicado
                                </th>
                                <th scope="col" class="px-6 py-3 font-bold text-white text-base">
                                    ¿Aprobado?
                                </th>
                                <th scope="col" class="px-6 py-3 font-bold text-white text-base">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th class="px-6 py-4 whitespace-nowrap text-white">
                                    {{ $document->id }}
                                </th>
                                <th class="px-6 py-4 whitespace-nowrap text-white">
                                    {{ $document->name }}
                                </th>
                                <td class="px-6 py-4 whitespace-nowrap text-white">
                                    {{ Str::limit($document->content, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-white">
                                    {{ $document->position->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-white">
                                    @if($document->approved == 1)
                                        <span class="text-green-500 font-semibold">Aprobado</span>
                                    @else
                                        <span class="text-red-500 font-semibold">No Aprobado</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-white">
                                    {{-- <a class="btn btn-icon btn-primary"></a> --}}
                                    <a href="{{ route('validar.postulante', ['id' => $document->id]) }}"
                                         class="text-white bg-cyan-700 hover:bg-cyan-800 focus:outline-none focus:ring-4 focus:ring-cyan-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-900">validar cv</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                        
                    @else
                        <p class="text-center text-xl">No se encontraron resultados</p>
                    @endif
                </div>


            </div>


            
        </div>
        @if(session('success'))
                 
            <div id="alert-message" 
                class="fixed top-4 right-4 z-50 p-4 mb-4 text-lg text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 shadow-lg" 
                role="alert">
                <span class="font-medium">Increible!</span> {{ session('success') }}
            </div>
        @endif
    </body>
</html>
            
        
        
        
        
        