<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar receta</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('recetas.update', $receta) }}">
                    @csrf
                    @method('PUT')
                    @include('recetas._form')

                    <div class="flex items-center gap-4 mt-6">
                        <x-primary-button>Guardar cambios</x-primary-button>
                        <a href="{{ route('recetas.index') }}" class="text-sm text-gray-600 underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>