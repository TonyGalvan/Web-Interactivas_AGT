<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Mis torneos</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg">
                @if ($torneos->isEmpty())
                    <div class="p-6 text-gray-600">
                        Todavía no estás inscrito en ningún torneo.
                        <a href="{{ route('torneos.index') }}" class="text-indigo-600 hover:underline">Ver torneos
                            disponibles</a>
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Torneo</th>
                                <th class="px-4 py-3">Juego / deporte</th>
                                <th class="px-4 py-3">Fecha</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($torneos as $torneo)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        <a href="{{ route('torneos.show', $torneo) }}"
                                            class="hover:underline">{{ $torneo->nombre }}</a>
                                    </td>
                                    <td class="px-4 py-3">{{ $torneo->juego }}</td>
                                    <td class="px-4 py-3">{{ $torneo->fecha->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">
                                        @if ($torneo->vencido())
                                            <span
                                                class="rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">Finalizado</span>
                                        @else
                                            <span
                                                class="rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Inscrito</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        @unless ($torneo->vencido())
                                            <form method="POST" action="{{ route('inscripciones.destroy', $torneo) }}"
                                                onsubmit="return confirm('¿Cancelar tu inscripción en este torneo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Cancelar
                                                    inscripción</button>
                                            </form>
                                        @endunless
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
