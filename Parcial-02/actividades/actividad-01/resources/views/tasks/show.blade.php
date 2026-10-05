@extends('layouts.app')

@section('titulo', 'Detalle de tarea')

@section('contenido')

@php
    $colorEstado = match($tarea->estado) {
        'pendiente' => 'secondary',
        'en_progreso' => 'primary',
        'completada' => 'success',
        default => 'secondary',
    };
    $colorPrioridad = match($tarea->prioridad) {
        'alta' => 'danger',
        'media' => 'warning',
        'baja' => 'success',
        default => 'secondary',
    };
@endphp

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-card-checklist"></i> Tarea #{{ $tarea->id }}</h5>
                <div>
                    <span class="badge bg-{{ $colorEstado }}">{{ $estados[$tarea->estado] ?? $tarea->estado }}</span>
                    <span class="badge bg-{{ $colorPrioridad }}">{{ $prioridades[$tarea->prioridad] ?? $tarea->prioridad }}</span>
                </div>
            </div>
            <div class="card-body">
                <h4>{{ $tarea->titulo }}</h4>

                @if ($tarea->descripcion)
                    <p class="text-muted">{{ $tarea->descripcion }}</p>
                @else
                    <p class="text-muted fst-italic">Sin descripción</p>
                @endif

                <hr>

                <div class="row small text-muted">
                    <div class="col-md-6 mb-2">
                        <i class="bi bi-calendar-event"></i>
                        <strong>Vencimiento:</strong>
                        {{ $tarea->vencimiento ? $tarea->vencimiento->format('d/m/Y') : 'Sin fecha' }}
                        @if ($tarea->estaVencida())
                            <span class="badge bg-danger ms-1"><i class="bi bi-exclamation-triangle-fill"></i> Vencida</span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-2">
                        <i class="bi bi-clock-history"></i>
                        <strong>Creada:</strong> {{ $tarea->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <i class="bi bi-arrow-repeat"></i>
                        <strong>Última actualización:</strong> {{ $tarea->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Volver al tablero
                    </a>

                    <div class="d-flex gap-2">
                        <a href="{{ route('tasks.edit', $tarea) }}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('tasks.destroy', $tarea) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta tarea?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
