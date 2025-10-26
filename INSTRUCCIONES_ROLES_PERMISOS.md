# Instrucciones para Ejecutar el Sistema de Roles y Permisos

## Problema Identificado
El script SQL original estaba escrito para PostgreSQL, pero tu sistema usa MySQL/MariaDB. He corregido el script para que sea compatible con MySQL.

## Solución Implementada

### 1. Script SQL Corregido
- ✅ Creado: `database/sql/25-10-2025_roles_permissions_mysql.sql`
- ✅ Compatible con MySQL/MariaDB
- ✅ Usa sintaxis correcta: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- ✅ Engine: `InnoDB`
- ✅ Charset: `utf8mb4_unicode_ci`

### 2. Migraciones Laravel
Las migraciones de Spatie Laravel Permission son compatibles con MySQL por defecto.

## Opciones para Ejecutar

### Opción 1: Usar Migraciones Laravel (Recomendado)
```bash
# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed --class=RolePermissionSeeder

# O ejecutar todos los seeders
php artisan db:seed
```

### Opción 2: Usar Script SQL Directo
Si prefieres ejecutar el SQL directamente en tu gestor de base de datos:

1. Abre tu gestor de base de datos (phpMyAdmin, MySQL Workbench, etc.)
2. Selecciona tu base de datos del proyecto
3. Ejecuta el archivo: `database/sql/25-10-2025_roles_permissions_mysql.sql`

## Verificación de la Instalación

### Verificar Tablas Creadas
```sql
SHOW TABLES LIKE '%permission%';
SHOW TABLES LIKE '%role%';
```

Deberías ver:
- `permissions`
- `roles`
- `model_has_permissions`
- `model_has_roles`
- `role_has_permissions`

### Verificar Datos Insertados
```sql
-- Verificar permisos
SELECT COUNT(*) as total_permisos FROM permissions;

-- Verificar roles
SELECT COUNT(*) as total_roles FROM roles;

-- Verificar asignaciones de permisos a roles
SELECT r.name as rol, COUNT(rhp.permission_id) as permisos_asignados
FROM roles r
LEFT JOIN role_has_permissions rhp ON r.id = rhp.role_id
GROUP BY r.id, r.name
ORDER BY r.name;
```

## Usuarios de Prueba Creados

Después de ejecutar los seeders, tendrás estos usuarios:

| Email | Password | Rol | Descripción |
|-------|----------|-----|-------------|
| `superadmin@restaurante.com` | `password` | super-admin | Acceso completo |
| `admin@restaurante.com` | `password` | admin | Administrador |
| `gerente@restaurante.com` | `password` | gerente | Gerente |
| `empleado@restaurante.com` | `password` | empleado | Empleado |
| `juan@example.com` | `password` | cliente | Cliente de prueba |

## Uso en el Código

### Verificar Roles
```php
if ($usuario->hasRole('admin')) {
    // Lógica para administradores
}
```

### Verificar Permisos
```php
if ($usuario->can('crear-productos')) {
    // Lógica para crear productos
}
```

### Asignar Roles
```php
$usuario->assignRole('admin');
$usuario->givePermissionTo('crear-productos');
```

## Solución de Problemas

### Error: "Table already exists"
Si las tablas ya existen, puedes:
1. Eliminar las tablas manualmente
2. O usar: `php artisan migrate:rollback`

### Error: "Foreign key constraint fails"
Asegúrate de que la tabla `usuarios` exista antes de ejecutar el script.

### Error: "Duplicate entry"
Los datos ya fueron insertados. Puedes:
1. Usar `INSERT IGNORE` en lugar de `INSERT`
2. O eliminar los datos existentes primero

## Archivos Generados

1. **`database/migrations/2025_10_26_014438_create_permission_tables.php`** - Migración Laravel
2. **`database/seeders/RolePermissionSeeder.php`** - Seeder con roles y permisos
3. **`database/sql/25-10-2025_roles_permissions_mysql.sql`** - Script SQL para MySQL
4. **`app/Models/Usuario.php`** - Modelo con traits de roles
5. **`config/permission.php`** - Configuración del paquete
6. **`docs/SISTEMA_ROLES_PERMISOS.md`** - Documentación completa

## Próximos Pasos

1. Ejecutar las migraciones: `php artisan migrate`
2. Ejecutar los seeders: `php artisan db:seed`
3. Probar el sistema con los usuarios de prueba
4. Implementar verificaciones de roles/permisos en tus controladores y vistas

¡El sistema está listo para usar! 🚀
