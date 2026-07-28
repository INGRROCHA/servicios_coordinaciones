<x-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-4 font-sans">
    
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-2xl w-full border-t-4 border-blue-700">
        
        <div class="mb-4">
            <h1 class="text-xl font-bold text-gray-800">Panel de Administración - Administrador</h1>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 mb-6 border-b pb-5">
            
            <a href="{{ url('/show') }}" 
            class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 border border-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>
                Mis Tickets de Servicios
            </a>

            <a href="{{ url('/tickets/all') }}" 
               class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-slate-700 rounded-lg shadow-sm hover:bg-slate-800 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18" />
                </svg>
                Tickets de Todas las Coordinaciones
            </a>
        </div>

        <!-- DASHBOARDS DE ADMINISTRACIÓN POR COORDINACIÓN -->
        <div class="space-y-5 mb-8 border-b pb-6">
            <h2 class="text-base font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                Dashboards de Administración por Sección
            </h2>

            <!-- 1. Coordinación de Servicios de Cómputo (Azul) -->
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h3 class="text-xs font-bold text-blue-900 uppercase tracking-wider mb-3 flex items-center">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600 mr-2"></span>
                    Coordinación de Servicios de Cómputo
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    <!-- Análisis y Apoyo Técnico -->
                    <a href="{{ url('/seccs/11/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 rounded-lg shadow-sm hover:bg-blue-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0h-18" />
                        </svg>
                        Análisis y Apoyo Técnico
                    </a>

                    <!-- Redes y Conectividad -->
                    <a href="{{ url('/seccs/12/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 rounded-lg shadow-sm hover:bg-blue-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z" />
                        </svg>
                        Redes y Conectividad
                    </a>

                    <!-- Administración Operativa de Sistemas -->
                    <a href="{{ url('/seccs/13/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 rounded-lg shadow-sm hover:bg-blue-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 17.25v-.228a4.5 4.5 0 00-1.012-2.83l-1.286-1.543a4.5 4.5 0 00-3.452-1.627H8.002a4.5 4.5 0 00-3.452 1.627l-1.286 1.543A4.5 4.5 0 002.25 17.022v.228M16.5 6a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" />
                        </svg>
                        Administración Operativa de Sistemas
                    </a>

                    <!-- Diseño de Sistemas -->
                    <a href="{{ url('/seccs/14/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 rounded-lg shadow-sm hover:bg-blue-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                        </svg>
                        Diseño de Sistemas
                    </a>
                </div>
            </div>

            <!-- 2. Coordinación de Servicios Generales (Indigo) -->
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h3 class="text-xs font-bold text-indigo-900 uppercase tracking-wider mb-3 flex items-center">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600 mr-2"></span>
                    Coordinación de Servicios Generales
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    <!-- Intendencia y Jardinería -->
                    <a href="{{ url('/seccs/21/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-lg shadow-sm hover:bg-indigo-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z" />
                        </svg>
                        Intendencia y Jardinería
                    </a>

                    <!-- Transportes -->
                    <a href="{{ url('/seccs/22/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-lg shadow-sm hover:bg-indigo-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM15.75 18.75a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM3.75 6l-1.5 6h19.5l-1.5-6H3.75zM2.25 12v4.5A2.25 2.25 0 004.5 18.75h.75m13.5 0h.75a2.25 2.25 0 002.25-2.25V12M2.25 12h19.5" />
                        </svg>
                        Transportes
                    </a>

                    <!-- Vigilancia -->
                    <a href="{{ url('/seccs/23/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-lg shadow-sm hover:bg-indigo-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5 sm:col-span-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        Vigilancia
                    </a>
                </div>
            </div>

            <!-- 3. Coordinación de Espacios Físicos (Aquamarine / Teal) -->
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h3 class="text-xs font-bold text-teal-900 uppercase tracking-wider mb-3 flex items-center">
                    <span class="w-2.5 h-2.5 rounded-full bg-teal-500 mr-2"></span>
                    Coordinación de Espacios Físicos
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    <!-- Mantenimiento de Campo -->
                    <a href="{{ url('/seccs/31/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-teal-800 bg-teal-50 border border-teal-200 rounded-lg shadow-sm hover:bg-teal-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        Mantenimiento de Campo
                    </a>

                    <!-- Mantenimiento Especializado -->
                    <a href="{{ url('/seccs/32/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-teal-800 bg-teal-50 border border-teal-200 rounded-lg shadow-sm hover:bg-teal-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l5.654-4.654m0 0l3.03-2.496c.14-.468.382-.89.766-1.208l5.877-5.877A2.652 2.652 0 0017.25 3l-5.877 5.877" />
                        </svg>
                        Mantenimiento Especializado
                    </a>

                    <!-- Mantenimiento, Adaptaciones a Bienes Inmuebles -->
                    <a href="{{ url('/seccs/33/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-teal-800 bg-teal-50 border border-teal-200 rounded-lg shadow-sm hover:bg-teal-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5 sm:col-span-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                        Mantenimiento, Adaptaciones a Bienes Inmuebles
                    </a>
                </div>
            </div>

            <!-- 4. Coordinación de Servicios para la Convivencia Integral (Pink) -->
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h3 class="text-xs font-bold text-pink-900 uppercase tracking-wider mb-3 flex items-center">
                    <span class="w-2.5 h-2.5 rounded-full bg-pink-500 mr-2"></span>
                    Coordinación de Servicios para la Convivencia Integral
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    <!-- Cafetería -->
                    <a href="{{ url('/seccs/41/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-pink-700 bg-pink-50 border border-pink-200 rounded-lg shadow-sm hover:bg-pink-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Cafetería
                    </a>

                    <!-- Actividades Deportivas -->
                    <a href="{{ url('/seccs/42/admin') }}" 
                       class="inline-flex items-center justify-start px-3.5 py-2.5 text-xs font-semibold text-pink-700 bg-pink-50 border border-pink-200 rounded-lg shadow-sm hover:bg-pink-100 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 003-3V8.25a3 3 0 00-3-3h-9a3 3 0 00-3 3v7.5a3 3 0 003 3m9 0v-1.5A3.375 3.375 0 0013.125 12h-2.25A3.375 3.375 0 007.5 15.375v1.5M12 9a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
                        </svg>
                        Actividades Deportivas
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h1 class="text-xl font-bold text-gray-800">Consultar Estatus de Ticket de Servicio</h1>
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
                                                
                                                {{-- Mostrar el usuario que hizo la modificación --}}
                                                @if(isset($activity->properties['causer_name']))
                                                    <div class="mb-2 text-blue-800">
                                                        <span class="font-semibold text-gray-700">Modificado por:</span> 
                                                        <span class="font-medium">{{ $activity->properties['causer_name'] }}</span>
                                                    </div>
                                                @endif

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