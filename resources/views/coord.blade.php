<x-layout>
    <x-slot:heading>
        Coord
    </x-slot:heading>    
    
    <h2 class="font-bold text-lg">{{ $coord['coordinacion'] }}</h2>
    <p>
        Tickets de Servicios de la {{ $coord['coordinacion'] }}.
    </p>

    @livewire('ticket-search')


</x-layout>