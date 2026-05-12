# Sans Inc.

Sans Inc. es una plataforma web desarrollada en equipo con Laravel. El proyecto usa una arquitectura web tradicional: Laravel maneja el backend, renderiza vistas Blade y entrega una interfaz frontend construida con HTML, CSS, JavaScript, Bootstrap y Vite.

## Tecnologias principales

- **Backend:** PHP 8.1+, Laravel 10
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap, Blade
- **Base de datos:** MySQL
- **Herramientas:** Composer, Node.js, npm, Vite, Git

## Estructura del proyecto

El proyecto no esta separado en dos repositorios. Backend y frontend viven dentro del mismo proyecto Laravel, pero se organizan por carpetas:

```text
sans-inc-pagina-web/
+-- app/                 # Backend: codigo principal de Laravel
|   +-- DTOs/            # Objetos para transportar datos entre capas
|   +-- Http/
|   |   +-- Controllers/ # Controladores
|   |   +-- Middleware/  # Middlewares
|   |   +-- Requests/    # Validaciones de entrada
|   +-- Models/          # Modelos Eloquent
|   +-- Repositories/
|   |   +-- Interfaces/  # Contratos de repositorios
|   |   +-- Eloquent/    # Implementaciones con Eloquent
|   +-- Services/        # Logica de negocio
+-- routes/              # Backend: rutas web, API, consola y canales
+-- database/            # Backend: migraciones, seeders y factories
+-- config/              # Backend: configuracion del framework y servicios
+-- resources/
|   +-- views/           # Frontend: vistas Blade
|   +-- css/             # Frontend: estilos
|   +-- js/              # Frontend: JavaScript
+-- public/              # Frontend publico: index.php, imagenes, favicon y assets compilados
+-- composer.json        # Dependencias PHP
+-- package.json         # Dependencias frontend
+-- .env.example         # Plantilla de configuracion local
```

### Guia rapida para el equipo

- Si trabajas en backend, normalmente editaras `app/`, `routes/`, `database/` y `config/`.
- Si trabajas en frontend, normalmente editaras `resources/views/`, `resources/css/`, `resources/js/` y algunos archivos dentro de `public/`.
- El flujo recomendado para backend es: `Models` -> `Repositories` -> `Services` -> `DTOs` -> `Controllers` / `Middleware`.
- No editar ni subir `vendor/`, `node_modules/` ni `.env`.
- Si agregas dependencias PHP, se actualizan `composer.json` y `composer.lock`.
- Si agregas dependencias frontend, se actualizan `package.json` y `package-lock.json`.

## Requisitos previos

Asegurate de tener instalados los siguientes programas antes de comenzar:

- PHP 8.1 o superior
- Composer
- Node.js y npm
- MySQL
- Git

Para Windows se recomienda usar [Laragon](https://laragon.org/download/) como servidor local, ya que facilita el uso de PHP y MySQL.

**Gestores de paquetes y control de versiones:**
- [Composer](https://getcomposer.org/) (Obligatorio para descargar dependencias de Laravel)
- [Node.js y npm](https://nodejs.org/) (Obligatorio para Vite y dependencias de Frontend)

Tambien se recomienda usar PhpStorm o Visual Studio Code como entorno de desarrollo.

## Guia de instalacion

### 1. Clonar el repositorio

```bash
git clone https://github.com/SebastianGalvez02/sans-inc-pagina-web.git
cd sans-inc-pagina-web
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar variables de entorno

Copia el archivo de ejemplo:

```bash
cp .env.example .env
```

En Windows CMD:

```cmd
copy .env.example .env
```

Importante: nunca subas tu archivo `.env` al repositorio. Cada integrante debe tener su propio archivo `.env` local.

### 4. Generar la clave de la aplicacion

```bash
php artisan key:generate
```

### 5. Configurar la base de datos

Crea una base de datos local:

```sql
CREATE DATABASE sans_inc_pagina_web;
```

Luego revisa tu archivo `.env` y ajusta estos valores segun tu configuracion local:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sans_inc_pagina_web
DB_USERNAME=root
DB_PASSWORD=tu_contrasena_local
```

Si usas Laragon y tu usuario `root` no tiene contrasena, deja `DB_PASSWORD=` vacio.

### 6. Ejecutar migraciones

```bash
php artisan migrate
```

Si existen seeders preparados para datos de prueba, puedes usar:

```bash
php artisan migrate --seed
```

## Ejecucion del proyecto

Para trabajar y ver cambios en tiempo real, abre dos terminales.

Terminal 1: servidor de Laravel

```bash
php artisan serve
```

Terminal 2: compilador frontend con Vite

```bash
npm run dev
```

Luego abre la URL que muestra Laravel, normalmente:

```text
http://127.0.0.1:8000
```

## Antes de subir cambios

Antes de hacer commit o push, revisa:

```bash
git status
```

No deben subirse estos archivos o carpetas:

- `.env`
- `vendor/`
- `node_modules/`
- `public/build/`

Estos archivos si deben subirse cuando cambian:

- `composer.json`
- `composer.lock`
- `package.json`
- `package-lock.json`
- archivos dentro de `app/`, `routes/`, `database/`, `resources/`, `public/`, `config/` y `tests/`
