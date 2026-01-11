<?php

namespace App\Http\Modules\Admin\Roles\Service;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesService
{
    public function __construct(private PermissionRegistrar $permissionRegistrar)
    {
    }

    public function obtenerRoles(): Collection
    {
        return Role::query()
            ->with('permissions:id,name,description')
            ->get(['id', 'name', 'description', 'guard_name', 'created_at']);
    }

    public function crearRol(array $data): Role
    {
        $rol = Role::create([
            'name' => $data['nombre'],
            'description' => $data['descripcion'] ?? null,
            'guard_name' => 'api',
        ]);

        $this->forgetCachedPermissions();

        return $rol->load('permissions:id,name,description');
    }

    public function sincronizarPermisos(int $roleId, array $permisos): Role
    {
        $rol = Role::query()->findOrFail($roleId);

        $permissions = Permission::query()
            ->whereIn('id', $permisos)
            ->get();

        $rol->syncPermissions($permissions);

        $this->forgetCachedPermissions();

        return $rol->load('permissions:id,name,description');
    }

    public function eliminarRol(int $roleId): void
    {
        $rol = Role::query()->findOrFail($roleId);
        $rol->delete();

        $this->forgetCachedPermissions();
    }

    private function forgetCachedPermissions(): void
    {
        $this->permissionRegistrar->forgetCachedPermissions();
    }
}
