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


            <div class="md:container md:mx-auto">
                <p class="animate__animated animate__backInUp animate__fast font-sans text-2xl sm:text-lg md:text-2xl lg:text-2xl xl:text-4xl text-center pt-4 font-bold text-cyan-300 ">
                    {{ $document->name }}
                </p>
                <br>
                {{-- <p>El nombre del archivo es: {{ $fileName }}</p> --}}
                <div style="display: flex; justify-content: flex-start; align-items: flex-start; gap: 20px;" class="">
                    @if($document->name)
                        @if(Str::endsWith($document->name, '.pdf'))
                            <div style="flex: 1;">
                                <h2 class="text-white font-bold">Documento PDF:</h2>
                                <iframe width="100%" height="500" 
                                    src="{{ asset('storage/documents/' . $document->name) }}" type="application/pdf">
                                    <p>Tu navegador no soporta PDFs. <a href="{{ asset('storage/documents/' . $document->name) }}">Descargar el PDF</a>.</p>
                                </iframe>
                            </div>
                        @elseif(Str::endsWith($document->name, '.doc') || Str::endsWith($document->name, '.docx'))
                            <div style="flex: 1;">
                                <h2 class="text-white font-bold">Documento Word:</h2>
                                <iframe 
                                    src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('storage/documents/' . $document->name)) }}" 
                                    width="100%" height="500">
                                </iframe>
                            </div>
                        @endif
                    @endif
                
                </div>
                <br>
                
        
            </div>

    </body>
</html>
            
        
        
        
        
        