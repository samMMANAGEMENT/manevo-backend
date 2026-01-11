<?php

namespace App\Http\Modules\Orders\Service;

use App\Http\Modules\Orders\Models\Order;
use App\Http\Modules\Orders\Models\OrderItem;
use App\Http\Modules\Productos\Models\Products;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OrdersService
{
    public function __construct(private DatabaseManager $db)
    {
    }

    public function crearBorrador(int $entityId): Order
    {
        return Order::create([
            'entity_id' => $entityId,
            'status' => Order::STATUS_DRAFT,
            'total' => 0,
        ]);
    }

    public function listar(int $entityId, ?string $status = null): Collection
    {
        return Order::byEntity($entityId)
            ->when($status, fn($q) => $q->where('status', $status))
            ->with(['items.product', 'payments'])
            ->orderByDesc('id')
            ->get();
    }

    public function detalle(int $entityId, int $orderId): Order
    {
        return Order::byEntity($entityId)
            ->with(['items.product', 'payments'])
            ->findOrFail($orderId);
    }

    public function cancelar(int $entityId, int $orderId): Order
    {
        $order = $this->detalle($entityId, $orderId);

        if ($order->status === Order::STATUS_PAID) {
            throw ValidationException::withMessages(['status' => 'No se puede cancelar un pedido pagado']);
        }

        $order->update(['status' => Order::STATUS_CANCELLED]);

        return $order;
    }

    public function recalcTotales(Order $order): Order
    {
        $total = $order->items()->sum('subtotal');
        $order->update(['total' => $total]);
        return $order->fresh(['items', 'payments']);
    }

    public function asegurarEditable(Order $order): void
    {
        if ($order->status !== Order::STATUS_DRAFT) {
            throw ValidationException::withMessages(['status' => 'Solo pedidos en DRAFT pueden modificarse']);
        }
    }

    public function totalPagado(Order $order): float
    {
        return (float) $order->payments()->sum('amount');
    }

    public function cerrarSiPagado(Order $order): Order
    {
        $pagado = $this->totalPagado($order);

        if ($order->status === Order::STATUS_PAID) {
            return $order;
        }

        if ($pagado + 0.0001 < $order->total) {
            return $order;
        }

        return $this->db->transaction(function () use ($order) {
            $this->validarStock($order);
            $this->descontarStock($order);
            $order->update(['status' => Order::STATUS_PAID]);
            return $order->fresh(['items.product', 'payments']);
        });
    }

    protected function validarStock(Order $order): void
    {
        foreach ($order->items as $item) {
            $producto = Products::where('id', $item->product_id)
                ->where('entity_id', $order->entity_id)
                ->firstOrFail();

            if ($producto->stock < $item->quantity) {
                throw ValidationException::withMessages([
                    'stock' => "Stock insuficiente para {$producto->name}",
                ]);
            }
        }
    }

    protected function descontarStock(Order $order): void
    {
        foreach ($order->items as $item) {
            Products::where('id', $item->product_id)
                ->where('entity_id', $order->entity_id)
                ->decrement('stock', $item->quantity);
        }
    }
}
