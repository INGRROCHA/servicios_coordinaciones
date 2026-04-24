<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Acceso a la Mesa de Servicios, UAM-Xochimilco</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full flex flex-col min-h-screen">
  
<header class="bg-white shadow p-4 flex flex-wrap md:flex-nowrap justify-between items-center relative z-20">
    
    <div class="flex items-center justify-between w-full md:w-auto">
        <button id="btnAbrirMenu" class="md:hidden mr-4 text-gray-600 hover:text-black focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <a href="https://www.xoc.uam.mx" class="site-logo-container w-40 md:w-auto" rel="home" itemprop="url">
            <img width="300" height="80" src="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png" data-src="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png" class="default-logo lazy loaded" alt="Servicios de Cómputo UAM-X" decoding="async" data-srcset="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png 1990w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-300x80.png 300w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1024x274.png 1024w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-768x206.png 768w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1536x411.png 1536w" data-sizes="(max-width: 1990px) 100vw, 1990px" sizes="(max-width: 1990px) 100vw, 1990px" srcset="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png 1990w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-300x80.png 300w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1024x274.png 1024w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-768x206.png 768w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1536x411.png 1536w" data-was-processed="true">
        </a>
    </div>
    
    <h1 class="text-xl font-bold text-gray-900 mt-3 md:mt-0 w-full md:w-auto text-center md:text-left">Mesa de Servicios</h1>
    
    <ul class="header center hidden md:block text-sm text-right">
         <li><a><script type="text/javascript"> var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); var f=new Date(); document.write(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear()); </script></a></li>
         <li><a><script type="text/javascript"> function startTime(){ today=new Date(); h=today.getHours(); m=today.getMinutes(); s=today.getSeconds(); m=checkTime(m); s=checkTime(s); document.getElementById('reloj').innerHTML=h+":"+m+":"+s; t=setTimeout('startTime()',500);} function checkTime(i) {if (i<10) {i="0" + i;}return i;} window.onload=function(){startTime();} </script> <div id="reloj"></div></a></li>
     </ul>
  </header>

    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-4 font-sans">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full border-t-4 border-blue-700">

        <div class="text-center mb-8">
            <img src="{{ asset('imagenes/servicio.png') }}" alt="Servicios de la UAM" class="w-[120px] h-auto mx-auto mb-4">
            <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Inicia Sesión con tu Cuenta Única de Servicios</h2>
            <a href="https://cus.xoc.uam.mx/" target="_blank" rel="noopener noreferrer" class="inline-block mt-2 text-blue-600 hover:text-blue-800 text-sm font-semibold transition-colors duration-200">
                (CUS)
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login.uam') }}" class="space-y-5">
            @csrf 
            
            <div>
                <label for="IdUsuario" class="block text-sm font-semibold text-gray-700">No. Económico</label>
                <div class="mt-1">
                    <input id="IdUsuario" name="IdUsuario" type="text" required autofocus
                           value="{{ old('IdUsuario') }}" 
                           class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150"
                           placeholder="Ingresa tu No. Económico">
                </div>
            </div>

            <div>
                <label for="Password" class="block text-sm font-semibold text-gray-700">NIP (5 dígitos)</label>
                <div class="mt-1">
                    <input id="Password" name="Password" type="password" required 
                           class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150"
                           placeholder="••••••••">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 transition duration-150 ease-in-out active:scale-[0.98]">
                    Validar Acceso
                </button>
            </div>
        </form>
    </div>

    <div class="mt-10 text-center text-sm text-gray-500 space-y-2 max-w-sm">
        <p> 
            Si necesitas ayuda, no dudes en contactar a nuestro equipo de soporte,             
            <a href="mailto:rbelmont@correo.xoc.uam.mx" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline transition-colors">rbelmont@correo.xoc.uam.mx</a>
        </p>
        <p class="mt-auto pt-4 text-xs text-center text-gray-400">
                © 2026, Diseño de Sistemas, UAM-X. Todos los derechos reservados.
        </p>
    </div>

</div>
</body>
</html>
