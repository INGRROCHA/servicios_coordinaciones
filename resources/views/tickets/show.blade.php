<x-layout>
    <p>
    <h1><strong>Consulta de la Base de Datos de los Ticket de Servicio</strong></h1>
    </p>
    <br>


    <!-- Tabla de Resultados -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="table min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider"># de Ticket</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Coordinación</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Sección</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Tipo de Servicio Solicitado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Estatus</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Fecha de Creación</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Observaciones</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Última actualización</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($tickets as $ticket)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-xs whitespace-nowrap">{{ $ticket->id_ticket }}</td>
                         <!-- Relaciones Elocuentes -->
                        <td class="px-6 py-4 text-xs whitespace-nowrap">{{ $ticket->coordinacion->coordinacion }}</td>
                        <td class="px-6 py-4 text-xs whitespace-nowrap">{{ $ticket->seccion->seccion }}</td>
                        <td class="px-6 py-4 text-xs whitespace-nowrap">{{ $ticket->servicio->servicio }}</td>
                        <!--  -->
                        <td class="px-6 py-4 text-xs">{{ $ticket->descripcion }}</td>
                        <!-- Estatus -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-300 text-gray-800' }}">
                                {{ $ticket->estatus }}
                            </span>
                        </td>
                        <!--  -->
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-800">{{ $ticket->created_at }}</td>
                        <td class="px-6 py-4 text-xs text-gray-800">{{ $ticket->observaciones }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-800">{{ $ticket->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $tickets->links() }}
    </div>
</x-layout>