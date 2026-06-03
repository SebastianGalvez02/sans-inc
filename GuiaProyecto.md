# Guía del Proyecto Sans Inc.

Guía rápida de desarrollo para el equipo de **Sans Inc.**

Este documento resume cómo trabajar el proyecto, cómo ordenar el código, cuándo hacer commits y cuándo abrir Pull Requests.

---

## 1. Objetivo del proyecto

**Sans Inc.** es una plataforma web de reseñas de productos desarrollada con **Laravel**.

El sistema permitirá que usuarios registrados publiquen reseñas sobre productos de la empresa, comenten publicaciones y exploren reseñas filtradas por categorías.

El proyecto se desarrolla como una base funcional inicial para Sans Inc., en el contexto del **Proyecto Integrador de Software**.

### Idioma del proyecto

El idioma principal del sistema será **inglés**. Por lo tanto:

- Los nombres de clases, variables, métodos, tablas y archivos de código deben estar en **inglés**.
- Los commits pueden escribirse en **español**.
- La interfaz final del producto debe mantenerse preferentemente en **inglés**, salvo que el equipo acuerde otra cosa.

---

## 2. Alcance de esta etapa

### Funcionalidades principales

En esta etapa se desarrollarán principalmente:

- Registro, inicio y cierre de sesión de usuarios.
- Confirmación de correo y recuperación de contraseña, si el equipo lo alcanza.
- Gestión de usuarios.
- Gestión de productos.
- Gestión de categorías.
- Gestión de publicaciones o reseñas.
- Gestión de comentarios.
- Filtro de publicaciones por categoría de producto.
- Rol de cliente para agendamiento de horas.
- Vistas principales con Blade, HTML, CSS, JavaScript y Bootstrap.

### Fuera del alcance principal

Por ahora quedan fuera del alcance principal:

- Carga de imágenes, videos o archivos multimedia.
- Administración avanzada.
- Soporte multi-idioma completo.
- Funcionalidades completas del rol administrador.

> El rol de administrador puede existir en la base del sistema, pero en esta primera versión no tendrá funciones reales completas asociadas.

---

## 3. Tecnologías utilizadas

Stack actual del proyecto:

- **Backend:** PHP 8.1+, Laravel 10.
- **Frontend:** Blade, HTML5, CSS3, JavaScript, Bootstrap.
- **Base de datos:** MySQL.
- **Autenticación/API:** Laravel Sanctum, si corresponde al módulo.
- **Build frontend:** Vite.
- **Gestor PHP:** Composer.
- **Gestor frontend:** npm.
- **Testing:** PHPUnit.
- **Formato de código:** Laravel Pint, si el equipo decide usarlo.
- **Control de versiones:** Git y GitHub.

---

## 4. Estructura recomendada del proyecto

El proyecto usa una estructura Laravel tradicional. Backend y frontend viven en el mismo repositorio.

```txt
sans-inc-pagina-web/
|-- app/
|   |-- DTOs/
|   |-- Http/
|   |   |-- Controllers/
|   |   |-- Middleware/
|   |   `-- Requests/
|   |-- Models/
|   |-- Repositories/
|   |   |-- Interfaces/
|   |   `-- Eloquent/
|   `-- Services/
|-- bootstrap/
|-- config/
|-- database/
|   |-- factories/
|   |-- migrations/
|   `-- seeders/
|-- public/
|-- resources/
|   |-- css/
|   |-- js/
|   `-- views/
|-- routes/
|-- storage/
|-- tests/
|-- composer.json
|-- package.json
`-- vite.config.js
```

### Uso recomendado de carpetas

