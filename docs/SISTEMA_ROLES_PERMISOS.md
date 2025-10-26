# Sistema de Roles y Permisos - Proyecto Restaurante Laravel FilamentPHP

## Descripción General

Este proyecto implementa un sistema completo de roles y permisos utilizando el paquete oficial **Spatie Laravel Permission**, que es la solución estándar recomendada por Laravel y FilamentPHP para la gestión de autorización.

## Arquitectura del Sistema

### Tablas de Base de Datos

1. **`permissions`** - Almacena todos los permisos del sistema
2. **`roles`** - Almacena todos los roles del sistema
3. **`model_has_permissions`** - Relación muchos a muchos entre modelos y permisos
4. **`model_has_roles`** - Relación muchos a muchos entre modelos y roles
5. **`role_has_permissions`** - Relación muchos a muchos entre roles y permisos

### Modelos

- **`Usuario`** - Modelo principal de usuario que implementa el trait `HasRoles`
- **`Role`** - Modelo de roles (proporcionado por Spatie)
- **`Permission`** - Modelo de permisos (proporcionado por Spatie)

## Roles del Sistema

### 1. Super Admin
- **Descripción**: Acceso completo al sistema
- **Permisos**: Todos los permisos disponibles
- **Uso**: Administrador principal del sistema

### 2. Admin
- **Descripción**: Administrador con permisos completos excepto gestión de roles
- **Permisos**: 
  - Gestión completa de usuarios, productos, categorías
  - Gestión de órdenes y sucursales
  - Acceso a reportes y configuración
- **Uso**: Administrador de restaurante

### 3. Gerente
- **Descripción**: Gerente con permisos operativos y de gestión
- **Permisos**:
  - Gestión de usuarios (sin eliminar)
  - Gestión de productos y categorías
  - Gestión de órdenes y sucursales
  - Acceso a reportes
- **Uso**: Gerente de sucursal o área

### 4. Empleado
- **Descripción**: Empleado con permisos operativos básicos
- **Permisos**:
  - Visualización de productos y categorías
  - Gestión de órdenes
  - Creación de evaluaciones
- **Uso**: Personal operativo del restaurante

### 5. Cliente
- **Descripción**: Cliente con permisos mínimos
- **Permisos**:
  - Visualización de productos y categorías
  - Creación de órdenes
  - Creación de evaluaciones
- **Uso**: Clientes del restaurante

## Permisos Disponibles

### Gestión de Usuarios
- `ver-usuarios` - Visualizar usuarios
- `crear-usuarios` - Crear usuarios
- `editar-usuarios` - Editar usuarios
- `eliminar-usuarios` - Eliminar usuarios

### Gestión de Productos
- `ver-productos` - Visualizar productos
- `crear-productos` - Crear productos
- `editar-productos` - Editar productos
- `eliminar-productos` - Eliminar productos

### Gestión de Categorías
- `ver-categorias` - Visualizar categorías
- `crear-categorias` - Crear categorías
- `editar-categorias` - Editar categorías
- `eliminar-categorias` - Eliminar categorías

### Gestión de Órdenes
- `ver-ordenes` - Visualizar órdenes
- `crear-ordenes` - Crear órdenes
- `editar-ordenes` - Editar órdenes
- `eliminar-ordenes` - Eliminar órdenes
- `procesar-ordenes` - Procesar órdenes

### Gestión de Sucursales
- `ver-sucursales` - Visualizar sucursales
- `crear-sucursales` - Crear sucursales
- `editar-sucursales` - Editar sucursales
- `eliminar-sucursales` - Eliminar sucursales

### Gestión de Métodos de Pago
- `ver-metodos-pago` - Visualizar métodos de pago
- `crear-metodos-pago` - Crear métodos de pago
- `editar-metodos-pago` - Editar métodos de pago
- `eliminar-metodos-pago` - Eliminar métodos de pago

### Gestión de Evaluaciones
- `ver-evaluaciones` - Visualizar evaluaciones
- `crear-evaluaciones` - Crear evaluaciones
- `editar-evaluaciones` - Editar evaluaciones
- `eliminar-evaluaciones` - Eliminar evaluaciones

### Reportes y Estadísticas
- `ver-reportes` - Visualizar reportes
- `exportar-reportes` - Exportar reportes

### Configuración del Sistema
- `ver-configuracion` - Visualizar configuración
- `editar-configuracion` - Editar configuración

### Gestión de Roles y Permisos
- `ver-roles` - Visualizar roles
- `crear-roles` - Crear roles
- `editar-roles` - Editar roles
- `eliminar-roles` - Eliminar roles
- `asignar-roles` - Asignar roles a usuarios

