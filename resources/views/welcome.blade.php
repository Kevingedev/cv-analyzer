<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        
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
                        <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Analizar</button>
                    </div>
                </form>

            </div>
            @if(session('success'))
                 
                <div id="alert-message" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-medium">Success alert!</span> {{ session('success') }}
                  </div>
            @endif
            
            @if(session('error'))


                <div id="alert-message" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">Danger alert!</span> {{ session('error') }}
                  </div>
            @endif


        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
              // Selecciona el alert por ID
              const alert = document.getElementById('alert-message');
              
              if (alert) {
                // Establece un temporizador para ocultar el alert después de 4 segundos
                setTimeout(function() {
                  alert.style.opacity = '0'; // Opcional: Puedes usar esta línea para un desvanecimiento
                  alert.style.transition = 'opacity 0.5s ease-out'; // Opcional: Para un efecto de desvanecimiento
                  setTimeout(function() {
                    alert.style.display = 'none'; // Oculta el alert
                  }, 500); // Tiempo igual al de la transición
                }, 3000); // 4 segundos
              }
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
