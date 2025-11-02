<?php

namespace App\Http\Modules\Auth\Service;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $data)
    {
        $user = User::where('email', $data['email'])
            ->with(['operador'])
            ->first();

        // Validar credenciales
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }

        // dd($user);

        // Validar que el usuario esté activo
        // if (!$user->activo) {
        //     throw new \Exception("El usuario no se encuentra activo.", code: 404);   
        // }

        // Crear nuevo token
        $token = $user->createToken('auth-token')->plainTextToken;

        // Obtener permisos usando Spatie
        $permissions = $user->getAllPermissions()->pluck('name');
        $roles = $user->roles->pluck('name');

        // Preparar respuesta
        return [
            'token_type' => 'Bearer',
            'token' => $token,
            'usuario' => [
                'id' => $user->id,
                'email' => $user->email,
                'operador' => $user->operador ? [
                    'nombre_completo' => $user->operador->nombre_completo,
                    'tipo_documento_documento' => $user->operador->tipo_documento_documento,
                    'cargo' => $user->operador->cargo,
                ] : null,
                'afiliado' => $user->afiliado ? [
                    'nombre_completo' => $user->afiliado->nombre_completo,
                ] : null,
                'permissions' => $permissions,
                'roles' => $roles,
                'password_changed_at' => $user->password_changed_at,
            ],
        ];
    }
}
