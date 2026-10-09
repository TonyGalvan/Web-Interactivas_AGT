<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Inicio</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900">
                    ¡Hola, {{ auth()->user()->name }}!
                </h3>
                <p class="mt-1 text-gray-600">
                    Te damos la bienvenida al sistema de torneos.
                </p>

                <a href="{{ route('torneos.index') }}"
                    class="mt-4 inline-block rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                    Ver torneos
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
