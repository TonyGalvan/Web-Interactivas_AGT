# Recetario casero

Aplicación web hecha con Laravel donde cada usuario se registra, inicia sesión y guarda sus propias recetas de cocina: puede crearlas, consultarlas, editarlas, eliminarlas, buscarlas por título y filtrarlas por categoría. Cada usuario solo ve y gestiona sus propias recetas.

Actividad individual de Laravel: rutas, controlador de recurso, migraciones, validación y vistas con Tailwind.

## Tecnologías

- Laravel (con Laravel Breeze para el registro y el inicio de sesión)
- Blade como motor de plantillas
- Tailwind CSS (clases utilitarias) con Vite
- MySQL

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js y npm
- MySQL (por ejemplo, con XAMPP o Laragon)
- phpMyAdmin o cualquier cliente de MySQL para crear la base de datos

Para comprobar que están instalados:

```bash
php -v
composer -V
node -v
npm -v
```

## Instalación

1. Clonar el repositorio y entrar en ella:

   ```bash
   git clone <URL-DEL-REPOSITORIO>
   cd actividad-02
   ```

2. Instalar las dependencias de PHP y de JavaScript:

   ```bash
   composer install
   npm install
   ```

3. Crear el archivo de configuración y generar la llave de la aplicación:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   En Windows con PowerShell, el primer comando es `copy .env.example .env`.

## Cómo crear la base de datos

1. Encender MySQL (en XAMPP, el módulo MySQL debe estar en verde).
2. Crear una base de datos vacía, por ejemplo `recetario`, desde phpMyAdmin o desde la consola de MySQL:

   ```sql
   CREATE DATABASE recetario CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. Abrir el archivo `.env` y configurar la conexión, además del nombre y el idioma de la aplicación:

   ```
   APP_NAME="Recetario casero"
   APP_LOCALE=es

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=recetario
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Ajustar `DB_USERNAME` y `DB_PASSWORD` a los de tu instalación de MySQL.

4. Crear las tablas ejecutando las migraciones:

   ```bash
   php artisan migrate
   ```

   Esto crea las tablas de usuarios y demás tablas base de Laravel, además de la tabla `recetas`, que está ligada al usuario que la crea.

## Cómo ejecutar los seeders

Los seeders cargan dos usuarios de prueba con recetas de ejemplo, útiles para probar la aplicación sin registrar nada a mano.

Si la base de datos está recién creada (o no importa perder su contenido), el comando más simple crea las tablas y carga los datos en un solo paso:

```bash
php artisan migrate:fresh --seed
```

Atención: `migrate:fresh` **borra todas las tablas y las vuelve a crear**, así que se pierde cualquier usuario o receta existente.

Si ya ejecutaste `php artisan migrate` y la base está vacía, basta con:

```bash
php artisan db:seed
```

Este comando falla si ya existen usuarios con los mismos correos. En ese caso, usar `migrate:fresh --seed`.

### Usuarios de prueba

| Nombre | Correo | Contraseña | Recetas de ejemplo |
|--------|--------|------------|--------------------|
| Ana | ana@example.com | password | Hot cakes caseros, Pastel de chocolate |
| Luis | luis@example.com | password | Agua de jamaica |

## Cómo ejecutar el proyecto

Se necesitan dos terminales abiertas en la carpeta del proyecto:

```bash
php artisan serve
```

```bash
npm run dev
```

Después, abrir en el navegador `http://127.0.0.1:8000`. La raíz redirige al inicio de sesión (o al listado de recetas si ya hay una sesión iniciada).

## Cómo probar cada fase

### Fase 0: Preparación

1. Abrir `http://127.0.0.1:8000/register` y crear un usuario nuevo.
2. Comprobar que el usuario nuevo entra a un recetario vacío: en **Mis recetas** aparece el mensaje "Aún no tienes recetas".
3. Cerrar sesión e iniciar sesión de nuevo con el mismo usuario.
4. Revisar en la base de datos que existe la tabla `recetas` y que el usuario aparece en `users`.

