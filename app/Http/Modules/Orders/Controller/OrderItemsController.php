<?php

namespace App\Http\Modules\Orders\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Orders\Service\OrderItemsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderItemsController extends Controller
{
    public function __construct(private OrderItemsService $orderItemsService)
    {
    }

    public function store(Request $request, int $orderId): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $user = auth()->user();
        $entityId = $user->entity_id;

        $item = $this->orderItemsService->agregar(
            $entityId,
            $orderId,
            $validated['product_id'],
            $validated['quantity']
        );

        return response()->json($item, 201);
    }

    public function update(Request $request, int $orderId, int $itemId): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $user = auth()->user();
        $entityId = $user->entity_id;

        $item = $this->orderItemsService->actualizar(
            $entityId,
            $orderId,
            $itemId,
            $validated['quantity']
        );

        return response()->json($item, 200);
    }

    public function destroy(int $orderId, int $itemId): JsonResponse
    {
        $user = auth()->user();
        $entityId = $user->entity_id;

        $this->orderItemsService->eliminar($entityId, $orderId, $itemId);

        return response()->json([], 204);
    }
}
