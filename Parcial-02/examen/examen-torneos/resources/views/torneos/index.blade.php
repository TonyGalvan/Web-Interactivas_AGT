<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Torneos disponibles</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if ($torneos->isEmpty())
                <div class="bg-white p-6 text-gray-600 shadow-sm sm:rounded-lg">
                    No hay torneos disponibles por el momento.
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($torneos as $torneo)
                        <a href="{{ route('torneos.show', $torneo) }}"
                            class="block rounded-lg bg-white p-5 shadow-sm transition hover:shadow-md">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $torneo->nombre }}</h3>
                            <p class="text-sm text-gray-600">{{ $torneo->juego }}</p>

                            <div class="mt-4 flex items-center justify-between text-sm text-gray-700">
                                <span>{{ $torneo->fecha->format('d/m/Y') }}</span>
                                <span>{{ $torneo->jugadores_count }} / {{ $torneo->cupo }} plazas</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