- `app/Models`: modelos Eloquent que representan entidades de la base de datos.
- `app/DTOs`: objetos para transportar datos entre capas.
- `app/Http/Controllers`: reciben peticiones HTTP y devuelven respuestas.
- `app/Http/Requests`: validaciones de formularios o requests.
- `app/Services`: lógica de negocio.
- `app/Repositories`: acceso a datos.
- `app/Repositories/Interfaces`: contratos de repositorios.
- `app/Repositories/Eloquent`: implementación concreta usando Eloquent.
- `database/migrations`: estructura de tablas.
- `database/seeders`: datos iniciales o de prueba.
- `resources/views`: vistas Blade.
- `resources/css`: estilos.
- `resources/js`: JavaScript.
- `public`: archivos públicos, imágenes, favicon y assets compilados.
- `routes/web.php`: rutas web principales.
- `routes/api.php`: rutas API, si se usan.

---

## 5. Flujo de arquitectura del backend

### Flujo recomendado

```txt
Request HTTP
-> Controller
-> Service
-> Repository
-> Model / Eloquent
-> Base de datos
-> Response / View / DTO
```

### Responsabilidad de cada capa

- **Model:** representa una entidad del dominio y de la base de datos. Ejemplos: `User`, `Product`, `Review`, `Comment`.
- **DTO:** define datos que entran o salen del sistema sin exponer estructuras internas.
- **Controller:** recibe la petición, llama al servicio y devuelve una respuesta.
- **Service:** contiene la lógica de negocio.
- **Repository:** consulta, crea, actualiza o elimina datos.
- **Interface:** define contratos para desacoplar capas.
- **Migration:** define la estructura de la base de datos.
- **Request:** valida los datos antes de que lleguen al controller.

> Evitar poner lógica de negocio compleja directamente en los controllers.

---

## 6. Cómo crear una nueva funcionalidad

Ejemplo usando el módulo `Product`.

### Orden recomendado

1. Revisar si ya existe el modelo.
2. Crear o completar el modelo `Product`.
3. Crear la migración si falta la tabla.
4. Crear los DTOs necesarios:
   - `ProductCreateDto`
   - `ProductUpdateDto`
   - `ProductResponseDto`
5. Crear la interfaz del repository: `IProductRepository`.
6. Crear la implementación del repository: `ProductRepository`.
7. Crear la interfaz del service: `IProductService`.
8. Crear la implementación del service: `ProductService`.
9. Crear el controller: `ProductController` o `ProductsController`.
10. Registrar dependencias en un service provider, si corresponde.
11. Crear o actualizar rutas en `routes/web.php` o `routes/api.php`.
12. Crear vistas Blade si la funcionalidad tiene interfaz.
13. Probar la funcionalidad en navegador, Postman, archivo `.http` o tests.
14. Revisar `git status`.
15. Hacer commits claros.
16. Subir la rama.
17. Crear Pull Request hacia `develop`.

**No conviene abrir un Pull Request si solo existe un archivo vacío.** Primero intenta dejar una unidad funcional revisable.

---

## 7. Convenciones de nombres

Aunque los commits estén en español, el código debe estar en **inglés**.

### Ejemplos recomendados

- **Model:** `Product`, `User`, `Review`, `Comment`, `Category`.
- **DTO:** `ProductCreateDto`, `ProductUpdateDto`, `ProductResponseDto`.
- **Repository Interface:** `IProductRepository`.
- **Repository:** `ProductRepository`.
- **Service Interface:** `IProductService`.
- **Service:** `ProductService`.
- **Controller:** `ProductController` o `ProductsController`.
- **Request:** `StoreProductRequest`, `UpdateProductRequest`.
- **Migration:** `create_products_table`.

### Variables y métodos

```php
$productName
$userEmail
$reviewContent
```

```php
createProduct()
updateReview()
deleteComment()
getProductsByCategory()
```

### Evitar nombres mezclados

```php
productoName
crearProduct
usuarioController
```

---

## 8. Flujo de trabajo con Git y ramas

El proyecto usa **Git Flow adaptado**.

### Ramas principales

- `main`: rama estable/final. **No se trabaja directamente aquí**.
- `develop`: rama de integración. Recibe Pull Requests desde ramas `feat/`.

