<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ $torneo->nombre }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                    <div>
                        <dt class="font-semibold text-gray-600">Juego o deporte</dt>
                        <dd class="text-gray-900">{{ $torneo->juego }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-600">Fecha</dt>
                        <dd class="text-gray-900">{{ $torneo->fecha->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-600">Plazas</dt>
                        <dd class="text-gray-900">{{ $torneo->inscritos() }} / {{ $torneo->cupo }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-600">Estado</dt>
                        <dd>
                            @if ($torneo->vencido())
                                <span
                                    class="rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">Finalizado</span>
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
                        </dd>
                    </div>
                </dl>

                @if ($torneo->descripcion)
                    <p class="mt-4 text-sm text-gray-700">{{ $torneo->descripcion }}</p>
                @endif

                {{-- Acción según el rol y el estado --}}
                <div class="mt-6">
                    @guest
                        <p class="text-sm text-gray-600">
                            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Inicia sesión</a>
                            o
                            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">regístrate</a>
                            para inscribirte en este torneo.
                        </p>
                    @elseif (auth()->user()->esJugador())
                        @if ($torneo->jugadores->contains(auth()->id()))
                            @unless ($torneo->vencido())
                                <form method="POST" action="{{ route('inscripciones.destroy', $torneo) }}"
                                    onsubmit="return confirm('¿Cancelar tu inscripción en este torneo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-500">
                                        Cancelar inscripción
                                    </button>
                                </form>
                            @endunless
                        @elseif ($torneo->vencido())
                            <p class="text-sm text-gray-600">Este torneo ya se realizó.</p>
                        @elseif (!$torneo->abierto)
                            <p class="text-sm text-red-700">Este torneo está cerrado a inscripciones.</p>
                        @elseif ($torneo->lleno())
                            <p class="text-sm text-yellow-700">Este torneo ya no tiene plazas disponibles.</p>
                        @else
                            <form method="POST" action="{{ route('inscripciones.store', $torneo) }}">
                                @csrf
                                <button type="submit"
                                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                                    Inscribirme
                                </button>
                            </form>
                        @endif
                    @else
                        <p class="text-sm text-gray-600">Los administradores gestionan los torneos pero no se inscriben.
                        </p>
                    @endguest
                </div>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="mb-3 text-lg font-semibold text-gray-900">Participantes</h3>

                @forelse ($torneo->jugadores as $jugador)
                    <p class="border-b border-gray-100 py-2 text-sm text-gray-800 last:border-0">
                        {{ $loop->iteration }}. {{ $jugador->name }}
                    </p>
                @empty
                    <p class="text-sm text-gray-600">Todavía no hay jugadores inscritos.</p>
                @endforelse
            </div>

            <a href="{{ route('torneos.index') }}" class="inline-block text-sm text-indigo-600 hover:underline">
                &larr; Volver al listado
            </a>
        </div>
    </div>
</x-app-layout>
