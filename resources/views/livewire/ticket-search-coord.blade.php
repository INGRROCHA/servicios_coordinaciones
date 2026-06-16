<div>

    <div class="px-8 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="w-full md:w-1/4">
            <input wire:model.live="search" 
                type="text" 
                placeholder="🔍 Buscar por # de ticket, coordinación..." 
                class="w-full p-4 border-2 border-blue-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
        </div>

        <div class="flex flex-wrap gap-2 items-center">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 mr-1">Filtrar por:</span>
            
            {{-- Filtros por Sección Dinámicos --}}
            @if($secciones && $secciones->count() > 0)
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500 mr-1 md:ml-4">Sección:</span>
                
                <button wire:click="setSeccionFilter(null)" 
                        class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                        {{ is_null($seccionId) ? 'bg-teal-600 text-white border-teal-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                    Todas
                </button>

                @foreach($secciones as $seccion)
                    <button wire:click="setSeccionFilter({{ $seccion->id_seccion }})" 
                            class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                            {{ $seccionId == $seccion->id_seccion ? 'bg-teal-600 text-white border-teal-600' : 'bg-teal-50 text-teal-800 border-teal-200 hover:bg-teal-100' }}">
                        {{ $seccion->seccion }}
                    </button>
                @endforeach
            @endif
            
            {{-- Filtros por Estado --}}
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 md:ml-4 mr-1">Estado:</span>
            <button wire:click="setEstadoFilter(null)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ is_null($selectedEstado) ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                Todos
            </button>

            <button wire:click="setEstadoFilter(1)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ $selectedEstado == 1 ? 'bg-blue-600 text-white border-blue-600' : 'bg-blue-50 text-blue-800 border-blue-200 hover:bg-blue-100' }}">
                Abiertos
            </button>

            <button wire:click="setEstadoFilter(2)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ $selectedEstado == 2 ? 'bg-yellow-500 text-white border-yellow-500' : 'bg-yellow-50 text-yellow-800 border-yellow-200 hover:bg-yellow-100' }}">
                En Proceso
            </button>

            <button wire:click="setEstadoFilter(4)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ $selectedEstado == 4 ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-indigo-50 text-indigo-800 border-indigo-200 hover:bg-indigo-100' }}">
                Asignados
            </button>

            <button wire:click="setEstadoFilter(5)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ $selectedEstado == 5 ? 'bg-purple-600 text-white border-purple-600' : 'bg-purple-50 text-purple-800 border-purple-200 hover:bg-purple-100' }}">
                Reasignados
            </button>

            <button wire:click="setEstadoFilter(3)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ $selectedEstado == 3 ? 'bg-red-600 text-white border-red-600' : 'bg-red-50 text-red-800 border-red-200 hover:bg-red-100' }}">
                Cancelados
            </button>

            <button wire:click="setEstadoFilter(9)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ $selectedEstado == 9 ? 'bg-green-600 text-white border-green-600' : 'bg-green-50 text-green-800 border-green-200 hover:bg-green-100' }}">
                Realizados
            </button>
        </div>
    </div>

<!-- Tabla de Resultados -->
<div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="table min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr class="bg-gray-200 text-black text-xs font-semibold uppercase tracking-wider">
                    <th wire:click="setSort('id_ticket')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">
                            # Ticket
                            @if ($sortBy !== 'id_ticket')
                                <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc')
                                <span class="ml-1">↑</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </div>
                    </th>
                    <th wire:click="setSort('nombre_seccion')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">
                            Sección
                            @if ($sortBy !== 'nombre_seccion')
                                <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc')
                                <span class="ml-1">↑</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </div>
                    </th>
                    <th wire:click="setSort('nombre_servicio')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">
                            Tipo de Servicio Solicitado
                            @if ($sortBy !== 'nombre_servicio') <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc')
                                <span class="ml-1">↑</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </div>
                    </th>
                    <th wire:click="setSort('adscripcion')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">
                            Adscripción
                            @if ($sortBy !== 'adscripcion')
                                <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc')
                                <span class="ml-1">↑</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </div>
                    </th>
                    <th wire:click="setSort('dpto_coord')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">
                            Coordinación Administrativa o Departamento Académico
                            @if ($sortBy !== 'dpto_coord')
                                <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc')
                                <span class="ml-1">↑</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </div>
                    </th>						
                    <th wire:click="setSort('area_secc')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">
                            Área Académica o Sección Administrativa
                            @if ($sortBy !== 'area_secc')
                                <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc')
                                <span class="ml-1">↑</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </div>
                    </th>
                    <th wire:click="setSort('descripcion')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">
                            Descripción
                            @if ($sortBy !== 'descripcion')
                                <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc')
                                <span class="ml-1">↑</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </div>
                    </th>
                    <th wire:click="setSort('estado')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">
                            Estatus
                            @if ($sortBy !== 'estado')
                                <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc')
                                <span class="ml-1">↑</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </div>
                    </th>
                    <th wire:click="setSort('created_at')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">
                            Fecha de Creación
                            @if ($sortBy !== 'created_at')
                                <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc')
                                <span class="ml-1">↑</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </div>
                    </th>

                    <th class="px-6 py-4 text-center">Acciones</th>
            </tr>
        </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-xs">{{ $ticket->id_ticket }}</td>
                    <td class="px-6 py-4 text-xs">{{ $ticket->seccion?->seccion ?? 'Sin sección' }}</td>           
                    <td class="px-6 py-4 text-xs">{{ $ticket->servicio?->servicio ?? 'Sin servicio' }}</td>
                    <td class="px-6 py-4 text-xs">{{ $ticket->adscripcion ?? 'Sin dato' }}</td>
                    <td class="px-6 py-4 text-xs">{{ $ticket->dpto_coord ?? 'Sin dato' }}</td>
                    <td class="px-6 py-4 text-xs">{{ $ticket->area_secc ?? 'Sin dato' }}</td>
                    <td class="px-6 py-4 text-xs">{{ $ticket->descripcion }}</td>
                    <!-- Estado -->
                    <td class="px-6 py-4">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->estado_color }}">
                            {{ $ticket->estado_nombre }}
                        </span>
                    </td>
                    <!--  -->
                    <td class="px-6 py-4 text-xs text-gray-800">{{ $ticket->created_at }}</td>
                    <td class="px-6">
                        <div class="flex items-center">

                            <button wire:click.prevent="verHistorial({{ $ticket->id_ticket }})" class="flex-shrink-0 cursor-pointer transition transform hover:scale-110 focus:outline-none"> 
                                <img src="{{ asset('imagenes/history-blue.png') }}" alt="Ver Historial" title="Ver Detalles e Historial" class="w-[30px] h-[30px] object-contain">
                            </button>
                            <a href="/tickets/{{ $ticket->id_ticket }}/editar" class="flex-shrink-0 cursor-pointer transition transform hover:scale-110 focus:outline-none"> 
                                <img src="{{ asset('imagenes/edit.png') }}" alt="Editar" title="Editar Ticket" class="w-[30px] h-[30px] object-contain">
                            </a>
                            <button wire:click.prevent="verPdf({{ $ticket->id_ticket }})" class="flex-shrink-0 cursor-pointer transition transform hover:scale-110 focus:outline-none">
                                <img src="{{ asset('imagenes/view.png') }}" alt="Ver PDF" title="Ver PDF" class="w-[30px] h-[30px] object-contain">
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            No se encontraron tickets con "{{ $search }}"
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex items-center gap-2">
        <label class="text-sm font-medium text-gray-600">Mostrar:</label>
        <select wire:model.live="perPage" class="p-2 border-2 border-blue-200 rounded-lg focus:border-blue-500 outline-none">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        <span class="text-sm text-gray-600">registros</span>
    </div>


    <div class="mt-4">
        {{ $tickets->links('vendor.pagination.tailwind') }}
    </div>

    <!-- Modal para Historial -->