### Fase 1: Crear y ver recetas

1. Pulsar **Nueva receta** y enviar el formulario con datos inválidos (título vacío, tiempo 0, sin categoría ni dificultad): los errores aparecen junto a cada campo, en español.
2. Crear una receta válida: aparece en la tabla con título, categoría, tiempo y dificultad, y se muestra un mensaje de éxito.
3. Abrir el detalle de la receta: los ingredientes se ven como lista con viñetas y los pasos como lista numerada.

### Fase 2: Editar y eliminar

1. Pulsar **Editar** en una receta: el formulario aparece con los datos actuales y las mismas validaciones.
2. Borrar el título y guardar: se muestra el error junto al campo y se conserva lo demás.
3. Guardar un cambio válido: se refleja en el listado con un mensaje de éxito.
4. Pulsar **Eliminar**: aparece una confirmación. Al cancelar no pasa nada; al aceptar, la receta desaparece con un mensaje de éxito.

### Fase 3: Buscar y filtrar

Se recomienda entrar como Ana (`ana@example.com`), que tiene recetas de distintas categorías.

1. Escribir una palabra del título en el buscador (por ejemplo, "pastel"): solo aparecen las recetas que coinciden.
2. Elegir una categoría (por ejemplo, "Desayuno"): solo aparecen las de esa categoría.
3. Combinar búsqueda y categoría: se cumplen ambos filtros a la vez.
4. Buscar algo que no existe: se muestra el mensaje "No se encontraron recetas con esos criterios".
5. Pulsar **Limpiar** para volver al listado completo.

### Privacidad entre usuarios

1. Entrar como Ana: solo se ven sus dos recetas.
2. Cerrar sesión y entrar como Luis: solo se ve "Agua de jamaica".
3. Con Luis, intentar abrir la dirección de una receta de Ana (por ejemplo, `/recetas/1`): la aplicación responde con un error 403.

## Comprobación final

| # | Prueba | Resultado esperado |
|---|--------|--------------------|
| 1 | Registrarse con un usuario nuevo | Entra a un recetario vacío propio |
| 2 | Crear receta válida / con datos inválidos | Aparece en el listado / errores junto a cada campo |
| 3 | Abrir el detalle de una receta | Se ven ingredientes y pasos como listas |
| 4 | Editar y guardar / eliminar con confirmación | Cambios reflejados / desaparece con mensaje de éxito |
| 5 | Buscar por título y filtrar por categoría | Solo coinciden los resultados; aviso si no hay ninguno |
| 6 | Entrar con otro usuario distinto | No ve las recetas del primero |

## Datos de cada receta

Título (obligatorio), categoría (obligatoria: desayuno, almuerzo, cena, postre o bebida), tiempo en minutos (mayor a 0), dificultad (fácil, media o difícil), ingredientes (texto, uno por línea), pasos de preparación (texto, uno por línea) y nota personal (opcional).

## Estructura principal

- `app/Models/Receta.php`: modelo de la receta y su relación con el usuario.
- `app/Http/Controllers/RecetaController.php`: controlador de recurso (listado con búsqueda y filtro, crear, ver, editar y eliminar).
- `app/Http/Requests/RecetaRequest.php`: validaciones y mensajes de error en español.
- `database/migrations/`: migración de la tabla `recetas`.
- `database/seeders/DatabaseSeeder.php`: usuarios y recetas de ejemplo.
- `resources/views/recetas/`: vistas del listado, formulario, detalle y edición.
- `lang/es.json`: traducciones al español de la interfaz.
- `routes/web.php`: ruta de recurso `recetas`, protegida con autenticación.

## Notas

- Cada receta pertenece al usuario que la creó y todas las consultas se limitan a sus propias recetas. Si un usuario intenta abrir, editar o eliminar la receta de otro, la aplicación responde con un error 403.
- La interfaz y los mensajes están en español.
