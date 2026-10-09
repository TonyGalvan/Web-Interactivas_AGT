<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar torneo</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.torneos.update', $torneo) }}" class="space-y-6" novalidate>
                    @method('PUT')
                    @include('admin.torneos._form')

                    <div class="flex items-center gap-4">
                        <x-primary-button>Guardar cambios</x-primary-button>
                        <a href="{{ route('admin.torneos.index') }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>