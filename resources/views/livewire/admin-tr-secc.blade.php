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
            <input type="text" wire:model="nombre" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. Juan Pérez">
            @error('nombre') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
        </div>

        <!-- Select Servicio Dinámico -->
        <div class="md:col-span-1">
            <label class="block text-sm font-bold text-gray-700 mb-1">Asignar Servicio</label>
            <select wire:model="id_servicio" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">-- Selecciona un servicio --</option>
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

    <!-- Tabla de Trabajadores -->
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-xs font-bold uppercase text-gray-600 tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Servicio Asignado</th>
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
                        {{ $t->servicio?->servicio ?? 'Sin servicio asignado' }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs font-bold rounded-full {{ $t->estatus == 1 ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                            {{ $t->estatus == 1 ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button wire:click="toggleEstatus({{ $t->id_tr_secc }})" class="text-xs font-bold px-3 py-1.5 rounded-lg border transition shadow-sm {{ $t->estatus == 1 ? 'bg-white border-red-300 text-red-600 hover:bg-red-50' : 'bg-white border-green-300 text-green-600 hover:bg-green-50' }}">
                            {{ $t->estatus == 1 ? 'Desactivar' : 'Activar' }}
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 font-medium">
                        No hay trabajadores registrados en esta sección.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $trabajadores->links() }}
    </div>
</div>