|   @if($mostrarModal && $ticketSeleccionado)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div wire:click="cerrarModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity cursor-pointer" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-gray-100 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border-t-4 border-blue-700">
                
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button wire:click="cerrarModal" type="button" class="bg-gray-100 rounded-md text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Cerrar panel</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="px-6 pt-5 pb-6 overflow-y-auto max-h-[85vh]">
                    
                    <h3 class="text-xl leading-6 font-bold text-gray-900 mb-4 border-b pb-2">
                        Consulta de Ticket #{{ $ticketSeleccionado->id_ticket }}
                    </h3>

                    <div class="card mb-3 shadow-sm bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="card-body p-0 sm:p-2">
                            <table class="table mb-0 w-full text-sm text-left text-gray-600 table-fixed">
                                <tbody class="divide-y divide-gray-100">
                                    <tr>
                                        <th style="width: 35%;" class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50"># de Ticket</th>
                                        <td style="width: 65%;" class="py-3 px-4 font-bold text-blue-700">{{ $ticketSeleccionado->id_ticket }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Número Económico</th>
                                        <td class="py-3 px-4">{{ $ticketSeleccionado->num_economico }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Coordinación</th>
                                        <td class="py-3 px-4 text-gray-800 font-medium">{{ $ticketSeleccionado->coordinacion->coordinacion ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Sección</th>
                                        <td class="py-3 px-4 text-gray-800 font-medium">{{ $ticketSeleccionado->seccion->seccion ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Servicio Solicitado</th>
                                        <td class="py-3 px-4">{{ $ticketSeleccionado->servicio->servicio ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Descripción</th>
                                        <td class="py-3 px-4 whitespace-pre-line text-justify">{{ $ticketSeleccionado->descripcion }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Estatus</th>
                                        <td class="py-3 px-4">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full shadow-sm {{ $ticketSeleccionado->estado_color }}">
                                                {{ $ticketSeleccionado->estado_nombre }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Trabajador Asignado</th>
                                        <td class="py-3 px-4">{{ $ticketSeleccionado->trabajadores->nombre ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Fecha de Creación</th>
                                        <td class="py-3 px-4 text-gray-500">{{ $ticketSeleccionado->created_at->format('d/m/Y h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Observaciones</th>
                                        <td class="py-3 px-4 whitespace-pre-line text-justify">{{ $ticketSeleccionado->observaciones ?: 'Sin observaciones.' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Última actualización</th>
                                        <td class="py-3 px-4 text-gray-500">{{ $ticketSeleccionado->updated_at->format('d/m/Y h:i A') }}</td> 
                                    </tr>  
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($ticketSeleccionado->activities && $ticketSeleccionado->activities->count() > 0)
                        <div class="mt-6 mb-2">
                            <h3 class="text-base font-bold mb-4 text-gray-800 border-b pb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Historial de Movimientos Recientes
                            </h3>
                            <div class="bg-white shadow-sm overflow-hidden sm:rounded-lg border border-gray-200">
                                <ul class="divide-y divide-gray-200">
                                    @foreach($ticketSeleccionado->activities->sortByDesc('created_at')->take(10) as $activity)
                                        <li class="hover:bg-gray-50 transition">
                                            <div class="px-4 py-4 sm:px-6">
                                                
                                                <div class="flex items-center justify-between">
                                                    <p class="text-sm font-bold text-blue-700 flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                        </svg>
                                                        {{ $activity->causer->nombre ?? 'Sistema Automático' }}
                                                    </p>
                                                    <div class="ml-2 flex-shrink-0 flex">
                                                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                                            {{ $activity->created_at->format('d/m/Y h:i A') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-2 text-sm text-gray-700 font-medium">
                                                    {{ $activity->description }}
                                                </div>

                                                @if(isset($activity->properties['old']) && isset($activity->properties['attributes']))
                                                    <div class="mt-3 bg-gray-50 p-3 rounded-md border border-gray-200 text-xs">
                                                        
                                                        @if(isset($activity->properties['causer_name']))
                                                            <div class="mb-2 text-blue-800">
                                                                <span class="font-semibold text-gray-700">Modificado por:</span> 
                                                                <span class="font-medium">{{ $activity->properties['causer_name'] }}</span>
                                                            </div>
                                                        @endif

                                                        <strong class="text-gray-600 block mb-1">Detalle de modificaciones:</strong>
                                                        <ul class="list-disc pl-5 space-y-1 text-gray-600">
                                                            @foreach($activity->properties['attributes'] as $columna => $nuevoValor)
                                                                @if(isset($activity->properties['old'][$columna]) && $activity->properties['old'][$columna] != $nuevoValor && !in_array($columna, ['updated_at']))
                                                                    <li>
                                                                        <span class="font-semibold text-gray-700">{{ ucfirst(str_replace('_', ' ', $columna)) }}:</span> 
                                                                        <span class="line-through text-red-400 mx-1">{{ $activity->properties['old'][$columna] ?: 'Vacío' }}</span> 
                                                                        <span class="text-green-600 font-bold">➔ {{ $nuevoValor ?: 'Vacío' }}</span>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse rounded-b-2xl">
                    <button wire:click="cerrarModal" type="button" class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none transition">
                        Cerrar Ventana
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($mostrarModalPdf && $ticketSeleccionado)
    <div class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-pdf" role="dialog" aria-modal="true">
        
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div wire:click="cerrarModalPdf" class="fixed inset-0 bg-gray-900 bg-opacity-80 transition-opacity cursor-pointer" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-gray-200 rounded-lg text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                
                <div class="bg-slate-800 px-4 py-3 flex justify-between items-center">
                    <h3 class="text-white font-bold text-lg">Vista Previa de Impresión</h3>
                    <button wire:click="cerrarModalPdf" class="text-gray-300 hover:text-white transition">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto max-h-[80vh] flex justify-center bg-gray-200">
                    
                    <div class="pdf-preview shadow-xl">
                        <style>
                            /* Estilos encapsulados para no romper Tailwind */
                            .pdf-preview {
                                background-color: white;
                                width: 100%;
                                max-width: 800px;
                                margin: 0 auto;
                                padding: 30px;
                                font-family: sans-serif;
                                color: black;
                            }
                            .pdf-preview h1, .pdf-preview h2, .pdf-preview h3, .pdf-preview h4, .pdf-preview h5, .pdf-preview h6, .pdf-preview p, .pdf-preview span, .pdf-preview label {
                                font-family: sans-serif;
                            }
                            .pdf-preview table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-bottom: 15px !important;
                            }
                            .pdf-preview table thead th {
                                height: 28px;
                                text-align: left;
                                font-size: 16px;
                            }
                            .pdf-preview table, .pdf-preview th, .pdf-preview td {
                                border: 1px solid #ddd;
                                padding: 8px;
                                font-size: 14px;
                            }
                            .pdf-preview .text-start { text-align: left; }
                            .pdf-preview .text-end { text-align: right; }
                            .pdf-preview .text-center { text-align: center; }
                            .pdf-preview .company-data span {
                                margin-bottom: 4px;
                                display: inline-block;
                                font-size: 14px;
                                font-weight: 400;
                            }
                            .pdf-preview .no-border { border: 1px solid #fff !important; }
                        </style>

                        <table class="order-details">
                            <thead>
                                <tr>
                                    <th width="50%" colspan="2" class="no-border">
                                        <img width="250" src="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png" alt="Servicios de Cómputo UAM-X">
                                    </th>
                                    <th width="50%" colspan="2" class="text-end company-data no-border">
                                        <h5 class="text-start" style="font-size: 16px; margin:0;">Ticket de Solicitud de Servicio de la {{ $ticketSeleccionado->coordinacion->coordinacion ?? 'N/A' }}.</h5>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        
                        <table class="order-details" style="margin-top: 10px;">
                            <tr>
                                <th width="33%" class="text-end company-data no-border">
                                    <span>Sección: {{ $ticketSeleccionado->seccion->seccion ?? 'N/A' }}</span>
                                </th>
                                <th width="33%" class="text-center company-data no-border">
                                    <span>Ticket #: {{ $ticketSeleccionado->id_ticket }}</span>
                                </th>
                                <th width="33%" class="text-end company-data no-border">
                                    <span>Fecha: {{ date('d/m/y') }}</span>
                                </th>   
                            </tr>
                        </table>
                        
                        <table class="user-details" style="margin-top: 15px;">
                            <tbody>
                                <tr>
                                    <td width="30%">Nombre del solicitante</td>
                                    <td width="70%">{{ $ticketSeleccionado->nombre ?? 'Sin dato' }}</td>
                                </tr>
                                <tr>
                                    <td>División/Coordinación General</td>
                                    <td>{{ $ticketSeleccionado->adscripcion ?? 'Sin dato' }}</td>
                                </tr>
                                <tr>
                                    <td>Departamento/Coordinación Administrativa</td>
                                    <td>{{ $ticketSeleccionado->dpto_coord ?? 'Sin dato' }}</td>
                                </tr>
                                <tr>
                                    <td>Área Académica/Sección Administrativa</td>
                                    <td>{{ $ticketSeleccionado->area_secc ?? 'Sin dato' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <table>
                            <tbody>
                                <tr>
                                    <td width="10%">Edificio</td>
                                    <td width="40%">{{ $ticketSeleccionado->dpersonales->edificio ?? 'Sin dato' }}</td>
                                    <td width="10%">Nivel</td>
                                    <td width="40%">{{ $ticketSeleccionado->dpersonales->nivel ?? 'Sin dato' }}</td>
                                </tr>
                                <tr>
                                    <td>Cubículo</td>
                                    <td>{{ $ticketSeleccionado->dpersonales->cubiculo ?? 'Sin dato' }}</td>
                                    <td>Extensión</td>
                                    <td>{{ $ticketSeleccionado->dpersonales->extension ?? 'Sin dato' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <table class="servicio-details">
                            <thead>
                                <tr>
                                    <th class="no-border" colspan="2" style="background:#f3f4f6;">
                                        Descripción del Trabajo a Realizar
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="20%">Tipo de Trabajo</td>
                                    <td width="80%">{{ $ticketSeleccionado->servicio->servicio ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Descripción</td>
                                    <td>{{ $ticketSeleccionado->descripcion }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <table>
                            <thead>
                                <tr>
                                    <th class="no-border" colspan="1" style="background:#f3f4f6;">
                                        Observaciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $ticketSeleccionado->observaciones ?? 'Sin dato' }}</td>
                                </tr>
                            </tbody>
                        </table>    
                        
                        <table style="margin-top: 20px;">
                            <tbody>
                                <tr>
                                    <td width="50%">Recibí de conformidad al terminar el servicio</td>
                                    <td width="50%" class="text-center"><br><br>__________________________<br>Nombre y Firma</td>
                                </tr>
                                <tr>
                                    <td>Responsable del Área</td>
                                    <td><br>{{ $ticketSeleccionado->id_secc->j_secc ?? 'Sin dato'}}</td>
                                </tr>
                                <tr>
                                    <td>Trabajador que realizó el servicio</td>
                                    <td><br>{{ $ticketSeleccionado->trabajadores->nombre ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Fecha y hora de terminación</td>
                                    <td class="text-center">* Campo para llenar a mano</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 flex flex-col sm:flex-row justify-between items-center rounded-b-lg border-t gap-3 sm:gap-0">
                    <button wire:click="cerrarModalPdf" type="button" class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition shadow">
                        Cerrar Ventana
                    </button>
                    
                    <div class="flex w-full sm:w-auto gap-3">
                        
                        <button onclick="imprimirTicketPDF()" type="button" class="flex-1 sm:flex-none flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded font-bold hover:bg-green-700 transition shadow">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Imprimir
                        </button>

                        <a href="/tickets/{{ $ticketSeleccionado->id_ticket }}/generar-pdf" class="flex-1 sm:flex-none flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded font-bold hover:bg-blue-700 transition shadow">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Descargar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
    function imprimirTicketPDF() {
        // 1. Obtenemos solo el contenido limpio del div que tiene la clase .pdf-preview
        var contenidoTicket = document.querySelector('.pdf-preview').innerHTML;
        
        // 2. Abrimos una ventana temporal emergente
        var ventanaImpresion = window.open('', '_blank');
        
        // 3. Escribimos la estructura HTML básica y los mismos estilos CSS que usa el ticket
        ventanaImpresion.document.write('<html><head><title>Imprimir Ticket</title>');
        ventanaImpresion.document.write('<style>');
        ventanaImpresion.document.write(`
            body { margin: 10px; padding: 10px; font-family: sans-serif; color: black; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 15px !important; }
            th { height: 28px; text-align: left; font-size: 16px; }
            table, th, td { border: 1px solid #ddd; padding: 8px; font-size: 14px; }
            .text-start { text-align: left; }
            .text-end { text-align: right; }
            .text-center { text-align: center; }
            .company-data span { margin-bottom: 4px; display: inline-block; font-size: 14px; font-weight: 400; }
            .no-border { border: 1px solid #fff !important; }
            @media print { @page { margin: 1cm; } }
        `);
        ventanaImpresion.document.write('</style></head><body>');
        
        // 4. Inyectamos el contenido del ticket
        ventanaImpresion.document.write(contenidoTicket);
        ventanaImpresion.document.write('</body></html>');
        
        // 5. Cerramos la escritura para que el navegador procese el DOM
        ventanaImpresion.document.close();
        ventanaImpresion.focus();
        
        // 6. Damos 300ms de tiempo para asegurar que el logo/imágenes carguen antes de imprimir
        setTimeout(function() {
            ventanaImpresion.print();
            ventanaImpresion.close();
        }, 300);
    }
    </script>

</div>
