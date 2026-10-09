@csrf

<div>
    <x-input-label for="nombre" value="Nombre del torneo" />
    <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full"
        :value="old('nombre', $torneo->nombre)" />
    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
</div>

<div>
    <x-input-label for="juego" value="Juego o deporte" />
    <x-text-input id="juego" name="juego" type="text" class="mt-1 block w-full"
        :value="old('juego', $torneo->juego)" />
    <x-input-error :messages="$errors->get('juego')" class="mt-2" />
</div>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div>
        <x-input-label for="fecha" value="Fecha" />
        <x-text-input id="fecha" name="fecha" type="date" class="mt-1 block w-full"
            :value="old('fecha', $torneo->fecha?->format('Y-m-d'))" />
        <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="cupo" value="Cupo (2 a 100)" />
        <x-text-input id="cupo" name="cupo" type="number" class="mt-1 block w-full"
            :value="old('cupo', $torneo->cupo)" />
        <x-input-error :messages="$errors->get('cupo')" class="mt-2" />
    </div>
</div>

<div>
    <x-input-label for="descripcion" value="Descripción (opcional)" />
    <textarea id="descripcion" name="descripcion" rows="4"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $torneo->descripcion) }}</textarea>
    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
</div>

<div class="flex items-center">
    <input id="abierto" name="abierto" type="checkbox" value="1"
        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
        @checked(old('abierto', $torneo->abierto))>
    <label for="abierto" class="ms-2 text-sm text-gray-700">Torneo abierto a inscripciones</label>
</div>