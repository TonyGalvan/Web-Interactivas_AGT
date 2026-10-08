@php
    $categorias = ['desayuno', 'almuerzo', 'cena', 'postre', 'bebida'];
    $dificultades = ['fácil', 'media', 'difícil'];
    $campo = 'block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500';
@endphp

<div>
    <x-input-label for="titulo" value="Título" />
    <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full"
        :value="old('titulo', $receta->titulo ?? '')" />
    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="categoria" value="Categoría" />
    <select id="categoria" name="categoria" class="{{ $campo }}">
        <option value="">Selecciona una categoría</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria }}" @selected(old('categoria', $receta->categoria ?? '') === $categoria)>
                {{ ucfirst($categoria) }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('categoria')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="tiempo_minutos" value="Tiempo (minutos)" />
    <x-text-input id="tiempo_minutos" name="tiempo_minutos" type="number" class="mt-1 block w-full"
        :value="old('tiempo_minutos', $receta->tiempo_minutos ?? '')" />
    <x-input-error :messages="$errors->get('tiempo_minutos')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="dificultad" value="Dificultad" />
    <select id="dificultad" name="dificultad" class="{{ $campo }}">
        <option value="">Selecciona la dificultad</option>
        @foreach ($dificultades as $dificultad)
            <option value="{{ $dificultad }}" @selected(old('dificultad', $receta->dificultad ?? '') === $dificultad)>
                {{ ucfirst($dificultad) }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('dificultad')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="ingredientes" value="Ingredientes (uno por línea)" />
    <textarea id="ingredientes" name="ingredientes" rows="5" class="{{ $campo }}">{{ old('ingredientes', $receta->ingredientes ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('ingredientes')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="pasos" value="Pasos de preparación (uno por línea)" />
    <textarea id="pasos" name="pasos" rows="5" class="{{ $campo }}">{{ old('pasos', $receta->pasos ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('pasos')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="nota" value="Nota personal (opcional)" />
    <textarea id="nota" name="nota" rows="3" class="{{ $campo }}">{{ old('nota', $receta->nota ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('nota')" class="mt-2" />
</div>