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
    <div class="md:container md:mx-auto">
        <p class="animate__animated animate__backInUp animate__fast font-sans text-2xl sm:text-lg md:text-2xl lg:text-2xl xl:text-4xl text-center pt-4 font-bold text-cyan-300 ">
            {{ $fileName }}
        </p>
        <br><br>
        {{-- <p>El nombre del archivo es: {{ $fileName }}</p> --}}
        <a 
        href="{{ route('validar.postulante', ['id' => $id]) }}"
        type="button" 
        class="focus:outline-none text-white bg-sky-500 hover:bg-sky-600 focus:ring-4 focus:ring-sky-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 cursor-pointer"
        >
            Analizar Postulante
        </a>
        <br><br>
        <div style="display: flex; justify-content: flex-start; align-items: flex-start; gap: 20px;" class="mt-4">
            @if($fileName)
                @if(Str::endsWith($fileName, '.pdf'))
                    <div style="flex: 1;">
                        <h2 class="text-white font-bold">Documento PDF:</h2>
                        <iframe width="100%" height="500" 
                            src="{{ asset('storage/documents/' . $fileName) }}" type="application/pdf">
                            <p>Tu navegador no soporta PDFs. <a href="{{ asset('storage/documents/' . $fileName) }}">Descargar el PDF</a>.</p>
                        </iframe>
                    </div>
                @elseif(Str::endsWith($fileName, '.doc') || Str::endsWith($fileName, '.docx'))
                    <div style="flex: 1;">
                        <h2 class="text-white font-bold">Documento Word:</h2>
                        <iframe 
                            src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('storage/documents/' . $fileName)) }}" 
                            width="100%" height="500">
                        </iframe>
                    </div>
                @endif
            @endif
        
            <!-- Columna para el texto -->
            <div style="flex: 1; padding-left: 20px;">
                <h4 class="text-white font-bold">Detalle de tu CV:</h4>
                <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 h-96  overflow-hidden"
                    style="height:500px !important;">
                    <p class="text-white break-words overflow-auto" style="max-height:500px !important;">
                        {{ $text }}
                    </p>
                </div>
            </div>
        </div>
        <br>
        

    </div>
    {{-- <div class="">
        <p> Recomendaciones </p>
        <p> Sugerencias </p>
        <p> Correcciones </p>
        <p> Errores </p>
    </div> --}}
    <br>


@if(session('success'))
                 
    <div id="alert-message" 
        class="fixed top-4 right-4 z-50 p-4 mb-4 text-lg text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 shadow-lg" 
        role="alert">
        <span class="font-medium">Increible!</span> {{ session('success') }}
    </div>
@endif
</body>
</html>
            
        
        
        
        
        