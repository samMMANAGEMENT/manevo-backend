<?php

use App\Http\Modules\Auth\Controller\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Ruta de autenticación pública
require __DIR__ . '/auth/auth.php';

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
    });
    
    require __DIR__ . '/admin/permisos.php';
    require __DIR__ . '/admin/servicios.php';
    require __DIR__ . '/admin/roles.php';
    require __DIR__ . '/pos/productos.php';
});