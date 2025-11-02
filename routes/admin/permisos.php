<?php


use App\Http\Modules\Admin\Permisos\Controller\PermisosController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('crear-permiso', [PermisosController::class, 'crearPermiso']);
    Route::get('obtener-permisos', [PermisosController::class, 'obtenerPermisos']);
});

