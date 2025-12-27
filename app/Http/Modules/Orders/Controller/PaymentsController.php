<?php

namespace App\Http\Modules\Orders\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Orders\Service\PaymentsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function __construct(private PaymentsService $paymentsService)
    {
    }

    public function store(Request $request, int $orderId): JsonResponse
    {
        $validated = $request->validate([
            'method' => ['required', 'in:CASH,TRANSFER'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'paid_at' => ['required', 'date'],
        ]);

        $user = auth()->user();
        $entityId = $user->entity_id;

        $order = $this->paymentsService->agregarPago(
            $entityId,
            $orderId,
            $validated['method'],
            (float) $validated['amount'],
            $validated['paid_at']
        );

        return response()->json($order, 201);
    }
}
