<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\pedido_producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/* 4 endpoints:
 POST /api/login: obtener token
 GET  /api/productos: catálogo público
 GET  /api/productos/{id}: detalle de un pastel
 POST /api/pedidos: agregar producto al borrador del cliente (requiere token)
 */
class ApiController extends Controller
{
    /* Devuelve un token Sanctum. */
    public function login(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
                'device_name' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $user = \App\Models\User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        // Revoca tokens anteriores del mismo dispositivo
        $user->tokens()->where('name', $request->device_name)->delete();

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ],
        ], 200);
    }

    /* Devuelve todos los pasteles disponibles */
    public function catalogo(Request $request): JsonResponse
    {
        $query = Producto::where('disponible', true)
                         ->where('stock', '>', 0)
                         ->orderBy('nombre');

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $productos = $query->get()->map(fn($p) => [
            'id' => $p->id,
            'nombre' => $p->nombre,
            'sabor' => $p->sabor,
            'tamano' => $p->tamano,
            'categoria'  => $p->categoria,
            'precio' => (float) $p->precio,
            'stock' => $p->stock,
            'imagen_url' => $p->imagen ? asset('storage/' . $p->imagen) : null,
        ]);

        return response()->json([
            'success' => true,
            'total' => $productos->count(),
            'data' => $productos,
        ], 200);
    }

    /* Detalle de un pastel */
    public function detalle(string $id): JsonResponse
    {
        $producto = Producto::where('disponible', true)->find($id);

        if (! $producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'sabor' => $producto->sabor,
                'tamano' => $producto->tamano,
                'categoria' => $producto->categoria,
                'precio' => (float) $producto->precio,
                'stock' => $producto->stock,
                'disponible' => (bool) $producto->disponible,
                'imagen_url' => $producto->imagen ? asset('storage/' . $producto->imagen) : null,
                'creado_en' => $producto->created_at?->toIso8601String(),
            ],
        ], 200);
    }

    /* Agrega un producto al borrador activo del cliente, si no tiene borrador, lo crea automáticamente */
    public function agregarPedido(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'producto_id' => 'required|exists:productos,id',
                'cantidad' => 'required|integer|min:1',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos.',
                'errors' => $e->errors(),
            ], 422);
        }

        $user = Auth::user();

        try {
            $pedido = DB::transaction(function () use ($data, $user) {
                $producto = Producto::where('disponible', true)
                                    ->lockForUpdate()
                                    ->find($data['producto_id']);

                if (! $producto) {
                    throw ValidationException::withMessages([
                        'producto_id' => ['El producto no está disponible.'],
                    ]);
                }

                if ($producto->stock < $data['cantidad']) {
                    throw ValidationException::withMessages([
                        'cantidad' => ["Stock insuficiente. Disponible: {$producto->stock}"],
                    ]);
                }

                // Reusar o crear borrador
                $pedido = Pedido::firstOrCreate(
                    ['user_id' => $user->id, 'estado' => 'borrador'],
                    ['fecha_pedido' => now(), 'fecha_entrega' => null, 'total' => 0]
                );

                // Si el producto ya está en el pedido, sumar cantidad
                $item = pedido_producto::where('pedido_id', $pedido->id)
                                       ->where('producto_id', $producto->id)
                                       ->first();

                if ($item) {
                    $item->cantidad += $data['cantidad'];
                    $item->subtotal  = $item->cantidad * $item->precio_unitario;
                    $item->save();
                } else {
                    pedido_producto::create([
                        'pedido_id' => $pedido->id,
                        'producto_id' => $producto->id,
                        'cantidad' => $data['cantidad'],
                        'precio_unitario' => $producto->precio,
                        'subtotal' => $producto->precio * $data['cantidad'],
                    ]);
                }

                $pedido->total = $pedido->productos()->sum('subtotal');
                $pedido->save();

                return $pedido->load('productos.producto');
            });
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos.',
                'errors' => $e->errors(),
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al pedido.',
            'data' => [
                'pedido_id' => $pedido->id,
                'estado' => $pedido->estado,
                'total' => (float) $pedido->total,
                'productos' => $pedido->productos->map(fn($i) => [
                    'nombre' => $i->producto?->nombre,
                    'cantidad' => $i->cantidad,
                    'precio_unitario' => (float) $i->precio_unitario,
                    'subtotal' => (float) $i->subtotal,
                ])->values(),
            ],
        ], 201);
    }
}