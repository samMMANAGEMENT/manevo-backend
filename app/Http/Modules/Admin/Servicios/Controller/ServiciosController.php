<?php

namespace App\Http\Modules\Admin\Servicios\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Servicios\Service\ServiciosService;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    public function __construct(private ServiciosService $serviciosService)
    {
    }

    public function crearServicio(Request $request)
    {
        try {
            $user = auth()->user();
            $entidadId = $user->entity_id;
            $servicio = $this->serviciosService->crearServicio($request->all(), $entidadId);
            return response()->json($servicio, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function obtenerServicios()
    {
        try {
            $user = auth()->user();
            $entidadId = $user->entity_id;
            $servicio = $this->serviciosService->obtenerServicios($entidadId);
            return response()->json($servicio, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function modificarServicio(Request $request, int $id)
    {
        try {
            $servicio = $this->serviciosService->modificarServicio($request->all(), $id);
            return response()->json($servicio, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
