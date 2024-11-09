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
    
    <div class="md:container md:mx-auto">
        <p class="animate__animated animate__backInUp animate__fast font-sans text-2xl sm:text-lg md:text-2xl lg:text-2xl xl:text-4xl text-center pt-4 font-bold text-cyan-300 ">
            {{ $fileName }}
        </p>
        {{-- <p>El nombre del archivo es: {{ $fileName }}</p> --}}
        <a 
        href="{{ route('validar.postulante', ['id' => $id]) }}"
        type="button" 
        class="focus:outline-none text-white bg-sky-500 hover:bg-sky-600 focus:ring-4 focus:ring-sky-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 cursor-pointer"
        >
            Validar Postulante
        </a>
        <div style="display: flex; justify-content: flex-start; align-items: flex-start; gap: 20px;" class="mt-4">
            @if($fileName)
                @if(Str::endsWith($fileName, '.pdf'))
                    <div style="flex: 1;">
                        <h2 class="text-white">Documento PDF:</h2>
                        <iframe width="100%" height="500" 
                            src="{{ asset('storage/documents/' . $fileName) }}" type="application/pdf">
                            <p>Tu navegador no soporta PDFs. <a href="{{ asset('storage/documents/' . $fileName) }}">Descargar el PDF</a>.</p>
                        </iframe>
                    </div>
                @elseif(Str::endsWith($fileName, '.doc') || Str::endsWith($fileName, '.docx'))
                    <div style="flex: 1;">
                        <h2 class="text-white">Documento Word:</h2>
                        <iframe 
                            src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('storage/documents/' . $fileName)) }}" 
                            width="100%" height="500">
                        </iframe>
                    </div>
                @endif
            @endif
        
            <!-- Columna para el texto -->
            <div style="flex: 1; padding-left: 20px;">
                <h4 class="text-white">Detalle de tu CV:</h4>
                <p class="text-white">{{ $text }}</p>
                
                {{-- <button type="button" class="">PROCESAR</button> --}}
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
            
        
        
        
        
        