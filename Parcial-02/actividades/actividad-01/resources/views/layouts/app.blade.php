<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Tareas')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { background-color: #f4f6f8; }
        .kanban-columna { background-color: #eef0f2; border-radius: .5rem; min-height: 70vh; }
        .tarea-card { cursor: default; }
        .tarea-card:hover { box-shadow: 0 .25rem .5rem rgba(0,0,0,.1); }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">
                <i class="bi bi-kanban-fill"></i> Tablero de Tareas
            </a>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Nueva tarea
            </a>
        </div>
    </nav>

    <div class="container">
        @if (session('exito'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('exito') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('contenido')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
