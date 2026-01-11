<?php

use App\Http\Modules\Orders\Controller\OrdersController;
use App\Http\Modules\Orders\Controller\OrderItemsController;
use App\Http\Modules\Orders\Controller\PaymentsController;
use Illuminate\Support\Facades\Route;

Route::prefix('pos/ordenes')->group(function () {
    Route::get('/', [OrdersController::class, 'index']);
    Route::post('/', [OrdersController::class, 'store']);
    Route::get('{orderId}', [OrdersController::class, 'show']);
    Route::post('{orderId}/cancelar', [OrdersController::class, 'cancel']);

    Route::post('{orderId}/items', [OrderItemsController::class, 'store']);
    Route::put('{orderId}/items/{itemId}', [OrderItemsController::class, 'update']);
    Route::delete('{orderId}/items/{itemId}', [OrderItemsController::class, 'destroy']);

    Route::post('{orderId}/pagos', [PaymentsController::class, 'store']);
});
