<?php

namespace App\Http\Modules\Orders\Service;

use App\Http\Modules\Orders\Models\OrderItem;
use App\Http\Modules\Productos\Models\Products;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class OrderItemsService
{
    public function __construct(private OrdersService $ordersService)
    {
    }

    public function agregar(int $entityId, int $orderId, int $productId, int $cantidad): OrderItem
    {
        $order = $this->ordersService->detalle($entityId, $orderId);
        $this->ordersService->asegurarEditable($order);

        $producto = Products::where('id', $productId)
            ->where('entity_id', $entityId)
            ->where('active', true)
            ->firstOrFail();

        if ($cantidad <= 0) {
            throw ValidationException::withMessages(['quantity' => 'La cantidad debe ser mayor a 0']);
        }

        if ($producto->stock < $cantidad) {
            throw ValidationException::withMessages(['stock' => 'Stock insuficiente']);
        }

        $subtotal = $producto->sale_price * $cantidad;
        $profit = ($producto->sale_price - $producto->cost_price) * $cantidad;

        $item = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $producto->id,
            'quantity' => $cantidad,
            'price' => $producto->sale_price,
            'subtotal' => $subtotal,
            'profit' => $profit,
        ]);

        $this->ordersService->recalcTotales($order);

        return $item->fresh(['product']);
    }

    public function actualizar(int $entityId, int $orderId, int $itemId, int $cantidad): OrderItem
    {
        $order = $this->ordersService->detalle($entityId, $orderId);
        $this->ordersService->asegurarEditable($order);

        $item = OrderItem::where('id', $itemId)
            ->where('order_id', $order->id)
            ->firstOrFail();

        $producto = Products::where('id', $item->product_id)
            ->where('entity_id', $entityId)
            ->firstOrFail();

        if ($cantidad <= 0) {
            throw ValidationException::withMessages(['quantity' => 'La cantidad debe ser mayor a 0']);
        }

        if ($producto->stock < $cantidad) {
            throw ValidationException::withMessages(['stock' => 'Stock insuficiente']);
        }

        $subtotal = $producto->sale_price * $cantidad;
        $profit = ($producto->sale_price - $producto->cost_price) * $cantidad;

        $item->update([
            'quantity' => $cantidad,
            'price' => $producto->sale_price,
            'subtotal' => $subtotal,
            'profit' => $profit,
        ]);

        $this->ordersService->recalcTotales($order);

        return $item->fresh(['product']);
    }

    public function eliminar(int $entityId, int $orderId, int $itemId): void
    {
        $order = $this->ordersService->detalle($entityId, $orderId);
        $this->ordersService->asegurarEditable($order);

        $item = OrderItem::where('id', $itemId)
            ->where('order_id', $order->id)
            ->firstOrFail();

        $item->delete();

        $this->ordersService->recalcTotales($order);
    }
}
