# Sistema de Torneos con Roles

Aplicación web hecha con Laravel donde un **administrador** crea y gestiona torneos (fútbol, básquet, videojuegos, etc.) y los **jugadores** se inscriben para participar. Los visitantes sin cuenta solo pueden consultar los torneos.

**Tecnologías:** Laravel, Laravel Breeze (Blade), Tailwind CSS y MySQL.

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js y npm
- MySQL

## Instalación

1. Clona el repositorio y entra a la carpeta del proyecto:

```bash
   git clone <URL-DEL-REPOSITORIO>
   cd examen-torneos
```

2. Instala las dependencias:

```bash
   composer install
   npm install
```

3. Crea el archivo de entorno y genera la clave:

```bash
   cp .env.example .env
   php artisan key:generate
```

4. Crea en MySQL una base de datos llamada `torneos`:

```sql
   CREATE DATABASE torneos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

5. Configura la conexión en el archivo `.env` (ajusta usuario y contraseña a tu instalación):

```env
   APP_LOCALE=es
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=torneos
   DB_USERNAME=root
   DB_PASSWORD=
```

6. Crea las tablas y las cuentas demo:

```bash
   php artisan migrate --seed
```

7. Compila los estilos y levanta el servidor (en dos terminales):

```bash
   npm run dev
   php artisan serve
```

8. Abre `http://localhost:8000`.

Para reiniciar la base de datos desde cero: `php artisan migrate:fresh --seed`.

## Cuentas demo

| Rol           | Correo                | Contraseña    |
|---------------|-----------------------|---------------|
| Administrador | admin@torneos.test    | admin1234     |
| Jugador       | jugador@torneos.test  | jugador1234   |

**Cómo se crea el administrador:** mediante el seeder `database/seeders/DatabaseSeeder.php`, que se ejecuta con `php artisan migrate --seed`. Cualquier persona que se registre desde la aplicación recibe automáticamente el rol **jugador**.

## Reglas del sistema

- Un torneo está **cerrado** si el administrador lo marca como cerrado, si su fecha ya pasó o si se llenó el cupo.
- El listado público muestra solo torneos abiertos, de fecha futura y con plaza libre, ordenados por fecha próxima. Los cerrados o llenos solo se ven abriendo su detalle directamente.
- Cupo de 2 a 100 jugadores (16 por defecto). No se puede reducir el cupo por debajo de los jugadores ya inscritos.
- Al eliminar un torneo se eliminan también sus inscripciones.
- Un jugador no puede inscribirse dos veces en el mismo torneo, y puede cancelar su inscripción hasta la fecha del evento, lo que libera la plaza.

## Cómo probar cada punto

**1. Registro, inicio y cierre de sesión con roles**
- Entra a *Registrarse* y crea una cuenta: queda con rol jugador.
- Inicia sesión con las cuentas demo y cierra sesión desde el menú de usuario.

**2. El administrador crea, edita y elimina torneos**
- Inicia sesión como administrador y entra a *Administrar torneos*.
- Crea un torneo con *Nuevo torneo*. Envía el formulario vacío para ver los errores por campo; prueba una fecha pasada y un cupo menor a 2 o mayor a 100.
- Edita un torneo, y elimínalo (pide confirmación).
- Con un torneo que tenga 3 jugadores inscritos, intenta bajar el cupo a 2: no se permite.

**3. Listado y detalle de torneos**
- Sin iniciar sesión, abre la página de inicio: se ven solo los torneos disponibles, ordenados por fecha. Si no hay ninguno, aparece un mensaje.
- Abre el detalle de un torneo: se ven sus datos y la lista de participantes.

**4. Inscripciones del jugador**
- Como jugador, abre un torneo y pulsa *Inscribirme*.
- Para probar el duplicado, abre el mismo torneo en dos pestañas e inscríbete en ambas.
- Llena un torneo (cupo 2 con dos jugadores): desaparece del listado y su detalle indica que está lleno.
- Entra a *Mis torneos* y cancela una inscripción: la plaza se libera.

**5. El administrador gestiona inscritos y permisos**
- Como administrador, en *Administrar torneos* pulsa *Inscritos* y usa *Dar de baja* sobre un jugador.
- Como jugador, intenta abrir `/admin/torneos`: redirige a Torneos con un aviso.
- Sin iniciar sesión, intenta abrir `/admin/torneos` o `/mis-torneos`: redirige al login con un aviso.

**6. Mensajes en español**
- Los avisos de éxito y error aparecen en recuadros verdes o rojos, y los errores de formulario bajo cada campo.