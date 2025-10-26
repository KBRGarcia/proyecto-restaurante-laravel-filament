-- =====================================================
-- SCRIPT SQL PARA SISTEMA DE ROLES Y PERMISOS
-- Proyecto Restaurante Laravel FilamentPHP
-- Generado automáticamente con Spatie Laravel Permission
-- =====================================================

-- Crear tabla de permisos
CREATE TABLE permissions (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP(0) NULL,
    updated_at TIMESTAMP(0) NULL,
    CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name)
);

-- Crear tabla de roles
CREATE TABLE roles (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP(0) NULL,
    updated_at TIMESTAMP(0) NULL,
    CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name)
);

-- Crear tabla de relación modelo-permisos
CREATE TABLE model_has_permissions (
    permission_id BIGINT NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT NOT NULL,
    CONSTRAINT model_has_permissions_permission_model_type_primary PRIMARY KEY (permission_id, model_id, model_type),
    CONSTRAINT model_has_permissions_model_id_model_type_index UNIQUE (model_id, model_type)
);

-- Crear tabla de relación modelo-roles
CREATE TABLE model_has_roles (
    role_id BIGINT NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT NOT NULL,
    CONSTRAINT model_has_roles_role_model_type_primary PRIMARY KEY (role_id, model_id, model_type),
    CONSTRAINT model_has_roles_model_id_model_type_index UNIQUE (model_id, model_type)
);

-- Crear tabla de relación rol-permisos
CREATE TABLE role_has_permissions (
    permission_id BIGINT NOT NULL,
    role_id BIGINT NOT NULL,
    CONSTRAINT role_has_permissions_permission_id_role_id_primary PRIMARY KEY (permission_id, role_id)
);

-- Crear índices para optimizar consultas
CREATE INDEX model_has_permissions_model_id_model_type_index ON model_has_permissions (model_id, model_type);
CREATE INDEX model_has_roles_model_id_model_type_index ON model_has_roles (model_id, model_type);

-- Agregar claves foráneas
ALTER TABLE model_has_permissions ADD CONSTRAINT model_has_permissions_permission_id_foreign 
    FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE;

ALTER TABLE model_has_roles ADD CONSTRAINT model_has_roles_role_id_foreign 
    FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE;

ALTER TABLE role_has_permissions ADD CONSTRAINT role_has_permissions_permission_id_foreign 
    FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE;

ALTER TABLE role_has_permissions ADD CONSTRAINT role_has_permissions_role_id_foreign 
    FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE;

-- =====================================================
-- INSERTAR PERMISOS DEL SISTEMA
-- =====================================================

INSERT INTO permissions (name, guard_name, created_at, updated_at) VALUES
-- Gestión de usuarios
('ver-usuarios', 'web', NOW(), NOW()),
('crear-usuarios', 'web', NOW(), NOW()),
('editar-usuarios', 'web', NOW(), NOW()),
('eliminar-usuarios', 'web', NOW(), NOW()),

-- Gestión de productos
('ver-productos', 'web', NOW(), NOW()),
('crear-productos', 'web', NOW(), NOW()),
('editar-productos', 'web', NOW(), NOW()),
('eliminar-productos', 'web', NOW(), NOW()),

-- Gestión de categorías
('ver-categorias', 'web', NOW(), NOW()),
('crear-categorias', 'web', NOW(), NOW()),
('editar-categorias', 'web', NOW(), NOW()),
('eliminar-categorias', 'web', NOW(), NOW()),

-- Gestión de órdenes
('ver-ordenes', 'web', NOW(), NOW()),
('crear-ordenes', 'web', NOW(), NOW()),
('editar-ordenes', 'web', NOW(), NOW()),
('eliminar-ordenes', 'web', NOW(), NOW()),
('procesar-ordenes', 'web', NOW(), NOW()),

-- Gestión de sucursales
('ver-sucursales', 'web', NOW(), NOW()),
('crear-sucursales', 'web', NOW(), NOW()),
('editar-sucursales', 'web', NOW(), NOW()),
('eliminar-sucursales', 'web', NOW(), NOW()),

-- Gestión de métodos de pago
('ver-metodos-pago', 'web', NOW(), NOW()),
('crear-metodos-pago', 'web', NOW(), NOW()),
('editar-metodos-pago', 'web', NOW(), NOW()),
('eliminar-metodos-pago', 'web', NOW(), NOW()),

-- Gestión de evaluaciones
('ver-evaluaciones', 'web', NOW(), NOW()),
('crear-evaluaciones', 'web', NOW(), NOW()),
('editar-evaluaciones', 'web', NOW(), NOW()),
('eliminar-evaluaciones', 'web', NOW(), NOW()),

-- Reportes y estadísticas
('ver-reportes', 'web', NOW(), NOW()),
('exportar-reportes', 'web', NOW(), NOW()),

-- Configuración del sistema
('ver-configuracion', 'web', NOW(), NOW()),
('editar-configuracion', 'web', NOW(), NOW()),

-- Gestión de roles y permisos
('ver-roles', 'web', NOW(), NOW()),
('crear-roles', 'web', NOW(), NOW()),
('editar-roles', 'web', NOW(), NOW()),
('eliminar-roles', 'web', NOW(), NOW()),
('asignar-roles', 'web', NOW(), NOW());

-- =====================================================
-- INSERTAR ROLES DEL SISTEMA
-- =====================================================

INSERT INTO roles (name, guard_name, created_at, updated_at) VALUES
('super-admin', 'web', NOW(), NOW()),
('admin', 'web', NOW(), NOW()),
('gerente', 'web', NOW(), NOW()),
('empleado', 'web', NOW(), NOW()),
('cliente', 'web', NOW(), NOW());

