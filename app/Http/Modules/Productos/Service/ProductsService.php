<?php

namespace App\Http\Modules\Productos\Service;

use App\Http\Modules\Productos\Models\Products;

class ProductsService
{
    public function crearProducto(array $data, int $entityId)
    {
        $categoryId = $data['category_id'] ?? 1;
        $data['category_id'] = $categoryId;
        $data['entity_id'] = $entityId;

        return Products::create($data);
    }

    public function listarProductos(int $entityId)
    {
        return Products::where('entity_id', $entityId)
            ->with('category:id,name', 'entity:id,nombre')
            ->paginate(10);
    }

    public function actualizarProducto(int $productoId, array $data, int $entityId)
    {
        $producto = Products::where('id', $productoId)
            ->where('entity_id', $entityId)
            ->firstOrFail();
        
        $producto->update($data);
        return $producto;
    }

    public function eliminarProducto(int $productoId, int $entityId): bool
    {
        $producto = Products::where('id', $productoId)
            ->where('entity_id', $entityId)
            ->firstOrFail();
        
        return $producto->delete();
    }
}
