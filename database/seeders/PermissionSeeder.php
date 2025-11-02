<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            // Menú
            ['name' => 'menu.dashboard', 'description' => 'Ver Dashboard Principal'],
            
            // Admin
            ['name' => 'admin.enter', 'description' => 'Acceder al menú de administración'],
            
            // Usuarios
            ['name' => 'usuarios.vista', 'description' => 'Ver lista de usuarios'],
            ['name' => 'usuarios.crear', 'description' => 'Crear usuarios'],
            ['name' => 'usuarios.editar', 'description' => 'Editar usuarios'],
            ['name' => 'usuarios.eliminar', 'description' => 'Eliminar usuarios'],
            ['name' => 'usuarios.asignarRol', 'description' => 'Asignar roles a usuarios'],
            ['name' => 'usuarios.asignarPermisos', 'description' => 'Asignar permisos directos a usuarios'],
            
            // Roles
            ['name' => 'roles.vista', 'description' => 'Ver lista de roles'],
            ['name' => 'roles.crear', 'description' => 'Crear roles'],
            ['name' => 'roles.editar', 'description' => 'Editar roles'],
            ['name' => 'roles.eliminar', 'description' => 'Eliminar roles'],

            //Permisos
            ['name' => 'permisos.vista', 'description' => 'Ver lista de permisos'],
            ['name' => 'permisos.crear', 'description' => 'Crear permisos'],
            ['name' => 'permisos.editar', 'description' => 'Editar permisos'],
            ['name' => 'permisos.eliminar', 'description' => 'Eliminar permisos'],
            
            // Servicios
            ['name' => 'servicios.vista', 'description' => 'Ver menú de servicios'],
            ['name' => 'servicios.crear', 'description' => 'Crear servicio'],
            ['name' => 'servicios.editar', 'description' => 'Editar servicio'],
            ['name' => 'servicios.eliminar', 'description' => 'Eliminar servicio'],

            // Reportes
            ['name' => 'reportes.vista', 'description' => 'Ver reportes'],
            ['name' => 'reportes.general', 'description' => 'Ver reportes generales'],
            ['name' => 'reportes.exportar', 'description' => 'Exportar reportes'],

            //Servicios
            ['name' => 'servicios.registrar', 'description' => 'Registrar servicio'],
            ['name' => 'servicios.eliminar', 'description' => 'Eliminar servicio Registrado'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'guard_name' => 'api',
                    'description' => $permission['description'],
                ]
            );
        }
    }
}