### Ramas de funcionalidad

Ejemplos:

- `feat/gestion-archivos`
- `feat/interfaz`
- `feat/productos`
- `feat/usuarios`
- `feat/publicaciones`, si el equipo la usa para reseñas/publicaciones.

### Regla principal

- No hacer commits directos en `main`.
- No trabajar directo en `develop`, salvo acuerdo del equipo.
- Todo cambio debe ir en una rama `feat/` y luego en Pull Request hacia `develop`.

### Flujo básico

```bash
git checkout develop
git pull origin develop
git checkout -b feat/nombre-funcionalidad
```

Después de programar:

```bash
git status
git add .
git commit -m "feat(productos): agregar modelo de productos"
git push origin feat/nombre-funcionalidad
```

El Pull Request normalmente debe ir desde:

```txt
feat/nombre-funcionalidad -> develop
```

`develop` solo pasa a `main` cuando la versión esté integrada, revisada y probada.

---

## 9. Conventional Commits

### Formato recomendado

```txt
tipo(alcance opcional): descripción corta
```

### Ejemplos

```txt
feat(productos): agregar modelo de productos
fix(auth): corregir validación de email
docs: actualizar guía de instalación
style(blade): ajustar estilos del formulario
refactor(repo): simplificar consulta de productos
test(usuarios): agregar pruebas de registro
chore(deps): actualizar dependencias frontend
```

### Tipos comunes

- `feat`: nueva funcionalidad.
- `fix`: corrección de error.
- `docs`: documentación.
- `style`: formato, estilos o cambios visuales sin lógica.
- `refactor`: mejora interna sin cambiar comportamiento.
- `test`: pruebas.
- `chore`: configuración, dependencias o mantenimiento.
- `build`: cambios relacionados al sistema de build.
- `ci`: cambios de integración continua.

### Reglas simples

- Escribir en minúsculas.
- Usar una descripción corta.
- Preferir verbos en infinitivo: `agregar`, `crear`, `corregir`, `eliminar`.
- No terminar con punto final.
- El alcance es opcional, pero ayuda.

---

## 10. Cuándo hacer commits

Hacer commits cuando completes una parte pequeña y coherente.

### Buenos ejemplos

```txt
feat(productos): crear modelo product
feat(productos): agregar migración de productos
feat(productos): implementar repositorio de productos
feat(publicaciones): crear vista de listado de reseñas
fix(comentarios): corregir eliminación de comentarios propios
docs: actualizar guía de trabajo con ramas
```

### Malos ejemplos

```txt
cambios
avance
cosas
arreglo
commit final
todo listo
```

Un commit debe representar **una idea clara**. No mezclar muchas cosas distintas en el mismo commit.

---

## 11. Cuándo hacer Pull Request

No hacer Pull Request por cada archivo mínimo.

Sí hacer Pull Request cuando exista una unidad revisable, por ejemplo:

- Modelo + migración + repository básico.
- Service + controller + rutas funcionando.
- Vista completa de un módulo.
- Corrección de bug probada.
- Funcionalidad que compila y puede revisarse.

### Ejemplo de buen PR

```txt
feat(productos): agregar CRUD básico de productos
```

Ese PR podría incluir:

- `Product`
- Migración de productos.
- DTOs.
- Repository.
- Service.
- Controller.
- Rutas.
- Vistas básicas.
- Pruebas manuales o automáticas.

Si la tarea es muy grande, dividirla en PRs más pequeños pero coherentes.

---

## 12. Reglas antes de subir cambios

### Checklist antes de hacer push o Pull Request

- [ ] Estoy en mi rama `feat/`, no en `main` ni `develop`.
- [ ] Hice pull desde `develop` antes de trabajar o antes del PR.
- [ ] El proyecto compila o al menos no rompe el flujo principal.
- [ ] Probé la funcionalidad principal.
- [ ] Revisé `git status`.
- [ ] No subí `.env` ni contraseñas.
- [ ] No subí `vendor/` ni `node_modules/`.
- [ ] No mezclé cambios de otros módulos sin coordinar.
- [ ] Mis commits tienen nombres claros.
- [ ] El Pull Request apunta a `develop`.
- [ ] La descripción del PR explica qué hice.

