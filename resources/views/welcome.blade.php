<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CVAnalyzer</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/validators.js'])
        
        
    </head>
    <body class="font-sans antialiased bg-gradient-to-r from-cyan-800 to-gray-800 dark:text-white/50 overflow-hidden">
    
        <div class="md:container md:mx-auto">

            <div class="grid grid-cols-1 place-content-center content-center h-100 justify-center">
                <div>
                    <p class="animate__animated animate__backInUp animate__faster font-sans text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl text-center pt-8 mt-8 font-bold text-cyan-300">
                        CV
                    </p>
                    <p class="animate__animated animate__backInUp animate__fast font-sans text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl text-center pt-4 font-bold text-cyan-300 ">
                        Analyzer
                    </p>
                </div>
                <div>
                    <p class="animate__animated animate__backInUp font-sans text-sm sm:text-sm md:text-base lg:text-lg xl:text-xl text-center pt-8  text-cyan-100">
                        <i>"Importa tu documento para analizarlo"</i>
                    </p>
                </div>
                
                <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col items-center justify-center">
                        <label class="flex items-center bg-cyan-50 text-cyan-700 rounded-full py-2 px-4 text-xs font-semibold hover:bg-cyan-100 cursor-pointer mt-20">
                            <span id="file-name" class="mr-2">Seleccionar archivo</span>
                            <input id="file-input" name="document" class="hidden" type="file" />
                        </label>
                        
                        <button 
                            
                            id="submit-button" 
                            type="submit" 
                            class="relative mt-10 inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                Guardar
                            </span>
                        </button>
                    </div>
                </form>

            </div>
            
            
            @if ($errors->any())
            <div id="alert-message" 
                class="fixed top-4 right-4 z-50 p-4 mb-4 text-lg text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 shadow-lg" 
                role="alert">
                <span class="font-medium">Ocurrio un Error!</span> 
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const fileInput = document.getElementById('file-input');
                const submitButton = document.getElementById('submit-button');
                const fileNameSpan = document.getElementById('file-name');

                // submitButton.textContent = 'Cargando...';
                fileInput.addEventListener('change', function() {
                    // Verifica si se ha seleccionado un archivo
                    if (fileInput.files.length > 0) {
                        // Obtiene el nombre del archivo
                        const fileName = fileInput.files[0].name;
                        fileNameSpan.textContent = fileName;

                        // Habilita el botón de guardar
                        submitButton.disabled = false;
                    } else {
                        // Si no se selecciona ningún archivo, deshabilita el botón
                        fileNameSpan.textContent = 'Seleccionar archivo';
                        submitButton.disabled = true;
                    }
                });
            });
        </script>
    </body>
</html>

<script>
document.getElementById('file-input').addEventListener('change', function() {
    const fileName = this.files[0] ? this.files[0].name : 'Seleccionar archivo';
    document.getElementById('file-name').textContent = fileName;
});
</script>
