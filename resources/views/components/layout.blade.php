<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mesa de Servicios, UAM-Xochimilco</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
  
<!-- Header -->
  <header class="bg-white shadow p-4 flex justify-between items-center">
    <a href="https://www.xoc.uam.mx" class="site-logo-container" rel="home" itemprop="url">
        <img width="300" height="80" src="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png" data-src="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png" class="default-logo lazy loaded" alt="Servicios de Cómputo UAM-X" decoding="async" data-srcset="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png 1990w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-300x80.png 300w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1024x274.png 1024w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-768x206.png 768w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1536x411.png 1536w" data-sizes="(max-width: 1990px) 100vw, 1990px" sizes="(max-width: 1990px) 100vw, 1990px" srcset="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png 1990w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-300x80.png 300w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1024x274.png 1024w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-768x206.png 768w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1536x411.png 1536w" data-was-processed="true">
    </a>
    
    <h1 class="text-xl font-bold text-black-900">Mesa de Servicios</h1>
    
    <!--Inserta la fecha y hora actuales -->
     <ul  class="header center">
          <li><a><script type="text/javascript"> var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); var f=new Date(); document.write(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear()); </script></a></li>
          <li><a><script type="text/javascript"> function startTime(){ today=new Date(); h=today.getHours(); m=today.getMinutes(); s=today.getSeconds(); m=checkTime(m); s=checkTime(s); document.getElementById('reloj').innerHTML=h+":"+m+":"+s; t=setTimeout('startTime()',500);} function checkTime(i) {if (i<10) {i="0" + i;}return i;} window.onload=function(){startTime();} </script> <div id="reloj"></div></a></li>
     </ul>
    
   
  </header>

<!-- Sidebar y contenido -->

  <div class="flex"> 
    <aside class="w-64 bg-white shadow h-screen p-4 hidden md:block">
      <nav>
        <ul>
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
        <p class="py-80 mt-auto text-xs text-center text-gray-400">
                © 2026, Diseño de Sistemas, UAM-X. Todos los derechos reservados.
        </p>
      </nav>
    </aside>

    <main class="flex-1">
        <div class="p-6">
            {{ $slot }}
        </div>   
    </main>

  </div> 
</body>
</html>