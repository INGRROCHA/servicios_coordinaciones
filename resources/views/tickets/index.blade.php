<x-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-4 font-sans">
    
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-2xl w-full border-t-4 border-blue-700">
        
        <div class="mb-4">
            <h1 class="text-xl font-bold text-gray-800">Consultar Estatus de Ticket de Servicio</h1>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 mb-6 border-b pb-5">
            
            <a href="{{ url('/show') }}" 
               class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-lg shadow-sm hover:bg-indigo-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                </svg>
                Mis Tickets de Servicios
            </a>

            <a href="{{ url('/tickets/all') }}" 
               class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-slate-700 rounded-lg shadow-sm hover:bg-slate-800 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18" />
                </svg>
                Todas las Coordinaciones
            </a>
        </div>

        <form method="POST" action="{{ route('consultar.buscar') }}" class="mb-6">
            @csrf
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                    Proporcione el número de ticket que quiere consultar (Máx. 5 dígitos):
                </label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="id_ticket" 
                            class="w-full p-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm font-medium"
                            placeholder="INGRESE EL NÚMERO DE TICKET" 
                            required 
                            pattern="\d{1,5}" 
                            maxlength="5" 
                            title="Ingrese el número de ticket (Máx.5 dígitos)"
                            inputmode="numeric"
                        >
                    </div>
                    <button type="submit" class="sm:w-28 bg-blue-600 text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition shadow-sm text-sm">
                        Buscar
                    </button>
                </div>
            </div>
        </form>

        @if($ticket)
            <div class="card mb-3 shadow-sm bg-white rounded-xl border border-gray-200 mt-6 overflow-hidden">
                <div class="card-body p-5">
                    <table class="table table-bordered mb-0 w-full text-sm text-left text-gray-600 table-fixed">
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <th style="width: 35%;" class="py-3 px-2 font-semibold text-gray-900 bg-gray-50/50"># de Ticket</th>
                                <td style="width: 65%;" class="py-3 px-2 font-bold text-blue-700">{{ $ticket->id_ticket}}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 font-semibold text-gray-900 bg-gray-50/50">Número Económico</th>
                                <td class="py-3 px-2">{{ $ticket->num_economico }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 font-semibold text-gray-900 bg-gray-50/50">Coordinación</th>
                                <td class="py-3 px-2 text-gray-800 font-medium">{{ $ticket->coordinacion->coordinacion ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 font-semibold text-gray-900 bg-gray-50/50">Sección</th>
                                <td class="py-3 px-2 text-gray-800 font-medium">{{ $ticket->seccion->seccion ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 font-semibold text-gray-900 bg-gray-50/50">Servicio Solicitado</th>
                                <td class="py-3 px-2">{{ $ticket->servicio->servicio ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 font-semibold text-gray-900 bg-gray-50/50">Descripción</th>
                                <td class="py-3 px-2 whitespace-pre-line text-justify">{{ $ticket->descripcion }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 font-semibold text-gray-900 bg-gray-50/50">Estatus</th>
                                <td class="py-3 px-2">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full shadow-sm {{ $ticket->estado_color }}">
                                        {{ $ticket->estado_nombre }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 font-semibold text-gray-900 bg-gray-50/50">Trabajador Asignado</th>
                                <td class="py-3 px-2 whitespace-pre-line text-justify">{{ $ticket->trabajadores->nombre ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 font-semibold text-gray-900 bg-gray-50/50">Fecha de Creación</th>
                                <td class="py-3 px-2 text-gray-500">{{ $ticket->created_at->format('d/m/Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 font-semibold text-gray-900 bg-gray-50/50">Observaciones</th>
                                <td class="py-3 px-2 whitespace-pre-line text-justify">{{ $ticket->observaciones ?: 'Sin observaciones registadas.' }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 font-semibold text-gray-900 bg-gray-50/50">Última actualización</th>
                                <td class="py-3 px-2 text-gray-500">{{ $ticket->updated_at->format('d/m/Y h:i A') }}</td> 
                            </tr>  
                        </tbody>
                    </table>
                </div>
            </div>

            @if($ticket->activities && $ticket->activities->count() > 0)
                <div class="mt-8 mb-4">
                    <h3 class="text-base font-bold mb-4 text-gray-800 border-b pb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Historial de Movimientos Recientes
                    </h3>
                    <div class="bg-white shadow-md overflow-hidden sm:rounded-lg border border-gray-200">
                        <ul class="divide-y divide-gray-200">
                            
                            @foreach($ticket->activities->sortByDesc('created_at')->take(10) as $activity)
                                <li class="hover:bg-gray-50 transition">
                                    <div class="px-4 py-4 sm:px-6">
                                        
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-bold text-blue-700 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                </svg>
                                                {{ $activity->causer->nombre ?? 'Sistema Automático' }}
                                            </p>
                                            <div class="ml-2 flex-shrink-0 flex">
                                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                                    {{ $activity->created_at->format('d/m/Y h:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-2 text-sm text-gray-700 font-medium">
                                            {{ $activity->description }}
                                        </div>

                                        @if(isset($activity->properties['old']) && isset($activity->properties['attributes']))
                                            <div class="mt-3 bg-gray-50 p-3 rounded-md border border-gray-200 text-xs">
                                                <strong class="text-gray-600 block mb-1">Detalle de modificaciones:</strong>
                                                <ul class="list-disc pl-5 space-y-1 text-gray-600">
                                                    @foreach($activity->properties['attributes'] as $columna => $nuevoValor)
                                                        @if(isset($activity->properties['old'][$columna]) && $activity->properties['old'][$columna] != $nuevoValor && !in_array($columna, ['updated_at']))
                                                            <li>
                                                                <span class="font-semibold text-gray-700">{{ ucfirst(str_replace('_', ' ', $columna)) }}:</span> 
                                                                <span class="line-through text-red-400 mx-1">{{ $activity->properties['old'][$columna] ?: 'Vacío' }}</span> 
                                                                <span class="text-green-600 font-bold">➔ {{ $nuevoValor ?: 'Vacío' }}</span>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            @endif

        @elseif(request()->isMethod('post'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mt-6" role="alert">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2 text-red-500">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                    </svg>
                    <strong class="font-bold">Aviso: </strong>
                    <span class="block sm:inline ml-1"> No se encontró ningún ticket con ese número.</span>
                </div>
            </div>
        @endif
    </div>
    </div>
</x-layout>