### Comandos útiles

```bash
git status
git log --oneline
php artisan test
npm run build
```

Si `php artisan test` o `npm run build` fallan, revisar antes de abrir el PR o avisar en la descripción.

---

## 13. Archivos que no deben subirse

### No subir

- `.env`
- `vendor/`
- `node_modules/`
- `public/build/`
- `storage/*.key`
- `.idea/`
- `.vscode/`

### Notas

- `.env` contiene configuración local y puede tener credenciales.
- `vendor/` se genera con `composer install`.
- `node_modules/` se genera con `npm install`.
- `public/build/` se genera con Vite.
- `.idea/` y `.vscode/` solo deberían subirse si el equipo lo acuerda.

### Archivos que sí pueden subirse cuando cambian

- `composer.json`
- `composer.lock`
- `package.json`
- `package-lock.json`

---

## 14. Reglas de trabajo en equipo

Reglas simples para evitar conflictos:

- Avisar antes de tocar archivos compartidos.
- No modificar código de otra rama sin coordinar.
- Hacer pull frecuentemente desde `develop`.
- Mantener nombres de clases, métodos y variables en **inglés**.
- Mantener commits claros aunque estén en español.
- No cambiar arquitectura sin consultarlo.
- No borrar código de otros al resolver conflictos sin preguntar.
- Documentar cambios importantes.
- Revisar el PR de compañeros con respeto y claridad.

---

## 15. Errores comunes y cómo evitarlos

### Errores típicos

- Trabajar en la rama equivocada.
- Hacer commit directo en `main`.
- Hacer cambios directamente en `develop`.
- Subir `.env`.
- Subir `vendor/` o `node_modules/`.
- Poner lógica de negocio dentro del controller.
- Crear variables en español mezcladas con inglés.
- Mezclar frontend, backend y configuración sin relación en un solo commit.
- No probar antes del Pull Request.
- No actualizar la rama con `develop`.
- Duplicar código que ya existe.

### Cómo evitarlos

```bash
git status
git checkout develop
git pull origin develop
git checkout feat/mi-rama
git merge develop
```

Antes de programar, revisar qué archivos existen y seguir el patrón del proyecto.

---

## 16. Resumen rápido para programar

### Flujo mínimo

1. Me cambio a `develop`.
2. Hago pull desde `develop`.
3. Creo o entro a mi rama `feat/`.
4. Programo mi parte.
5. Mantengo nombres de código en inglés.
6. Pruebo lo que hice.
7. Reviso `git status`.
8. Hago commits claros con Conventional Commits.
9. Hago push de mi rama.
10. Creo Pull Request hacia `develop`.
11. Espero revisión.
12. Corrijo si hace falta.
13. Después del merge, actualizo mi `develop` local.

### Comandos rápidos

```bash
git checkout develop
git pull origin develop
git checkout -b feat/nombre-funcionalidad

git status
git add .
git commit -m "feat(modulo): agregar funcionalidad"
git push origin feat/nombre-funcionalidad
```

Después del merge:

```bash
git checkout develop
git pull origin develop
```

---

## 17. Nota final

Antes de abrir un Pull Request, intenta que tu módulo tenga sentido como conjunto.

Por ejemplo, para `Product`, no conviene subir solo un archivo vacío. Es mejor avanzar hasta tener al menos:

- Model.
- Migration.
- DTOs, si aplica.
- Repository.
- Service.
- Controller.
- Routes.
- Vista o endpoint probado.

La idea no es hacer todo perfecto desde el primer intento, sino subir cambios **claros**, **revisables** y que no rompan el trabajo del equipo.
