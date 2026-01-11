<?php

namespace App\Http\Modules\Productos\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Productos\Service\ProductsService;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function __construct(private ProductsService $productsService)
    {}

    public function crearProducto(Request $request)
    {
        try {
            $user = auth()->user();
            $entityId = $user->entity_id;
            
            if (!$entityId) {
                return response()->json(['error' => 'Usuario no asociado a una entidad'], 403);
            }

            $producto = $this->productsService->crearProducto($request->all(), $entityId);
            return response()->json($producto, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function listarProductos()
    {
        try {
            $user = auth()->user();
            $entityId = $user->entity_id;
            
            if (!$entityId) {
                return response()->json(['error' => 'Usuario no asociado a una entidad'], 403);
            }

            $productos = $this->productsService->listarProductos($entityId);
            return response()->json($productos, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al obtener productos'], 500);
        }
    }

    public function actualizarProducto(Request $request, int $productoId)
    {
        try {
            $user = auth()->user();
            $entityId = $user->entity_id;
            
            if (!$entityId) {
                return response()->json(['error' => 'Usuario no asociado a una entidad'], 403);
            }

            $producto = $this->productsService->actualizarProducto($productoId, $request->all(), $entityId);
            return response()->json($producto, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function eliminarProducto(int $productoId)
    {
        try {
            $user = auth()->user();
            $entityId = $user->entity_id;
            
            if (!$entityId) {
                return response()->json(['error' => 'Usuario no asociado a una entidad'], 403);
            }

            $this->productsService->eliminarProducto($productoId, $entityId);
            return response()->json([], 204);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al eliminar producto'], 500);
        }
    }

    public function moverStock(Request $request, int $productoId)
    {
        $request->validate([
            'delta' => ['required', 'integer'],
        ]);

        try {
            $user = auth()->user();
            $entityId = $user->entity_id;
            
            if (!$entityId) {
                return response()->json(['error' => 'Usuario no asociado a una entidad'], 403);
            }

            $producto = $this->productsService->moverStock(
                $productoId,
                $entityId,
                (int) $request->input('delta')
            );

            return response()->json($producto, 200);
        } catch (\InvalidArgumentException $ex) {
            return response()->json(['error' => $ex->getMessage()], 422);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al mover stock'], 500);
        }
    }

    public function cambiarEstado(Request $request, int $productoId)
    {
        $request->validate([
            'active' => ['required', 'boolean'],
        ]);

        try {
            $user = auth()->user();
            $entityId = $user->entity_id;
            
            if (!$entityId) {
                return response()->json(['error' => 'Usuario no asociado a una entidad'], 403);
            }

            $producto = $this->productsService->cambiarEstado(
                $productoId,
                $entityId,
                (bool) $request->boolean('active')
            );

            return response()->json($producto, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al actualizar estado'], 500);
        }
    }
}
