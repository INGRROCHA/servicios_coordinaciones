<x-layout>
    <x-slot:heading>
        Secc
    </x-slot:heading>    
    
    <h2 class="font-bold text-lg">{{ $secc['seccion'] }}</h2>
    <p>
        Tickets de Servicios de la Sección {{ $secc['seccion'] }}.
    </p>

    
    {{-- Pasamos el ID de la sección al componente --}}
    @livewire('ticket-search-secc', ['seccionId' => $secc['id_seccion']])
</x-layout>