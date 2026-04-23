<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Mesa de Servicios, UAM-Xochimilco</title>
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

  <div class="flex flex-1 relative overflow-hidden"> 
    
    <div id="fondoMenu" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 flex-shrink-0 bg-white shadow h-full transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:flex md:flex-col p-4">
      
      <button id="btnCerrarMenu" class="md:hidden absolute top-4 right-4 text-gray-500 hover:text-red-500">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>

      <nav class="flex flex-col h-full mt-8 md:mt-0">
        <ul class="flex-1">
          <li class="mb-4">
              <x-nav-link href="/" :active="request()->is('/')">Inicio</x-nav-link>
          </li>
          <li class="mb-4">
              <x-nav-link href="/tickets/create" :active="request()->is('tickets/create')">Levantar Ticket</x-nav-link>
          </li>
          <li class="mb-4">
              <x-nav-link href="/tickets/index" :active="request()->is('tickets/index')">Consultar Ticket</x-nav-link>
          </li>
          <li class="mb-4">
              <x-nav-link href="/tickets/show" :active="request()->is('tickets/show*')">BD de Tickets</x-nav-link>
          </li>
          <li>
              <x-nav-link href="/acerca" :active="request()->is('acerca')">Acerca</x-nav-link>
          </li>
        </ul>
        <p class="mt-auto pt-4 text-xs text-center text-gray-400">
                © 2026, Diseño de Sistemas, UAM-X. Todos los derechos reservados.
        </p>
      </nav>
    </aside>

    <main class="flex-1 p-6 overflow-auto">
      {{ $slot }}   

</body>
</html>