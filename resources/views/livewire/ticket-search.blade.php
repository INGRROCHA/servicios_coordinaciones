	<div>
		<div class="px-8 py-4">
			<input wire:model.live="search" 
				   type="text" 
				   placeholder="🔍 Buscar por folio, nombre, servicio o núm económico..." 
				   class="w-1/4 p-4 border-2 border-blue-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
		</div>

   <!-- Tabla de Resultados -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="table min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider"># de Ticket</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Sección</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Tipo de Servicio Solicitado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Adscripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Coordinación Administrativa o Departamento Académico</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Área Académica o Sección Administrativa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Estatus</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Fecha de Creación</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Observaciones</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Última actualización</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
				<tbody class="bg-white divide-y divide-gray-200">
					@forelse($tickets as $ticket)
						<tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-xs">{{ $ticket->id_ticket }}</td>
                        <!-- Relaciones Elocuentes -->
						<td class="px-6 py-4 text-xs">{{ $ticket->seccion->seccion }}</td>
                        <td class="px-6 py-4 text-xs">{{ $ticket->servicio->servicio }}</td>
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

		<div class="mt-4">
			{{ $tickets->links() }}
		</div>
	</div>