## Uso en el Código

### Verificar Roles

```php
// Verificar si el usuario tiene un rol específico
if ($usuario->hasRole('admin')) {
    // Lógica para administradores
}

// Verificar múltiples roles
if ($usuario->hasAnyRole(['admin', 'gerente'])) {
    // Lógica para admin o gerente
}

// Verificar todos los roles
if ($usuario->hasAllRoles(['admin', 'super-admin'])) {
    // Lógica para usuarios con ambos roles
}
```

### Verificar Permisos

```php
// Verificar si el usuario tiene un permiso específico
if ($usuario->can('crear-productos')) {
    // Lógica para crear productos
}

// Verificar múltiples permisos
if ($usuario->hasAnyPermission(['crear-productos', 'editar-productos'])) {
    // Lógica para crear o editar productos
}

// Verificar todos los permisos
if ($usuario->hasAllPermissions(['crear-productos', 'editar-productos'])) {
    // Lógica para usuarios con ambos permisos
}
```

### Asignar Roles y Permisos

```php
// Asignar un rol
$usuario->assignRole('admin');

// Asignar múltiples roles
$usuario->assignRole(['admin', 'gerente']);

// Asignar un permiso directo
$usuario->givePermissionTo('crear-productos');

// Asignar múltiples permisos
$usuario->givePermissionTo(['crear-productos', 'editar-productos']);

// Remover un rol
$usuario->removeRole('admin');

// Remover un permiso
$usuario->revokePermissionTo('crear-productos');
```

### Uso en Middleware

```php
// En rutas
Route::middleware(['role:admin'])->group(function () {
    // Rutas solo para administradores
});

Route::middleware(['permission:crear-productos'])->group(function () {
    // Rutas solo para usuarios con permiso crear-productos
});
```

### Uso en FilamentPHP

```php
// En recursos de Filament
public static function canViewAny(): bool
{
    return auth()->user()->can('ver-productos');
}

public static function canCreate(): bool
{
    return auth()->user()->can('crear-productos');
}

public static function canEdit(Model $record): bool
{
    return auth()->user()->can('editar-productos');
}

public static function canDelete(Model $record): bool
{
    return auth()->user()->can('eliminar-productos');
}
```

## Instalación y Configuración

### 1. Instalar el Paquete

```bash
composer require spatie/laravel-permission
```

### 2. Publicar Migraciones y Configuración

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

### 3. Ejecutar Migraciones

```bash
php artisan migrate
```

### 4. Ejecutar Seeders

```bash
php artisan db:seed --class=RolePermissionSeeder
```

### 5. Configurar el Modelo de Usuario

```php
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable
{
    use HasRoles;
    
    // ... resto del código
}
```

## Archivos Generados

1. **`database/migrations/2025_10_26_014438_create_permission_tables.php`** - Migración para crear las tablas
2. **`database/seeders/RolePermissionSeeder.php`** - Seeder con roles y permisos
3. **`app/Models/Usuario.php`** - Modelo de usuario con traits de roles
4. **`config/permission.php`** - Configuración del paquete
5. **`database/sql/roles_permissions_postgresql.sql`** - Script SQL para PostgreSQL

## Usuarios de Prueba

El sistema incluye usuarios de prueba con diferentes roles:

- **Super Admin**: `superadmin@restaurante.com` / `password`
- **Admin**: `admin@restaurante.com` / `password`
- **Gerente**: `gerente@restaurante.com` / `password`
- **Empleado**: `empleado@restaurante.com` / `password`
- **Clientes**: `juan@example.com`, `maria@example.com`, etc. / `password`

## Consideraciones de Seguridad

1. **Principio de Menor Privilegio**: Los usuarios solo tienen los permisos mínimos necesarios
2. **Separación de Responsabilidades**: Los roles están claramente definidos
3. **Auditoría**: El sistema permite rastrear qué usuario tiene qué permisos
4. **Flexibilidad**: Fácil agregar nuevos roles y permisos según necesidades

## Extensibilidad

El sistema está diseñado para ser fácilmente extensible:

1. **Nuevos Roles**: Agregar en el seeder y asignar permisos
2. **Nuevos Permisos**: Agregar en el seeder y asignar a roles
3. **Permisos Granulares**: Crear permisos más específicos según necesidades
4. **Roles Personalizados**: Crear roles específicos para diferentes áreas del negocio

## Documentación Oficial

- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Laravel Authorization](https://laravel.com/docs/authorization)
- [FilamentPHP Authorization](https://filamentphp.com/docs/authorization)
