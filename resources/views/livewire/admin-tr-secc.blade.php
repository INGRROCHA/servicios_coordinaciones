<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    
    <!-- Alertas -->
    @if (session()->has('mensaje'))
        <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg font-semibold">
            {{ session('mensaje') }}
        </div>
    @endif

    <!-- Formulario Agregar Nuevo Trabajador -->
    <form wire:submit="guardar" class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-gray-50 p-4 rounded-lg border border-gray-200">
        
        <!-- Input Nombre -->
        <div class="md:col-span-1">
            <label class="block text-sm font-bold text-gray-700 mb-1">Nombre del Trabajador</label>
            <input type="text" wire:model="nombre" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. JUAN PÉREZ" required style="text-transform:uppercase">
            @error('nombre') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
        </div>

        <!-- Select Especialidad Dinámica -->
        <div class="md:col-span-1">
            <label class="block text-sm font-bold text-gray-700 mb-1">Asignar Especialidad</label>
            <select wire:model="id_servicio" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">-- Selecciona una Especialidad --</option>
                @foreach($serviciosDisponibles as $servicio)
                    <option value="{{ $servicio->id_servicio }}">{{ $servicio->servicio }}</option>
                @endforeach
            </select>
            @error('id_servicio') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
        </div>

        <!-- Botón Agregar -->
        <div class="md:col-span-1">
            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-sm">
                + Agregar Trabajador
            </button>
        </div>
    </form>

    <!-- Barra de Filtros: Paginación y Buscador -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
        <!-- Selector de Paginación -->
        <div class="flex items-center gap-2">
            <label for="perPage" class="text-sm font-medium text-gray-700">Mostrar:</label>
            <select wire:model.live="perPage" id="perPage" class="border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm py-1.5 pr-8 bg-white">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <span class="text-sm text-gray-500">registros</span>
        </div>

        <!-- Buscador -->
        <div class="relative w-full md:w-72">
            <input type="text" wire:model.live="search" placeholder="Buscar trabajador o servicio..." class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm pl-10 py-2">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Tabla de Trabajadores -->
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-xs font-bold uppercase text-gray-600 tracking-wider">
                <tr>
                    <!-- Encabezado ID (Ordenable) -->
                    <th wire:click="sortBy('id_tr_secc')" class="px-4 py-3 text-left cursor-pointer hover:bg-gray-200 select-none group">
                        <div class="flex items-center gap-1">
                            ID
                            @if($sortColumn === 'id_tr_secc')
                                <span class="text-blue-600 font-bold">{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @else
                                <span class="text-gray-300 group-hover:text-gray-500">&uarr;&darr;</span>
                            @endif
                        </div>
                    </th>
                    
                    <!-- Encabezado Nombre (Ordenable) -->
                    <th wire:click="sortBy('nombre')" class="px-4 py-3 text-left cursor-pointer hover:bg-gray-200 select-none group">
                        <div class="flex items-center gap-1">
                            Nombre
                            @if($sortColumn === 'nombre')
                                <span class="text-blue-600 font-bold">{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @else
                                <span class="text-gray-300 group-hover:text-gray-500">&uarr;&darr;</span>
                            @endif
                        </div>
                    </th>
                    
                    <th class="px-4 py-3 text-left">Especialidad Asignada</th>
                    <th class="px-4 py-3 text-center">Estatus</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($trabajadores as $t)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $t->id_tr_secc }}</td>
                    <td class="px-4 py-3 text-sm font-bold text-gray-800">{{ $t->nombre }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        {{ $t->servicio?->servicio ?? 'Sin especialidad asignada' }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs font-bold rounded-full {{ $t->estatus == 1 ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                            {{ $t->estatus == 1 ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button wire:click="toggleEstatus('{{ $t->id_tr_secc }}')" class="text-xs font-bold px-3 py-1.5 rounded-lg border transition shadow-sm {{ $t->estatus == 1 ? 'bg-white border-red-300 text-red-600 hover:bg-red-50' : 'bg-white border-green-300 text-green-600 hover:bg-green-50' }}">
                            {{ $t->estatus == 1 ? 'Desactivar' : 'Activar' }}
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 font-medium">
                        No se encontraron trabajadores que coincidan con la búsqueda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginación -->
    <div class="mt-4">
        {{ $trabajadores->links() }}
    </div>
</div>