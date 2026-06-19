<div class="relative w-full mb-6 bg-blue-50 p-4 rounded-xl border border-blue-200">
    <label class="block text-sm font-bold text-blue-900 mb-2">
        🔍 Buscador Rápido de Servicios por Palabra Clave:
    </label>
    
    <input type="text" 
           wire:model.live="search" 
           placeholder="Ej: Antivirus, Wi-Fi, Cerrajería, Plomería, Electricidad..." 
           class="w-full p-3 text-base bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-3 focus:ring-blue-100 transition shadow-sm text-gray-800">
           
    @if(!empty($search) && count($results) > 0)
        <div class="absolute z-50 w-full left-0 bg-white mt-1 rounded-lg shadow-2xl border border-gray-200 max-h-60 overflow-y-auto">
            @foreach($results as $item)
                <button type="button" 
                        wire:click="selectService('{{ $item->id_servicio }}')" 
                        class="w-full text-left px-4 py-3 hover:bg-blue-50 transition border-b border-gray-100 last:border-b-0 flex flex-col gap-0.5">
                    <span class="font-semibold text-gray-800 text-sm">{{ $item->servicio }}</span>
                    <span class="text-xs text-gray-400">
                        Código identificador: <span class="font-mono text-blue-600 font-bold">{{ $item->id_servicio }}</span>
                    </span>
                </button>
            @endforeach
        </div>
    @elseif(!empty($search) && count($results) === 0)
        <div class="absolute z-50 w-full left-0 bg-white mt-1 rounded-lg shadow-md border border-gray-200 p-4 text-center text-sm text-gray-500">
            No se encontraron servicios que coincidan con "{{ $search }}"
        </div>
    @endif
</div>