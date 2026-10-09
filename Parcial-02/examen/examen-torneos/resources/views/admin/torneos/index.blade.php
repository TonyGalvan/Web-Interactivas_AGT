<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Torneos</h2>
            <a href="{{ route('admin.torneos.create') }}"
                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                Nuevo torneo
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg">
                @if ($torneos->isEmpty())
                    <p class="p-6 text-gray-600">Aún no hay torneos creados.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Nombre</th>
                                <th class="px-4 py-3">Juego / deporte</th>
                                <th class="px-4 py-3">Fecha</th>
                                <th class="px-4 py-3">Plazas</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($torneos as $torneo)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $torneo->nombre }}</td>
                                    <td class="px-4 py-3">{{ $torneo->juego }}</td>
                                    <td class="px-4 py-3">{{ $torneo->fecha->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">{{ $torneo->jugadores_count }} / {{ $torneo->cupo }}</td>
                                    <td class="px-4 py-3">
                                        @if ($torneo->vencido())
                                            <span
                                                class="rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">Vencido</span>
                                        @elseif (!$torneo->abierto)
                                            <span
                                                class="rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Cerrado</span>
                                        @elseif ($torneo->lleno())
                                            <span
                                                class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">Lleno</span>
                                        @else
                                            <span
                                                class="rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Abierto</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('admin.torneos.inscripciones.index', $torneo) }}"
                                                class="text-gray-700 hover:underline">Inscritos</a>
                                            <a href="{{ route('admin.torneos.edit', $torneo) }}"
                                                class="text-indigo-600 hover:underline">Editar</a>
                                            <form method="POST" action="{{ route('admin.torneos.destroy', $torneo) }}"
                                                onsubmit="return confirm('¿Eliminar este torneo y todas sus inscripciones?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:underline">Eliminar</button>
                                            </form>
                                        </div>
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
