<?php

use App\Http\Modules\Admin\Roles\Controller\RolesController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/roles')->group(function () {
    Route::get('/', [RolesController::class, 'index']);
    Route::post('/', [RolesController::class, 'store']);
    Route::post('{roleId}/permisos', [RolesController::class, 'syncPermissions']);
    Route::delete('{roleId}', [RolesController::class, 'destroy']);
});
