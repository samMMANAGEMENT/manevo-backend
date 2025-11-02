<?php

namespace App\Http\Modules\Auth\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Auth\Service\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(Request $request)
    {
        try {
            $auth = $this->authService->login($request->all());
            return response()->json($auth, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

        public function me(Request $request)
    {
        $user = $request->user();

        $user->load(['operador']);

        $permissions = $user->getAllPermissions()->pluck('name');
        $roles = $user->roles->pluck('name');

        return response()->json([
            'id' => $user->id,
            'email' => $user->email,
            'operador' => $user->operador ? [
                'nombre_completo' => $user->operador->nombre_completo,
                'tipo_documento_documento' => $user->operador->tipo_documento_documento,
                'cargo' => $user->operador->cargo,
            ] : null,
            'permissions' => $permissions,
            'roles' => $roles,  
            'password_changed_at' => $user->password_changed_at,
        ], 200);
    }
}
