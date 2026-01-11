<?php

namespace App\Http\Modules\Orders\Service;

use App\Http\Modules\Orders\Models\Payment;
use App\Http\Modules\Orders\Models\Order;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentsService
{
    public function __construct(private OrdersService $ordersService, private DatabaseManager $db)
    {
    }

    public function agregarPago(int $entityId, int $orderId, string $method, float $amount, string $paidAt): Order
    {
        if ($amount <= 0) {
            throw ValidationException::withMessages(['amount' => 'El monto debe ser mayor a 0']);
        }

        if (!in_array($method, ['CASH', 'TRANSFER'])) {
            throw ValidationException::withMessages(['method' => 'Método de pago inválido']);
        }

        return $this->db->transaction(function () use ($entityId, $orderId, $method, $amount, $paidAt) {
            $order = $this->ordersService->detalle($entityId, $orderId);

            if ($order->status === Order::STATUS_CANCELLED) {
                throw ValidationException::withMessages(['status' => 'El pedido está cancelado']);
            }

            if ($order->status === Order::STATUS_PAID) {
                throw ValidationException::withMessages(['status' => 'El pedido ya está pagado']);
            }

            $pagadoActual = $this->ordersService->totalPagado($order);
            $nuevoTotalPagado = $pagadoActual + $amount;

            if ($nuevoTotalPagado - $order->total > 0.0001) {
                throw ValidationException::withMessages(['amount' => 'No se permite pagar más que el total del pedido']);
            }

            Payment::create([
                'order_id' => $order->id,
                'method' => $method,
                'amount' => $amount,
                'paid_at' => $paidAt,
            ]);

            $order = $this->ordersService->cerrarSiPagado($order->fresh(['items', 'payments']));

            return $order;
        });
    }
}
