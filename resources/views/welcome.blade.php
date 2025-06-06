       <!DOCTYPE html>
       <html lang="es">

       <head>
           <meta charset="UTF-8">
           <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <title>Laravel + Vue.js</title>
           @if (!app()->environment('testing'))
            @vite('resources/js/main.js')
        @endif
       </head>

       <body>
           <div id="app"></div> <!-- Aquí montamos la aplicación Vue -->
       </body>

       </html>
