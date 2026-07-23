<x-layout>
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Noté que usas $secc['seccion'], lo respetamos aquí -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Dashboard de Administración - {{ $secc['seccion'] ?? $secc->seccion }}
        </h1>
        
        <!-- Cambiamos a grid-cols-3 para acomodar las 3 tarjetas alineadas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Tarjeta Trabajadores -->
            <a href="{{ route('admin.secc.trabajadores', $secc->id_seccion) }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 hover:border-blue-300 transition">
                <h2 class="text-xl font-bold text-blue-700">👥 Gestión de Trabajadores</h2>
                <p class="mt-2 text-gray-600 text-sm">Administra los trabajadores de la sección, estatus o registra nuevos miembros.</p>
            </a>

            <!-- Tarjeta Servicios -->
            <a href="{{ route('admin.secc.servicios', $secc->id_seccion) }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 hover:border-indigo-300 transition">
                <h2 class="text-xl font-bold text-indigo-700">🛠️ Gestión de Servicios</h2>
                <p class="mt-2 text-gray-600 text-sm">Crea nuevos servicios para esta sección o habilita/deshabilita los existentes.</p>
            </a>

            <!-- Tarjeta Tickets de mi Sección -->
            <a href="{{ url('/seccs/' . session('id_seccion')) }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 hover:border-emerald-300 transition">
                <h2 class="text-xl font-bold text-emerald-700">🎫 Tickets de mi Sección</h2>
                <p class="mt-2 text-gray-600 text-sm">Visualiza, filtra y gestiona los tickets que han sido asignados a tu área.</p>
            </a>

        </div>
    </div>
</x-layout>