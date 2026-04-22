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

    <main class="flex-1 overflow-y-auto flex items-center justify-center">
        // 

            <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8 m-6">
                <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Inicia Sesión con tu Cuenta Única de Servicios </h2>
                <a href="https://cus.xoc.uam.mx/" target="_blank" rel="noopener noreferrer" class="recover-nip-link"><p style="text-align:center">(CUS)</a></p>
                <div id="loginAlert" hidden class="mb-4 p-4 rounded text-sm text-white bg-red-500 transition-all">
                    <span id="loginAlertMsg"></span>
                </div>

                <form id="loginForm" novalidate>
                    <div class="mb-4">
                        <label for="num_eco" class="block text-sm font-medium text-gray-700">No. Económico</label>
                        <input type="text" id="num_eco" name="num_eco" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ingresa tu No. Económico">
                        <span id="num_ecoError" class="text-xs text-red-500 mt-1 block"></span>
                    </div>

                    <div class="mb-6">
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP (5 dígitos)</label>
                        <div class="relative mt-1">
                            <input type="password" id="nip" name="nip" class="block w-full border border-gray-300 rounded-md p-2 pr-10 focus:ring-blue-500 focus:border-blue-500" placeholder="•••••" maxlength="5">
                            <button type="button" id="toggleNip" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700" aria-label="Mostrar NIP">
                                <svg id="nipEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                        <span id="nipError" class="text-xs text-red-500 mt-1 block"></span>
                    </div>

                    <button type="submit" id="btnAcceder" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex justify-center items-center disabled:opacity-50">
                        <span class="btn-text">Entrar</span>
                        <svg hidden class="btn-spinner animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                </form>
            </div>

            <script>
            (function () {
                'use strict';

                // Asegúrate de que esta ruta coincida con tu web.php o api.php
                const API_URL = '/login';

                /* ── Referencias al DOM ───────────────────────── */
                const form         = document.getElementById('loginForm');
                const btnAcceder   = document.getElementById('btnAcceder');
                const btnText      = btnAcceder.querySelector('.btn-text');
                const btnSpinner   = btnAcceder.querySelector('.btn-spinner');
                const alertBox     = document.getElementById('loginAlert');
                const alertMsg     = document.getElementById('loginAlertMsg');
                const num_ecoIn  = document.getElementById('num_eco');
                const nipIn        = document.getElementById('nip');
                const toggleNip    = document.getElementById('toggleNip');
                const nipEyeIcon   = document.getElementById('nipEyeIcon');

                /* ── Mostrar / ocultar NIP ───────────────────── */
                toggleNip.addEventListener('click', () => {
                    const isPassword = nipIn.type === 'password';
                    nipIn.type = isPassword ? 'text' : 'password';
                    toggleNip.setAttribute('aria-label', isPassword ? 'Ocultar NIP' : 'Mostrar NIP');
                });

                /* ── Limpiar errores al escribir ─────────────── */
                num_ecoIn.addEventListener('input', () => clearFieldError('num_eco'));
                nipIn.addEventListener('input', () => {
                    nipIn.value = nipIn.value.replace(/\D/g, '').slice(0, 5);
                    clearFieldError('nip');
                });

                /* ── Validación local ────────────────────────── */
                function validate() {
                    let ok = true;
                    if (!num_ecoIn.value.trim()) {
                        showFieldError('num_eco', 'Este campo es obligatorio.');
                        ok = false;
                    }
                    const nip = nipIn.value.trim();
                    if (!nip) {
                        showFieldError('nip', 'Este campo es obligatorio.');
                        ok = false;
                    } else if (!/^\d{5}$/.test(nip)) {
                        showFieldError('nip', 'El NIP debe tener exactamente 5 dígitos.');
                        ok = false;
                    }
                    return ok;
                }

                /* ── Helpers de UI ───────────────────────────── */
                function showFieldError(field, msg) {
                    const input = document.getElementById(field);
                    const error = document.getElementById(field + 'Error');
                    input.classList.add('border-red-500'); // Estilo de error Tailwind
                    error.textContent = msg;
                }

                function clearFieldError(field) {
                    const input = document.getElementById(field);
                    const error = document.getElementById(field + 'Error');
                    input.classList.remove('border-red-500');
                    error.textContent = '';
                }

                function showAlert(msg, type = 'error') {
                    // Cambia el color si es éxito o error
                    alertBox.className = type === 'success' ? 'mb-4 p-4 rounded text-sm text-white bg-green-500 transition-all' : 'mb-4 p-4 rounded text-sm text-white bg-red-500 transition-all';
                    alertMsg.textContent = msg;
                    alertBox.hidden = false;
                }

                function hideAlert() { alertBox.hidden = true; }

                function setLoading(loading) {
                    btnAcceder.disabled = loading;
                    btnText.hidden = loading;
                    btnSpinner.hidden = !loading;
                }

                /* ── Envío del formulario ────────────────────── */
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    hideAlert();

                    if (!validate()) return;

                    setLoading(true);

                    try {
                        const response = await fetch(API_URL, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                // CAMBIO PARA LARAVEL: Busca el meta tag en el <head>
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                num_eco : num_ecoIn.value.trim(),
                                nip       : nipIn.value.trim()
                            })
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            showAlert('Acceso concedido. Redirigiendo...', 'success');
                            setTimeout(() => {
                                window.location.href = data.redirect ?? '/'; // Redirige a la ruta principal
                            }, 800);
                        } else {
                            showAlert(data.message ?? 'Matrícula o NIP incorrectos. Intenta de nuevo.');
                        }

                    } catch (err) {
                        console.error('Error de conexión:', err);
                        showAlert('No se pudo conectar al servidor. Verifica tu conexión e intenta de nuevo.');
                    } finally {
                        setLoading(false);
                    }
                });

            })();
            </script>    
        // 
        
        @auth
            <div class="p-6 w-full h-full">
               {{ $slot }}
            </div> 
        
            <form method="POST" action="/logout">
                @csrf  
                @method('DELETE')
                    <button type="submit" id="btnAcceder" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex justify-center items-center disabled:opacity-50">
                        <span class="btn-text">Salir</span>
                        <svg hidden class="btn-spinner animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
            </form>
        @endauth

  </div> 

  <script>
      const sidebar = document.getElementById('sidebar');
      const fondoMenu = document.getElementById('fondoMenu');
      const btnAbrirMenu = document.getElementById('btnAbrirMenu');
      const btnCerrarMenu = document.getElementById('btnCerrarMenu');

      function alternarMenu() {
          sidebar.classList.toggle('-translate-x-full'); // Muestra/Oculta el panel
          fondoMenu.classList.toggle('hidden');          // Muestra/Oculta el fondo oscuro
      }

      btnAbrirMenu.addEventListener('click', alternarMenu);
      btnCerrarMenu.addEventListener('click', alternarMenu);
      fondoMenu.addEventListener('click', alternarMenu); // Cierra el menú al tocar el fondo oscuro
  </script>

</body>
</html>