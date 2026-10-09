# Tablero de Tareas (Laravel)

Aplicación web de gestión de tareas con vista tipo **tablero Kanban**, hecha con Laravel, MySQL, Bootstrap 5 y Bootstrap Icons.

## Funcionalidades

- Tablero Kanban con tres columnas: **Pendiente**, **En progreso** y **Completada**.
- Crear, ver, editar y eliminar tareas (CRUD completo).
- Cambio rápido de estado desde la tarjeta de cada tarea.
- Filtros por **estado** y **prioridad** (con opción "Todos").
- Búsqueda por **texto (título) o ID**.
- Botón para limpiar los filtros aplicados.
- Prioridades: baja, media y alta (con colores distintos).
- Fecha de vencimiento opcional, con aviso visual cuando una tarea está vencida.
- Validación de formularios con mensajes en español.

## Tecnologías

- PHP 8.2 o superior
- Laravel 11 o superior
- MySQL
- Blade (motor de plantillas de Laravel)
- Bootstrap 5.3 y Bootstrap Icons 1.11 (cargados por CDN, no requieren instalación)

## Requisitos previos

Antes de levantar el proyecto necesitas tener instalado:

| Herramienta | Versión recomendada | Para qué se usa |
|---|---|---|
| PHP | 8.2 o superior | Ejecutar Laravel |
| Composer | 2.x | Instalar dependencias de PHP |
| MySQL | 5.7+ / 8.x | Base de datos |
| phpMyAdmin (opcional) | cualquiera | Crear la base de datos desde una interfaz |
| Git | cualquiera | Clonar el repositorio |

> Una forma sencilla de tener PHP, MySQL y phpMyAdmin juntos es instalar **XAMPP**, **Laragon** o **WAMP**.
> No necesitas Node.js ni npm, porque Bootstrap se carga por CDN (necesitas conexión a internet para ver los estilos).

Puedes verificar tus versiones con:

```bash
php -v
composer -V
```

## Instalación paso a paso

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd <nombre-de-la-carpeta-del-proyecto>
```

### 2. Instalar las dependencias de PHP

```bash
composer install
```

### 3. Crear el archivo de entorno

Copia el archivo de ejemplo:

```bash
# Linux / macOS / Git Bash
cp .env.example .env

# Windows (CMD)
copy .env.example .env
```

### 4. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 5. Crear la base de datos

1. Inicia **MySQL** desde XAMPP / Laragon / WAMP.
2. Entra a phpMyAdmin (normalmente `http://localhost/phpmyadmin`).
3. Ve a la pestaña **Bases de datos**, escribe un nombre (por ejemplo `tareas_app`), elige el cotejamiento `utf8mb4_unicode_ci` y haz clic en **Crear**.

> Solo crea la base de datos **vacía**. Las tablas las crea Laravel con las migraciones.

### 6. Configurar la conexión en el `.env`

Abre el archivo `.env` y ajusta estas variables con los datos de tu MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tareas_app
DB_USERNAME=root
DB_PASSWORD=
```

> `DB_DATABASE` debe coincidir con el nombre que le pusiste a la base de datos. Con XAMPP el usuario suele ser `root` sin contraseña.

Si ya habías corrido el proyecto antes con otra configuración, limpia la caché:

```bash
php artisan config:clear
```

### 7. Ejecutar las migraciones

```bash
php artisan migrate
```

Esto crea las tablas del proyecto en tu base de datos, entre ellas `tasks` (con las columnas `id`, `titulo`, `descripcion`, `estado`, `prioridad`, `vencimiento`, `created_at`, `updated_at`).

### 8. Levantar el servidor

```bash
php artisan serve
```

Abre en el navegador: **http://127.0.0.1:8000**

La raíz del sitio redirige al tablero de tareas (`/tasks`). Deja la terminal abierta mientras uses la aplicación; para detener el servidor presiona `Ctrl + C`.