-- =====================================================
-- ASIGNAR PERMISOS A ROLES
-- =====================================================

-- Super Admin: Todos los permisos
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id
FROM permissions p, roles r
WHERE r.name = 'super-admin';

-- Admin: Permisos administrativos (sin gestión de roles)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id
FROM permissions p, roles r
WHERE r.name = 'admin' 
AND p.name IN (
    'ver-usuarios', 'crear-usuarios', 'editar-usuarios',
    'ver-productos', 'crear-productos', 'editar-productos', 'eliminar-productos',
    'ver-categorias', 'crear-categorias', 'editar-categorias', 'eliminar-categorias',
    'ver-ordenes', 'crear-ordenes', 'editar-ordenes', 'procesar-ordenes',
    'ver-sucursales', 'crear-sucursales', 'editar-sucursales',
    'ver-metodos-pago', 'crear-metodos-pago', 'editar-metodos-pago',
    'ver-evaluaciones', 'crear-evaluaciones', 'editar-evaluaciones',
    'ver-reportes', 'exportar-reportes',
    'ver-configuracion', 'editar-configuracion'
);

-- Gerente: Permisos de gestión operativa
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id
FROM permissions p, roles r
WHERE r.name = 'gerente' 
AND p.name IN (
    'ver-usuarios', 'crear-usuarios', 'editar-usuarios',
    'ver-productos', 'crear-productos', 'editar-productos',
    'ver-categorias', 'crear-categorias', 'editar-categorias',
    'ver-ordenes', 'crear-ordenes', 'editar-ordenes', 'procesar-ordenes',
    'ver-sucursales', 'editar-sucursales',
    'ver-metodos-pago', 'editar-metodos-pago',
    'ver-evaluaciones', 'crear-evaluaciones', 'editar-evaluaciones',
    'ver-reportes', 'exportar-reportes'
);

-- Empleado: Permisos operativos básicos
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id
FROM permissions p, roles r
WHERE r.name = 'empleado' 
AND p.name IN (
    'ver-productos',
    'ver-categorias',
    'ver-ordenes', 'crear-ordenes', 'editar-ordenes', 'procesar-ordenes',
    'ver-evaluaciones', 'crear-evaluaciones'
);

-- Cliente: Permisos mínimos
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id
FROM permissions p, roles r
WHERE r.name = 'cliente' 
AND p.name IN (
    'ver-productos',
    'ver-categorias',
    'crear-ordenes',
    'crear-evaluaciones'
);

-- =====================================================
-- ASIGNAR ROLES A USUARIOS EXISTENTES
-- =====================================================

-- Asignar rol admin a usuarios con rol 'admin'
INSERT INTO model_has_roles (role_id, model_type, model_id)
SELECT r.id, 'App\\Models\\Usuario', u.id
FROM roles r, usuarios u
WHERE r.name = 'admin' AND u.rol = 'admin';

-- Asignar rol empleado a usuarios con rol 'empleado'
INSERT INTO model_has_roles (role_id, model_type, model_id)
SELECT r.id, 'App\\Models\\Usuario', u.id
FROM roles r, usuarios u
WHERE r.name = 'empleado' AND u.rol = 'empleado';

-- Asignar rol cliente a usuarios con rol 'cliente'
INSERT INTO model_has_roles (role_id, model_type, model_id)
SELECT r.id, 'App\\Models\\Usuario', u.id
FROM roles r, usuarios u
WHERE r.name = 'cliente' AND u.rol = 'cliente';

-- =====================================================
-- COMENTARIOS Y DOCUMENTACIÓN
-- =====================================================

COMMENT ON TABLE permissions IS 'Tabla que almacena los permisos del sistema';
COMMENT ON TABLE roles IS 'Tabla que almacena los roles del sistema';
COMMENT ON TABLE model_has_permissions IS 'Tabla de relación muchos a muchos entre modelos y permisos';
COMMENT ON TABLE model_has_roles IS 'Tabla de relación muchos a muchos entre modelos y roles';
COMMENT ON TABLE role_has_permissions IS 'Tabla de relación muchos a muchos entre roles y permisos';

COMMENT ON COLUMN permissions.name IS 'Nombre único del permiso';
COMMENT ON COLUMN permissions.guard_name IS 'Nombre del guard de autenticación';
COMMENT ON COLUMN roles.name IS 'Nombre único del rol';
COMMENT ON COLUMN roles.guard_name IS 'Nombre del guard de autenticación';

-- =====================================================
-- VERIFICACIÓN DE DATOS INSERTADOS
-- =====================================================

-- Verificar que se insertaron todos los permisos
SELECT 'Permisos insertados: ' || COUNT(*) FROM permissions;

-- Verificar que se insertaron todos los roles
SELECT 'Roles insertados: ' || COUNT(*) FROM roles;

-- Verificar asignaciones de permisos a roles
SELECT r.name as rol, COUNT(rhp.permission_id) as permisos_asignados
FROM roles r
LEFT JOIN role_has_permissions rhp ON r.id = rhp.role_id
GROUP BY r.id, r.name
ORDER BY r.name;

-- Verificar asignaciones de roles a usuarios
SELECT u.nombre || ' ' || u.apellido as usuario, u.rol as rol_legacy, r.name as rol_nuevo
FROM usuarios u
LEFT JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\Models\\Usuario'
LEFT JOIN roles r ON mhr.role_id = r.id
ORDER BY u.nombre;

-- =====================================================
-- FIN DEL SCRIPT
-- =====================================================
