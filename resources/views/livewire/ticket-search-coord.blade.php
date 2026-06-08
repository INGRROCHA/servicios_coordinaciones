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

                            <a href="/tickets/{{ $ticket->id_ticket }}/editar" class="flex-shrink-0"> 
                                <img src="{{ asset('imagenes/edit.png') }}" alt="Editar" title="Editar Ticket" class="w-[30px] h-[30px] object-contain">
                            </a>
                            <a href="/tickets/{{ $ticket->id_ticket }}/generar-pdf" class="flex-shrink-0">
                                <img src="{{ asset('imagenes/download-pdf.png') }}" alt="Descargar PDF" title="Descargar PDF" class="w-[30px] h-[30px] object-contain">
                            </a>
                            <a href="/tickets/{{ $ticket->id_ticket }}/ver-pdf" target="_blank" class="flex-shrink-0">
                                <img src="{{ asset('imagenes/view.png') }}" alt="Ver PDF" title="Ver PDF" class="w-[30px] h-[30px] object-contain">
                            </a>
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

</div>
