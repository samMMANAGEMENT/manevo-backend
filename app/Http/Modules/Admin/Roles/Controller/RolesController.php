<?php

namespace App\Http\Modules\Admin\Roles\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Roles\Service\RolesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function __construct(private RolesService $rolesService)
    {
    }

    public function index(): JsonResponse
    {
        try {
            $roles = $this->rolesService->obtenerRoles();

            return response()->json($roles, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al obtener roles'], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $rol = $this->rolesService->crearRol($validated);

            return response()->json($rol, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function syncPermissions(Request $request, int $roleId): JsonResponse
    {
        $validated = $request->validate([
            'permisos' => ['array'],
            'permisos.*' => ['integer', 'exists:permissions,id'],
        ]);

        try {
            $rol = $this->rolesService->sincronizarPermisos($roleId, $validated['permisos'] ?? []);

            return response()->json($rol, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function destroy(int $roleId): JsonResponse
    {
        try {
            $this->rolesService->eliminarRol($roleId);

            return response()->json([], 204);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al eliminar rol'], 500);
        }
    }
}
