@extends('layouts.app')

@section('titulo', 'Editar tarea')

@section('contenido')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Editar tarea #{{ $tarea->id }}</h5>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('tasks.update', $tarea) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" value="{{ old('titulo', $tarea->titulo) }}"
                               class="form-control @error('titulo') is-invalid @enderror" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" rows="3"
                                  class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $tarea->descripcion) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select @error('estado') is-invalid @enderror">
                                @foreach ($estados as $clave => $etiqueta)
                                    <option value="{{ $clave }}" @selected(old('estado', $tarea->estado) === $clave)>
                                        {{ $etiqueta }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Prioridad</label>
                            <select name="prioridad" class="form-select @error('prioridad') is-invalid @enderror">
                                @foreach ($prioridades as $clave => $etiqueta)
                                    <option value="{{ $clave }}" @selected(old('prioridad', $tarea->prioridad) === $clave)>
                                        {{ $etiqueta }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Vencimiento</label>
                            <input type="date" name="vencimiento"
                                   value="{{ old('vencimiento', optional($tarea->vencimiento)->format('Y-m-d')) }}"
                                   class="form-control @error('vencimiento') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Guardar cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
