<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 // Crear rol de Desarrollador con todos los permisos
        $desarrollador = Role::updateOrCreate(
            ['name' => 'desarrollador'],
            [
                'guard_name' => 'api',
                'description' => 'Rol con todos los permisos del sistema'
            ]
        );

        // Asignar todos los permisos al desarrollador
        $permisos = Permission::all();
        $desarrollador->syncPermissions($permisos);

        // Crear rol de Admin
        $admin = Role::updateOrCreate(
            ['name' => 'admin'],
            [
                'guard_name' => 'api',
                'description' => 'Administrador del sistema'
            ]
        );

        $admin->givePermissionTo([
            'admin.enter',
            'menu.dashboard',
            'usuarios.vista',
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.eliminar',
            'roles.vista',
            'roles.crear',
            'roles.editar',
            'roles.eliminar',
            'servicios.vista',
            'servicios.crear',
            'servicios.editar',
            'servicios.eliminar',
            'servicios.registrar',
            'servicios.eliminar',
            'reportes.vista',
            'reportes.exportar',
        ]);

        // Crear rol de Usuario
        $usuario = Role::updateOrCreate(
            ['name' => 'usuario'],
            [
                'guard_name' => 'api',
                'description' => 'Usuario estándar del sistema'
            ]
        );

        $usuario->givePermissionTo([
            'menu.dashboard',
            'usuarios.vista',
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.eliminar',
            'servicios.vista',
            'servicios.crear',
            'servicios.editar',
            'servicios.eliminar',
            'servicios.registrar',
            'servicios.eliminar'
        ]);
    }
}
