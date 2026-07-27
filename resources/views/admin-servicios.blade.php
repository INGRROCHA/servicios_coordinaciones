<x-layout>
    <div class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Botón Volver al Dashboard reactivo y con estilo -->
        <a href="{{ route('admin.secc.index', $secc->id_seccion) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm mb-6">
            &larr; Volver al Dashboard
        </a>

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestión de Servicios: {{ $secc['seccion'] ?? $secc->seccion ?? '' }}</h1>
        
        <!-- Llamada al componente Livewire -->
        <livewire:admin-servicios :id_seccion="$secc->id_seccion" />
    </div>
</x-layout>