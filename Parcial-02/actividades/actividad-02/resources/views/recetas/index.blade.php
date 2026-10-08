<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mis recetas</h2>
            <a href="{{ route('recetas.create') }}"
                class="px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase rounded-md hover:bg-gray-700">
                Nueva receta
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('exito'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('exito') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="GET" action="{{ route('recetas.index') }}" class="flex flex-wrap items-end gap-3 mb-6">
                    <div>
                        <label for="buscar" class="block text-sm text-gray-700">Buscar por título</label>
                        <input id="buscar" name="buscar" type="text" value="{{ $buscar }}"
                            placeholder="Ej. pastel"
                            class="mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="categoria" class="block text-sm text-gray-700">Categoría</label>
                        <select id="categoria" name="categoria"
                            class="mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todas</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat }}" @selected($categoria === $cat)>{{ ucfirst($cat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase rounded-md hover:bg-gray-700">
                        Filtrar
                    </button>

                    @if ($buscar || $categoria)
                        <a href="{{ route('recetas.index') }}" class="text-sm text-gray-600 underline">Limpiar</a>
                    @endif
                </form>
                @if ($recetas->isEmpty())
                    @if ($buscar || $categoria)
                        <p class="text-gray-600">No se encontraron recetas con esos criterios.</p>
                    @else
                        <p class="text-gray-600">Aún no tienes recetas. ¡Crea la primera!</p>
                    @endif
                @else
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b text-gray-600">
                                <th class="py-2">Título</th>
                                <th class="py-2">Categoría</th>
                                <th class="py-2">Tiempo</th>
                                <th class="py-2">Dificultad</th>
                                <th class="py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recetas as $receta)
                                <tr class="border-b">
                                    <td class="py-2">
                                        <a href="{{ route('recetas.show', $receta) }}"
                                            class="text-indigo-600 hover:underline">
                                            {{ $receta->titulo }}
                                        </a>
                                    </td>
                                    <td class="py-2">{{ ucfirst($receta->categoria) }}</td>
                                    <td class="py-2">{{ $receta->tiempo_minutos }} min</td>
                                    <td class="py-2">{{ ucfirst($receta->dificultad) }}</td>

                                    <td class="py-2">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('recetas.edit', $receta) }}"
                                                class="text-blue-600 hover:underline">Editar</a>

                                            <form method="POST" action="{{ route('recetas.destroy', $receta) }}"
                                                onsubmit="return confirm('¿Seguro que quieres eliminar esta receta?')">
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
