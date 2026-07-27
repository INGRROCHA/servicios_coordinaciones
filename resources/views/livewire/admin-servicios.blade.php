<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    
    <!-- Alertas -->
    @if (session()->has('mensaje'))
        <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ session('mensaje') }}
        </div>
    @endif

    <!-- Formulario Agregar Nuevo -->
    <form wire:submit="guardar" class="mb-8 flex gap-4 items-end bg-gray-50 p-4 rounded-lg">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Nuevo Servicio</label>
            <input type="text" wire:model="nuevoServicio" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. MANTENIMIENTO PREVENTIVO" required style="text-transform:uppercase">
            @error('nuevoServicio') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
            + Agregar
        </button>
    </form>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Servicio</th>
                    <th class="px-4 py-3 text-center">Estatus</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($servicios as $s)
                <tr>
                    <td class="px-4 py-3 text-sm">{{ $s->id_servicio }}</td>
                    <td class="px-4 py-3 text-sm font-semibold">{{ $s->servicio }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs font-bold rounded-full {{ $s->estatus == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $s->estatus == 1 ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button wire:click="toggleEstatus({{ $s->id_servicio }})" class="text-sm px-3 py-1 rounded border {{ $s->estatus == 1 ? 'border-red-300 text-red-600 hover:bg-red-50' : 'border-green-300 text-green-600 hover:bg-green-50' }}">
                            {{ $s->estatus == 1 ? 'Desactivar' : 'Activar' }}
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $servicios->links() }}
    </div>
</div>