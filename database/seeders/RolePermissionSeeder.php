<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Usuario;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos
        $permissions = [
            // Gestión de usuarios
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
            
            // Gestión de productos
            'ver-productos',
            'crear-productos',
            'editar-productos',
            'eliminar-productos',
            
            // Gestión de categorías
            'ver-categorias',
            'crear-categorias',
            'editar-categorias',
            'eliminar-categorias',
            
            // Gestión de órdenes
            'ver-ordenes',
            'crear-ordenes',
            'editar-ordenes',
            'eliminar-ordenes',
            'procesar-ordenes',
            
            // Gestión de sucursales
            'ver-sucursales',
            'crear-sucursales',
            'editar-sucursales',
            'eliminar-sucursales',
            
            // Gestión de métodos de pago
            'ver-metodos-pago',
            'crear-metodos-pago',
            'editar-metodos-pago',
            'eliminar-metodos-pago',
            
            // Gestión de evaluaciones
            'ver-evaluaciones',
            'crear-evaluaciones',
            'editar-evaluaciones',
            'eliminar-evaluaciones',
            
            // Reportes y estadísticas
            'ver-reportes',
            'exportar-reportes',
            
            // Configuración del sistema
            'ver-configuracion',
            'editar-configuracion',
            
            // Gestión de roles y permisos
            'ver-roles',
            'crear-roles',
            'editar-roles',
            'eliminar-roles',
            'asignar-roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Crear roles
        $roles = [
            'super-admin' => [
                'ver-usuarios', 'crear-usuarios', 'editar-usuarios', 'eliminar-usuarios',
                'ver-productos', 'crear-productos', 'editar-productos', 'eliminar-productos',
                'ver-categorias', 'crear-categorias', 'editar-categorias', 'eliminar-categorias',
                'ver-ordenes', 'crear-ordenes', 'editar-ordenes', 'eliminar-ordenes', 'procesar-ordenes',
                'ver-sucursales', 'crear-sucursales', 'editar-sucursales', 'eliminar-sucursales',
                'ver-metodos-pago', 'crear-metodos-pago', 'editar-metodos-pago', 'eliminar-metodos-pago',
                'ver-evaluaciones', 'crear-evaluaciones', 'editar-evaluaciones', 'eliminar-evaluaciones',
                'ver-reportes', 'exportar-reportes',
                'ver-configuracion', 'editar-configuracion',
                'ver-roles', 'crear-roles', 'editar-roles', 'eliminar-roles', 'asignar-roles',
            ],
            'admin' => [
                'ver-usuarios', 'crear-usuarios', 'editar-usuarios',
                'ver-productos', 'crear-productos', 'editar-productos', 'eliminar-productos',
                'ver-categorias', 'crear-categorias', 'editar-categorias', 'eliminar-categorias',
                'ver-ordenes', 'crear-ordenes', 'editar-ordenes', 'procesar-ordenes',
                'ver-sucursales', 'crear-sucursales', 'editar-sucursales',
                'ver-metodos-pago', 'crear-metodos-pago', 'editar-metodos-pago',
                'ver-evaluaciones', 'crear-evaluaciones', 'editar-evaluaciones',
                'ver-reportes', 'exportar-reportes',
                'ver-configuracion', 'editar-configuracion',
            ],
            'gerente' => [
                'ver-usuarios', 'crear-usuarios', 'editar-usuarios',
                'ver-productos', 'crear-productos', 'editar-productos',
                'ver-categorias', 'crear-categorias', 'editar-categorias',
                'ver-ordenes', 'crear-ordenes', 'editar-ordenes', 'procesar-ordenes',
                'ver-sucursales', 'editar-sucursales',
                'ver-metodos-pago', 'editar-metodos-pago',
                'ver-evaluaciones', 'crear-evaluaciones', 'editar-evaluaciones',
                'ver-reportes', 'exportar-reportes',
            ],
            'empleado' => [
                'ver-productos',
                'ver-categorias',
                'ver-ordenes', 'crear-ordenes', 'editar-ordenes', 'procesar-ordenes',
                'ver-evaluaciones', 'crear-evaluaciones',
            ],
            'cliente' => [
                'ver-productos',
                'ver-categorias',
                'crear-ordenes',
                'crear-evaluaciones',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName, 'guard_name' => 'web']);
            $role->givePermissionTo($rolePermissions);
        }

        // Asignar roles a usuarios existentes (si los hay)
        $this->assignRolesToExistingUsers();
    }

    /**
     * Asignar roles a usuarios existentes basándose en su campo 'rol'
     */
    private function assignRolesToExistingUsers(): void
    {
        $roleMapping = [
            'admin' => 'admin',
            'empleado' => 'empleado',
            'cliente' => 'cliente',
        ];

        foreach ($roleMapping as $oldRole => $newRole) {
            $users = Usuario::where('rol', $oldRole)->get();
            foreach ($users as $user) {
                $user->assignRole($newRole);
            }
        }
    }
}
