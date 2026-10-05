@extends('layouts.app')

@section('titulo', 'Tablero de Tareas')

@section('contenido')

{{-- Filtros y búsqueda --}}
<form method="GET" action="{{ route('tasks.index') }}" class="row g-2 mb-4 align-items-end">
    <div class="col-md-4">
        <label class="form-label small text-muted mb-1">Buscar por título o ID</label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" name="q" value="{{ $filtros['q'] ?? '' }}" class="form-control"
                   placeholder="Ej. Comprar insumos o 12">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </div>

    <div class="col-md-3">
        <label class="form-label small text-muted mb-1">Estado</label>
        <select name="estado" class="form-select" onchange="this.form.submit()">
            <option value="">Todos los estados</option>
            @foreach ($estados as $clave => $etiqueta)
                <option value="{{ $clave }}" @selected(($filtros['estado'] ?? '') === $clave)>
                    {{ $etiqueta }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label small text-muted mb-1">Prioridad</label>
        <select name="prioridad" class="form-select" onchange="this.form.submit()">
            <option value="">Todas las prioridades</option>
            @foreach ($prioridades as $clave => $etiqueta)
                <option value="{{ $clave }}" @selected(($filtros['prioridad'] ?? '') === $clave)>
                    {{ $etiqueta }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger w-100">
            <i class="bi bi-x-circle"></i> Limpiar filtros
        </a>
    </div>
</form>

{{-- Columnas del tablero --}}
<div class="row g-3">
    @foreach ($estados as $claveEstado => $etiquetaEstado)
        <div class="col-md-4">
            <div class="kanban-columna p-3">
                <h5 class="mb-3 d-flex justify-content-between align-items-center">
                    <span>
                        @switch($claveEstado)
                            @case('pendiente') <i class="bi bi-hourglass-split text-secondary"></i> @break
                            @case('en_progreso') <i class="bi bi-arrow-repeat text-primary"></i> @break
                            @case('completada') <i class="bi bi-check-circle-fill text-success"></i> @break
                        @endswitch
                        {{ $etiquetaEstado }}
                    </span>
                    <span class="badge bg-secondary rounded-pill">
                        {{ optional($tareasPorEstado->get($claveEstado))->count() ?? 0 }}
                    </span>
                </h5>

                @forelse ($tareasPorEstado[$claveEstado] ?? [] as $tarea)
                    <div class="card tarea-card mb-2 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="card-title mb-1">
                                    <a href="{{ route('tasks.show', $tarea) }}" class="text-decoration-none text-dark">
                                        #{{ $tarea->id }} — {{ $tarea->titulo }}
                                    </a>
                                </h6>

                                @php
                                    $colorPrioridad = match($tarea->prioridad) {
                                        'alta' => 'danger',
                                        'media' => 'warning',
                                        'baja' => 'success',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $colorPrioridad }}">
                                    {{ $prioridades[$tarea->prioridad] ?? $tarea->prioridad }}
                                </span>
                            </div>

                            @if ($tarea->descripcion)
                                <p class="card-text text-muted small mb-2">
                                    {{ Str::limit($tarea->descripcion, 60) }}
                                </p>
                            @endif

                            @if ($tarea->vencimiento)
                                <p class="small mb-2 {{ $tarea->estaVencida() ? 'text-danger fw-bold' : 'text-muted' }}">
                                    <i class="bi bi-calendar-event"></i>
                                    {{ $tarea->vencimiento->format('d/m/Y') }}
                                    @if ($tarea->estaVencida())
                                        <i class="bi bi-exclamation-triangle-fill"></i> Vencida
                                    @endif
                                </p>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                {{-- Cambiar estado --}}
                                <form action="{{ route('tasks.changeStatus', $tarea) }}" method="POST" class="d-flex gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                                        @foreach ($estados as $clave => $etiqueta)
                                            <option value="{{ $clave }}" @selected($tarea->estado === $clave)>
                                                {{ $etiqueta }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>

                                {{-- Acciones --}}
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('tasks.edit', $tarea) }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $tarea) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar esta tarea?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small text-center py-4">
                        <i class="bi bi-inbox"></i><br>Sin tareas
                    </p>
                @endforelse
            </div>
        </div>
    @endforeach
</div>

@endsection
