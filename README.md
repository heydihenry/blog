# Blog - Sistema de Gestión de Artículos

Aplicación web de blog desarrollada con CakePHP 4.x que permite a los usuarios registrarse, iniciar sesión y gestionar artículos.

## Características Implementadas

### 1. Sistema de Autenticación
- **Registro de usuarios**: Los usuarios pueden crear una cuenta con email y contraseña
- **Inicio de sesión**: Autenticación mediante email y contraseña
- **Cierre de sesión**: Los usuarios pueden cerrar su sesión de forma segura
- **Protección de rutas**: Las acciones de crear, editar y eliminar artículos requieren autenticación

### 2. Gestión de Artículos (CRUD)
- **Listar artículos**: Todos los usuarios pueden ver la lista de artículos publicados
- **Ver artículo**: Cualquier usuario puede leer el contenido completo de un artículo
- **Crear artículo**: Solo usuarios autenticados pueden crear nuevos artículos
- **Editar artículo**: Solo usuarios autenticados pueden modificar artículos
- **Eliminar artículo**: Solo usuarios autenticados pueden eliminar artículos
- **Categorización**: Los artículos se organizan por categorías

### 3. Gestión de Usuarios (CRUD)
- **Listar usuarios**: Vista de todos los usuarios registrados
- **Ver usuario**: Detalles de un usuario específico
- **Crear usuario**: Administración de usuarios
- **Editar usuario**: Modificación de datos de usuario
- **Eliminar usuario**: Eliminación de cuentas de usuario

### 4. Interfaz de Usuario
- Diseño responsive con Bootstrap 5
- Navegación dinámica que muestra opciones según el estado de autenticación
- Formularios estilizados y validados
- Mensajes flash para feedback al usuario

## Configuración del Proyecto

### Requisitos Previos
- PHP 7.4 o superior
- MySQL/MariaDB
- Composer
- Servidor web (Apache/Nginx) o XAMPP

### Instalación

1. **Clonar o descargar el proyecto**
```bash
cd c:/xampp/htdocs/blog
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar base de datos**
- Crear base de datos: `cake_blog`
- Editar `config/app_local.php` con las credenciales de tu base de datos

4. **Ejecutar migraciones**
```bash
bin/cake migrations migrate
```

5. **Acceder a la aplicación**
- URL: `http://localhost/blog`

## Estructura de la Base de Datos

### Tabla: users
- `id` (PK)
- `email` (único)
- `password` (hasheado)
- `role` (author/admin)
- `created`
- `modified`

### Tabla: articles
- `id` (PK)
- `title`
- `body`
- `category_id` (FK)
- `created`
- `modified`

### Tabla: categorys
- `id` (PK)
- `name`
- `created`
- `modified`

## Rutas Principales

### Artículos
- `GET /` - Lista de artículos (página principal)
- `GET /articles` - Lista de artículos
- `GET /articles/view/{id}` - Ver artículo específico
- `GET /articles/add` - Formulario crear artículo (requiere login)
- `POST /articles/add` - Guardar nuevo artículo (requiere login)
- `GET /articles/edit/{id}` - Formulario editar artículo (requiere login)
- `POST /articles/edit/{id}` - Actualizar artículo (requiere login)
- `POST /articles/delete/{id}` - Eliminar artículo (requiere login)

### Usuarios
- `GET /users/register` - Formulario de registro
- `POST /users/register` - Crear cuenta
- `GET /users/login` - Formulario de inicio de sesión
- `POST /users/login` - Autenticar usuario
- `GET /users/logout` - Cerrar sesión

## Requisitos Funcionales Pendientes

### 1. Relación Usuario-Artículo
**Objetivo**: Asociar cada artículo con el usuario que lo creó

**Tareas**:
- [ ] Agregar columna `user_id` a la tabla `articles`
- [ ] Actualizar modelo `ArticlesTable` para definir relación `belongsTo` con Users
- [ ] Actualizar modelo `UsersTable` para definir relación `hasMany` con Articles



### 2. Asignación Automática de Usuario al Crear Artículo
**Objetivo**: Guardar automáticamente el ID del usuario autenticado al crear un artículo

**Tareas**:
- [ ] Modificar `ArticlesController::add()` para obtener el usuario autenticado
- [ ] Guardar la información del usuario en sesión al iniciar sesión
- [ ] Asignar `user_id` antes de guardar el artículo (debe guardar el usuario en sesión)


### 3. Vista de Artículos del Usuario
**Objetivo**: Permitir a cada usuario ver solo los artículos que ha creado

**Tareas**:
- [ ] Crear acción `ArticlesController::myArticles()`
- [ ] Filtrar artículos por `user_id` del usuario autenticado
- [ ] Crear vista `templates/Articles/my_articles.php`
- [ ] Agregar enlace en el navbar para "Mis Artículos"



### 4. Unificación de Estilos en Vistas
**Objetivo**: Aplicar el mismo diseño Bootstrap 5 a todas las vistas

**Vistas pendientes de estilizar**:
- [ ] `templates/Articles/view.php`
- [ ] `templates/Users/index.php`
- [ ] `templates/Users/view.php`
- [ ] `templates/Users/add.php`
- [ ] `templates/Users/edit.php`
- [ ] `templates/Categorys/*` (todas las vistas)

**Elementos de diseño a aplicar**:
- Uso de cards con `shadow-sm`
- Botones con iconos de Bootstrap Icons
- Formularios con clases `form-control` y `form-select`
- Layout responsive con grid de Bootstrap
- Consistencia en colores y espaciados

## Tecnologías Utilizadas

- **Framework**: CakePHP 4.x
- **Frontend**: Bootstrap 5.1.3
- **Iconos**: Bootstrap Icons 1.8.1
- **Base de datos**: MySQL
- **Autenticación**: CakePHP Authentication Plugin

## Notas de Desarrollo

### Configuración de Autenticación
La autenticación está configurada en:
- `src/Application.php` - Middleware y servicio de autenticación
- `src/Controller/AppController.php` - Acciones públicas por defecto (index, view)
- Rutas de login: `/blog/users/login`
- Redirección después de login: `/blog/articles/index`

### Protección de Rutas
Las acciones protegidas se configuran mediante:
```php
public function beforeFilter(\Cake\Event\EventInterface $event)
{
    parent::beforeFilter($event);
    $this->Authentication->addUnauthenticatedActions(['index', 'view']);
}
```

## Autor

Proyecto desarrollado como sistema de gestión de blog con CakePHP.
