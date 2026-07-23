<x-layout>
    <div class="max-w-6xl mx-auto px-4 py-8">
        <a href="{{ route('admin.secc.index', $secc->id_seccion) }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">&larr; Volver al Dashboard</a>
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestión de Trabajadores: {{ $secc['seccion'] ?? $secc->seccion ?? '' }}</h1>
        
        <!-- Llamada al componente Livewire -->
        <livewire:admin-tr-secc :id_seccion="$secc->id_seccion" />
    </div>
</x-layout>