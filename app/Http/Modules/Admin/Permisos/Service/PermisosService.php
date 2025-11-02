<?php

namespace App\Http\Modules\Admin\Permisos\Service;

use Spatie\Permission\Models\Permission;

class PermisosService
{

    public function crearPermiso(array $data)
    {
        return Permission::create([
            'name' => $data['nombre'],
            'guard_name' => $data['guard_name'] ?? 'api',
            'description' => $data['descripcion']
        ]);
    }

    public function obtenerPermisos()
    {
        return Permission::all();
    }
}
