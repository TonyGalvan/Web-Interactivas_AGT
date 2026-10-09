<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Inscritos en {{ $torneo->nombre }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl space-y-4 sm:px-6 lg:px-8">
            <p class="text-sm text-gray-700">
                Plazas ocupadas: <strong>{{ $torneo->inscritos() }} / {{ $torneo->cupo }}</strong>
            </p>

            <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg">
                @if ($torneo->jugadores->isEmpty())
                    <p class="p-6 text-gray-600">Este torneo todavía no tiene inscritos.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Jugador</th>
                                <th class="px-4 py-3">Correo</th>
                                <th class="px-4 py-3">Inscrito el</th>
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($torneo->jugadores as $jugador)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $jugador->name }}</td>
                                    <td class="px-4 py-3">{{ $jugador->email }}</td>
                                    <td class="px-4 py-3">{{ $jugador->pivot->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <form method="POST"
                                            action="{{ route('admin.torneos.inscripciones.destroy', [$torneo, $jugador]) }}"
                                            onsubmit="return confirm('¿Dar de baja a este jugador del torneo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Dar de
                                                baja</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <a href="{{ route('admin.torneos.index') }}" class="inline-block text-sm text-indigo-600 hover:underline">
                &larr; Volver a torneos
            </a>
        </div>
    </div>
</x-app-layout>
