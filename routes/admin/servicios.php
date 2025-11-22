<?php


use App\Http\Modules\Admin\Servicios\Controller\ServiciosController;
use Illuminate\Support\Facades\Route;

Route::prefix('servicios')->group(function () {
    Route::post('crear-servicio', [ServiciosController::class, 'crearServicio']);
    Route::get('obtener-servicio', [ServiciosController::class, 'obtenerServicios']);
    Route::put('modificar-servicio/{id}', [ServiciosController::class, 'modificarServicio']); 
});

