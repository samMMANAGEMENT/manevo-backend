<?php

namespace App\Http\Modules\Orders\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Orders\Models\Order;
use App\Http\Modules\Orders\Service\OrdersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrdersController extends Controller
{
    public function __construct(private OrdersService $ordersService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        $entityId = $user->entity_id;

        $status = $request->query('status');

        $orders = $this->ordersService->listar($entityId, $status);

        return response()->json($orders, 200);
    }

    public function store(): JsonResponse
    {
        $user = auth()->user();
        $entityId = $user->entity_id;

        $order = $this->ordersService->crearBorrador($entityId);

        return response()->json($order, 201);
    }

    public function show(int $orderId): JsonResponse
    {
        $user = auth()->user();
        $entityId = $user->entity_id;

        $order = $this->ordersService->detalle($entityId, $orderId);

        return response()->json($order, 200);
    }

    public function cancel(int $orderId): JsonResponse
    {
        $user = auth()->user();
        $entityId = $user->entity_id;

        $order = $this->ordersService->cancelar($entityId, $orderId);

        return response()->json($order, 200);
    }
}
