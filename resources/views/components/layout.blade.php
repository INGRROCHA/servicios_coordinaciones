<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Mesa de Servicios, UAM-Xochimilco</title>
  @livewireStyles
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
    
    <div class="bg-blue-50 p-4 rounded-lg mb-6">
        <p class="text-blue-800">
            <strong>Usuario:</strong> {{ session('nombre_completo') }} 
            <strong>,   No. Económico:</strong> {{ session('no_economico') }}
        </p>
    </div>

    <ul class="header center hidden md:block text-sm text-right">
         <li><a><script type="text/javascript"> var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); var f=new Date(); document.write(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear()); </script></a></li>
         <li><a><script type="text/javascript"> function startTime(){ today=new Date(); h=today.getHours(); m=today.getMinutes(); s=today.getSeconds(); m=checkTime(m); s=checkTime(s); document.getElementById('reloj').innerHTML=h+":"+m+":"+s; t=setTimeout('startTime()',500);} function checkTime(i) {if (i<10) {i="0" + i;}return i;} window.onload=function(){startTime();} </script> <div id="reloj"></div></a></li>
    </ul>

    @if(session('usuario_autenticado'))
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" 
                    class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-red-600 rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                
                Salir
            </button>
        </form>    
    @endif
   

</header>

    <main class="flex-1 p-6 overflow-auto">
    
      {{ $slot }}   
    @livewireScripts
</body>
</html>