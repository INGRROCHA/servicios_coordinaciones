<x-layout>
    <x-slot:heading>
        Coord
    </x-slot:heading>    
    
    <h2 class="font-bold text-lg">{{ $coord['coordinacion'] }}</h2>
    <p>
        Tickets de Servicios de la {{ $coord['coordinacion'] }}.
    </p>

    {{-- Pasamos el ID de la coordinación al componente --}}
    @livewire('ticket-search-coord', ['coordinacionId' => $coord['id_coordinacion']])

</x-layout>