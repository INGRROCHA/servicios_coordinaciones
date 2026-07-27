<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    
    <!-- Alertas -->
    @if (session()->has('mensaje'))
        <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ session('mensaje') }}
        </div>
    @endif

    <!-- Formulario Agregar Nuevo -->
    <form wire:submit="guardar" class="mb-6 flex gap-4 items-end bg-gray-50 p-4 rounded-lg">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Nuevo Servicio</label>
            <input type="text" wire:model="nuevoServicio" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. MANTENIMIENTO PREVENTIVO" required style="text-transform:uppercase">
            @error('nuevoServicio') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
            + Agregar
        </button>
    </form>

    <!-- Barra de Filtros: Paginación y Buscador -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4 bg-gray-50 p-4 rounded-lg">
        <!-- Selector de Paginación -->
        <div class="flex items-center gap-2">
            <label for="perPage" class="text-sm font-medium text-gray-700">Mostrar:</label>
            <select wire:model.live="perPage" id="perPage" class="border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm py-1.5 pr-8">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <span class="text-sm text-gray-500">registros</span>
        </div>

        <!-- Buscador -->
        <div class="relative w-full md:w-72">
            <input type="text" wire:model.live="search" placeholder="Buscar por ID o nombre..." class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm pl-10 py-2">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                    <!-- Encabezado ID (Ordenable) -->
                    <th wire:click="sortBy('id_servicio')" class="px-4 py-3 text-left cursor-pointer hover:bg-gray-200 select-none group">
                        <div class="flex items-center gap-1">
                            ID
                            @if($sortColumn === 'id_servicio')
                                <span class="text-blue-600 font-bold">{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @else
                                <span class="text-gray-300 group-hover:text-gray-500">&uarr;&darr;</span>
                            @endif
                        </div>
                    </th>
                    
                    <!-- Encabezado Servicio (Ordenable) -->
                    <th wire:click="sortBy('servicio')" class="px-4 py-3 text-left cursor-pointer hover:bg-gray-200 select-none group">
                        <div class="flex items-center gap-1">
                            Servicio
                            @if($sortColumn === 'servicio')
                                <span class="text-blue-600 font-bold">{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @else
                                <span class="text-gray-300 group-hover:text-gray-500">&uarr;&darr;</span>
                            @endif
                        </div>
                    </th>
                    
                    <th class="px-4 py-3 text-center">Estatus</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($servicios as $s)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $s->id_servicio }}</td>
                    <td class="px-4 py-3 text-sm font-semibold text-gray-800">{{ $s->servicio }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs font-bold rounded-full {{ $s->estatus == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $s->estatus == 1 ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <!-- OJO AQUÍ: Las comillas simples ('{{ $s->id_servicio }}') son vitales ahora que tu ID es texto -->
                        <button wire:click="toggleEstatus('{{ $s->id_servicio }}')" class="text-sm px-3 py-1 rounded border transition {{ $s->estatus == 1 ? 'border-red-300 text-red-600 hover:bg-red-50' : 'border-green-300 text-green-600 hover:bg-green-50' }}">
                            {{ $s->estatus == 1 ? 'Desactivar' : 'Activar' }}
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                        No se encontraron servicios que coincidan con la búsqueda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginación -->
    <div class="mt-4">
        {{ $servicios->links() }}
    </div>
</div>