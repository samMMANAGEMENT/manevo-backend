<?php

namespace App\Http\Modules\Admin\Permisos\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Permisos\Service\PermisosService;
use Illuminate\Http\Request;

class PermisosController extends Controller
{

    public function __construct(private PermisosService $permisosService)
    {}


    public function crearPermiso(Request $request)
    {
        try {
            $permiso = $this->permisosService->crearPermiso($request->all());
            return response()->json($permiso, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()],  500);
        }
    }


    public function obtenerPermisos(){
        try {
            $permiso = $this->permisosService->obtenerPermisos();
            return response()->json($permiso, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al obtener permisos'], 500);
        }
    }
}
