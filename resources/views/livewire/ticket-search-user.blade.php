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
            
            {{-- Filtros por Coordinación  --}}
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 mr-1">Coordinación:</span>
            <button wire:click="setCoordinacionFilter(null)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ is_null($coordinacionId) ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                Todas
            </button>

            <button wire:click="setCoordinacionFilter(1)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ $coordinacionId == 1 ? 'bg-blue-600 text-white border-blue-600' : 'bg-blue-50 text-blue-800 border-blue-200 hover:bg-blue-100' }}">
                CSC 
            </button>

            <button wire:click="setCoordinacionFilter(2)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ $coordinacionId == 2 ? 'bg-yellow-500 text-white border-yellow-500' : 'bg-yellow-50 text-yellow-800 border-yellow-200 hover:bg-yellow-100' }}">
                CSG 
            </button>

            <button wire:click="setCoordinacionFilter(3)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ $coordinacionId == 3 ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-indigo-50 text-indigo-800 border-indigo-200 hover:bg-indigo-100' }}">
                CEF 
            </button>

            <button wire:click="setCoordinacionFilter(4)" 
                    class="px-3 py-2 text-xs font-bold rounded-lg border transition shadow-sm 
                    {{ $coordinacionId == 4 ? 'bg-purple-600 text-white border-purple-600' : 'bg-purple-50 text-purple-800 border-purple-200 hover:bg-purple-100' }}">
                CSCI
            </button>

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

    <div class="overflow-x-auto bg-white shadow-md rounded-lg mx-8">
        <table class="table min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr class="bg-gray-200 text-black text-xs font-semibold uppercase tracking-wider">
                    <th wire:click="setSort('id_ticket')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center"># Ticket
                            @if ($sortBy !== 'id_ticket') <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc') <span class="ml-1">↑</span> @else <span class="ml-1">↓</span> @endif
                        </div>
                    </th>
                    <th wire:click="setSort('nombre_coordinacion')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">Coordinación
                            @if ($sortBy !== 'nombre_coordinacion') <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc') <span class="ml-1">↑</span> @else <span class="ml-1">↓</span> @endif
                        </div>
                    </th>
                    <th wire:click="setSort('nombre_seccion')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">Sección
                            @if ($sortBy !== 'nombre_seccion') <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc') <span class="ml-1">↑</span> @else <span class="ml-1">↓</span> @endif
                        </div>
                    </th>
                    <th wire:click="setSort('nombre_servicio')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">Tipo de Servicio Solicitado
                            @if ($sortBy !== 'nombre_servicio') <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc') <span class="ml-1">↑</span> @else <span class="ml-1">↓</span> @endif
                        </div>
                    </th>
                    <th wire:click="setSort('descripcion')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">Descripción
                            @if ($sortBy !== 'descripcion') <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc') <span class="ml-1">↑</span> @else <span class="ml-1">↓</span> @endif
                        </div>
                    </th>
                    <th wire:click="setSort('estado')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">Estatus
                            @if ($sortBy !== 'estado') <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc') <span class="ml-1">↑</span> @else <span class="ml-1">↓</span> @endif
                        </div>
                    </th>
                    <th wire:click="setSort('created_at')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">Fecha de Creación
                            @if ($sortBy !== 'created_at') <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc') <span class="ml-1">↑</span> @else <span class="ml-1">↓</span> @endif
                        </div>
                    </th>
                    <th wire:click="setSort('observaciones')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                        <div class="flex items-center">Observaciones
                            @if ($sortBy !== 'observaciones') <span class="ml-1 opacity-40">↕</span>
                            @elseif ($sortDir === 'asc') <span class="ml-1">↑</span> @else <span class="ml-1">↓</span> @endif
                        </div>
                    </th>

                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-xs font-semibold text-blue-700">{{ $ticket->id_ticket }}</td>
                        <td class="px-6 py-4 text-xs">{{ $ticket->coordinacion?->coordinacion ?? 'Sin coordinación' }}</td>         
                        <td class="px-6 py-4 text-xs">{{ $ticket->seccion?->seccion ?? 'Sin sección' }}</td>
                        <td class="px-6 py-4 text-xs">{{ $ticket->servicio?->servicio ?? 'Sin servicio' }}</td>
                        <td class="px-6 py-4 text-xs max-w-xs truncate">{{ $ticket->descripcion }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full {{ $ticket->estado_color }}">
                                {{ $ticket->estado_nombre }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">{{ $ticket->created_at }}</td>
                        <td class="px-6 py-4 text-xs text-gray-500 max-w-xs truncate">{{ $ticket->observaciones }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="px-6 py-10 text-center text-gray-500 font-medium">
                            No se encontraron tickets con "{{ $search }}"
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 mt-2">
        <div class="flex items-center gap-2">
            <label class="text-sm font-medium text-gray-600">Mostrar:</label>
            <select wire:model.live="perPage" class="p-1.5 bg-white border-2 border-blue-200 rounded-lg focus:border-blue-500 outline-none text-sm font-semibold">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <span class="text-sm text-gray-600">registros</span>
        </div>
        <div>
            {{ $tickets->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>