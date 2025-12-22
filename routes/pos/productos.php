<?php

use App\Http\Modules\Productos\Controller\ProductosController;
use Illuminate\Support\Facades\Route;

Route::prefix('pos')->group(function () {
    Route::post('crearProducto', [ProductosController::class, 'crearProducto']);
    Route::get('listarProductos', [ProductosController::class, 'listarProductos']);
    Route::put('actualizarProducto/{productoId}', [ProductosController::class, 'actualizarProducto']);
    Route::delete('eliminarProducto/{productoId}', [ProductosController::class, 'eliminarProducto']);
});

