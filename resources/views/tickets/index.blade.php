<x-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-4 font-sans">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full border-t-4 border-blue-700">
    <h1><strong>Consultar Estatus de Ticket de Servicio</strong></h1><br>

    <form method="POST" action="{{ route('consultar.buscar') }}">
        @csrf
        <div class="fila" style="margin-bottom: 15px;">
            <div class="celda" data-label="id_ticket">
                Proporcione el número de ticket que quiere consultar. Máx. 5 dígitos.
            </div><br> 
            <div class="celda">
                <input 
                    type="text" 
                    name="id_ticket" 
                    class="form-control"
                    placeholder="INGRESE EL NÚMERO DE TICKET (Máx. 5 dígitos)" 
                    required 
                    pattern="\d{1,5}" 
                    maxlength="5" 
                    title="Ingrese el número de ticket (Máx.5 dígitos)"
                    inputmode="numeric"
                >
            </div>
            <div class="celda" style="margin-left: 10px;">
                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700">Buscar</button>
            </div>
        </div>
    </form>

    @if($ticket)
        <div class="card mb-3 shadow-sm bg-white rounded-lg">
            <div class="card-body p-4">
                <table class="table table-bordered mb-0 w-full text-sm text-left text-gray-500">
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <th style="width: 30%;" class="py-2 font-medium text-gray-900"># de Ticket</th>
                            <td class="py-2">{{ $ticket->id_ticket}}</td>
                        </tr>
                        <tr>
                            <th class="py-2 font-medium text-gray-900">Número Económico</th>
                            <td class="py-2">{{ $ticket->num_economico }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 font-medium text-gray-900">Coordinación</th>
                            <td class="py-2">{{ $ticket->coordinacion->coordinacion ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 font-medium text-gray-900">Sección</th>
                            <td class="py-2">{{ $ticket->seccion->seccion ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 font-medium text-gray-900">Tipo de Servicio Solicitado</th>
                            <td class="py-2">{{ $ticket->servicio->servicio ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 font-medium text-gray-900">Descripción</th>
                            <td class="py-2">{{ $ticket->descripcion }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 font-medium text-gray-900">Estatus</th>
                            <td class="py-2">
                                @if ($ticket->estatus)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-300 text-gray-800' }}">
                                        {{ ucfirst($ticket->estatus) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="py-2 font-medium text-gray-900">Fecha de Creación</th>
                            <td class="py-2">{{ $ticket->created_at }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 font-medium text-gray-900">Observaciones</th>
                            <td class="py-2">{{ $ticket->observaciones }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 font-medium text-gray-900">Última actualización</th>
                            <td class="py-2">{{ $ticket->updated_at }}</td> 
                        </tr>    
                    </tbody>
                </table>
            </div>
        </div>

       <!-- SECCIÓN DE HISTORIAL DEL TICKET -->
        @if($ticket->activities && $ticket->activities->count() > 0)
            <div class="mt-8 mb-8">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Historial de Movimientos</h3>
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        
                        <!-- sortByDesc() para ordenar del más reciente al más antiguo, y take(5) para limitar a 5 resultados -->
                        @foreach($ticket->activities->sortByDesc('created_at')->take(5) as $activity)
                            <li>
                                <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-blue-600 truncate">
                                            <!-- Muestra el nombre del usuario que hizo el cambio, si existe -->
                                            {{ $activity->causer->nombre ?? 'Sistema / Usuario Desconocido' }}
                                        </p>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $activity->created_at->format('d/m/Y H:i:s') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm text-gray-600">
                                                <!-- Descripción del evento (ej: "Ticket actualizado", "Estatus cambiado a cerrado") -->
                                                {{ $activity->description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        @endif
        <!-- FIN SECCIÓN DE HISTORIAL -->

    @elseif(request()->isMethod('post'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3" role="alert">
            <strong class="font-bold">Aviso:</strong>
            <span class="block sm:inline"> No se encontró ningún ticket con ese número.</span>
        </div>
    @endif
    </div>
    </div>
</x-layout>