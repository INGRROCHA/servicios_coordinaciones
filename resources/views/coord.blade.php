<x-layout>
    <x-slot:heading>
        Coord
    </x-slot:heading>    
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        
        <div>
            <h2 class="font-bold text-lg text-gray-800">Tickets de Servicios de la {{ $coord['coordinacion'] }}</h2>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            
            <a href="{{ url('/tickets/create') }}" 
               class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                </svg>
                
                + Nuevo Ticket
            </a>
            
        </div>
    </div>

    {{-- Pasamos el ID de la coordinación al componente --}}
    @livewire('ticket-search-coord', ['coordinacionId' => $coord['id_coordinacion']])

</x-layout>