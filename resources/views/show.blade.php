<x-layout>
    <x-slot:heading>
        Mis Tickets
    </x-slot:heading>    
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            
        <div>
            <h2 class="font-bold text-lg text-gray-800">Mis Tickets de Servicios.</h2>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3">
                
            {{-- Verificamos si hay sesión activa mediante la variable de login --}}
            @if(session('usuario_autenticado'))
                
                {{-- CASO 1: Es Administrador --}}
                @if(session('usuario_rol') === 'admin')
                    <a href="{{ url('/tickets/index') }}" 
                       class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-slate-800 rounded-lg shadow-md hover:bg-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-300 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        Panel de Administrador
                    </a>

                {{-- CASO 2: Es Coordinador --}}
                @elseif(session('usuario_rol') === 'coordinador' && session('id_coordinacion'))
                    <a href="{{ url('/coords/' . session('id_coordinacion')) }}" 
                       class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h18" />
                        </svg>
                        Ver Tickets de mi Coordinación
                    </a>

                {{-- CASO 3: Es de Sección --}}
                @elseif(session('usuario_rol') === 'seccion' && session('id_seccion'))
                    <a href="{{ url('/seccs/' . session('id_seccion')) }}" 
                       class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-emerald-600 rounded-lg shadow-md hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A1.5 1.5 0 0019.25 21l3-3a1.5 1.5 0 000-2.12l-5.83-5.83M11.42 15.17l2.12-2.13M11.42 15.17L5.67 9.4A1.5 1.5 0 003.56 9.4l-3 3a1.5 1.5 0 000 2.12l5.83 5.83M11.42 15.17l-2.13 2.12M13.54 13.04l5.83-5.83a1.5 1.5 0 000-2.12l-3-3a1.5 1.5 0 00-2.12 0l-5.83 5.83m6.12 3.12l-2.12 2.13m-4-4l2.12-2.12" />
                        </svg>
                        Ver Tickets de mi Sección
                    </a>
                @endif

            @endif

            <a href="{{ url('/tickets/create') }}" 
               class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                </svg>
                + Nuevo Ticket
            </a>
            
        </div>
    </div>

    @livewire('ticket-search-user')

</x-layout>