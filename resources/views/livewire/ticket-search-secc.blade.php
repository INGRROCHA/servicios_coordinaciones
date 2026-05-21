	<div>
		<div class="px-8 py-4">
			<input wire:model.live="search" 
				   type="text" 
				   placeholder="🔍 Buscar por # de ticket o servicio..." 
				   class="w-1/4 p-4 border-2 border-blue-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
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
						<th wire:click="setSort('estatus')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                            <div class="flex items-center">
                                Estatus
                                @if ($sortBy !== 'estatus')
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
						<th wire:click="setSort('observaciones')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                            <div class="flex items-center">
                                Observaciones
                                @if ($sortBy !== 'observaciones')
                                    <span class="ml-1 opacity-40">↕</span>
                                @elseif ($sortDir === 'asc')
                                    <span class="ml-1">↑</span>
                                @else
                                    <span class="ml-1">↓</span>
                                @endif
                            </div>
                        </th>
						<th wire:click="setSort('updated_at')" class="px-6 py-4 cursor-pointer hover:bg-blue-300 transition">
                            <div class="flex items-center">
                                Última actualización
                                @if ($sortBy !== 'updated_at')
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
                        <td class="px-6 py-4 text-xs">{{ $ticket->servicio?->servicio ?? 'Sin servicio' }}</td>
                        <td class="px-6 py-4 text-xs">{{ $ticket->adscripcion ?? 'Sin dato' }}</td>
                        <td class="px-6 py-4 text-xs">{{ $ticket->dpto_coord ?? 'Sin dato' }}</td>
                        <td class="px-6 py-4 text-xs">{{ $ticket->area_secc ?? 'Sin dato' }}</td>
                        <td class="px-6 py-4 text-xs">{{ $ticket->descripcion }}</td>
                        <!-- Estatus -->
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $ticket->estatus }}
                            </span>
                        </td>
                        <!--  -->
                        <td class="px-6 py-4 text-xs text-gray-800">{{ $ticket->created_at }}</td>
                        <td class="px-6 py-4 text-xs text-gray-800">{{ $ticket->observaciones }}</td>
                        <td class="px-6 py-4 text-xs text-gray-800">{{ $ticket->updated_at }}</td>
                        <td class="px-6">
                            <div class="flex items-center">
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
	</div>
