@php
    $ingredientes = array_filter(array_map('trim', explode("\n", $receta->ingredientes)));
    $pasos = array_filter(array_map('trim', explode("\n", $receta->pasos)));
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $receta->titulo }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <p class="text-sm text-gray-600">
                    {{ ucfirst($receta->categoria) }} · {{ $receta->tiempo_minutos }} min · Dificultad
                    {{ $receta->dificultad }}
                </p>

                <h3 class="mt-6 font-semibold text-gray-800">Ingredientes</h3>
                <ul class="mt-2 list-disc list-inside text-gray-700">
                    @foreach ($ingredientes as $ingrediente)
                        <li>{{ $ingrediente }}</li>
                    @endforeach
                </ul>

                <h3 class="mt-6 font-semibold text-gray-800">Pasos</h3>
                <ol class="mt-2 list-decimal list-inside text-gray-700">
                    @foreach ($pasos as $paso)
                        <li>{{ $paso }}</li>
                    @endforeach
                </ol>

                @if ($receta->nota)
                    <h3 class="mt-6 font-semibold text-gray-800">Nota personal</h3>
                    <p class="mt-2 text-gray-700">{{ $receta->nota }}</p>
                @endif

                <a href="{{ route('recetas.index') }}" class="inline-block mt-6 text-sm text-gray-600 underline">
                    ← Volver a mis recetas
                </a>

                <a href="{{ route('recetas.edit', $receta) }}"
                    class="inline-block mt-6 ml-4 text-sm text-blue-600 hover:underline">Editar receta</a>
            </div>
        </div>
    </div>
</x-app-layout>
