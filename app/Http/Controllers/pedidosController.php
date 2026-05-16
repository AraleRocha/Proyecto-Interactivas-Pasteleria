<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\pedido_producto;
use App\Models\Pago;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PedidosController extends Controller
{
    /* ── LISTADO ──────────────────────────────────────────────────*/
    public function index()
    {
        $user  = Auth::user();
        $query = Pedido::with(['productos.producto', 'pago', 'user'])
                       ->orderByDesc('fecha_pedido');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id)
                  ->where('estado', '!=', 'borrador');
        }

        $pedidos = $query->paginate(10);

        $pedidoBorrador = $user->role !== 'admin'
            ? Pedido::with('productos.producto')
                    ->where('user_id', $user->id)
                    ->where('estado', 'borrador')
                    ->first()
            : null;

        if ($user->role === 'admin') {
            return view('admin.pedidos', compact('pedidos'));
        }

        return view('client.pedidos', compact('pedidos', 'pedidoBorrador'));
    }

    /* ── DETALLE ──────────────────────────────────────────────────*/
    public function show(Pedido $pedido)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $pedido->user_id !== $user->id) abort(403);

        $pedido->load(['productos.producto', 'pago', 'user']);

        if ($user->role === 'admin') {
            return view('admin.pedido_detalle', compact('pedido'));
        }

        return view('client.pedido_detalle', compact('pedido'));
    }

    /* ── AGREGAR AL BORRADOR ──────────────────────────────────────*/
    public function agregar(Request $request)
    {
        $data = $request->validate([
            'producto_id' => ['required', 'exists:productos,id'],
            'cantidad'    => ['required', 'integer', 'min:1'],
        ]);

        $user   = Auth::user();

        $pedido = DB::transaction(function () use ($data, $user) {
            $producto = Producto::where('disponible', true)
                                ->lockForUpdate()
                                ->findOrFail($data['producto_id']);

            if ($producto->stock < $data['cantidad']) {
                throw ValidationException::withMessages([
                    'cantidad' => 'No hay stock suficiente.',
                ]);
            }

            $pedido = Pedido::firstOrCreate(
                ['user_id' => $user->id, 'estado' => 'borrador'],
                ['fecha_pedido' => now(), 'fecha_entrega' => now()->addWeek(), 'total' => 0]
            );

            $item = pedido_producto::where('pedido_id', $pedido->id)
                                   ->where('producto_id', $producto->id)
                                   ->first();
            if ($item) {
                $item->cantidad += $data['cantidad'];
                $item->subtotal  = $item->cantidad * $item->precio_unitario;
                $item->save();
            } else {
                pedido_producto::create([
                    'pedido_id'       => $pedido->id,
                    'producto_id'     => $producto->id,
                    'cantidad'        => $data['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'subtotal'        => $producto->precio * $data['cantidad'],
                ]);
            }

            $pedido->total = $pedido->productos()->sum('subtotal');
            $pedido->save();
            return $pedido;
        });

        return redirect()->route('pedidos.show', $pedido)
                         ->with('success', 'Producto agregado al pedido.');
    }

    /* ── EDITAR ÍTEM (solo borrador) ──────────────────────────────*/
    public function updateItem(Request $request, pedido_producto $item)
    {
        $this->autorizarItem($item);

        $data = $request->validate(['cantidad' => ['required', 'integer', 'min:1']]);

        DB::transaction(function () use ($item, $data) {
            $item->cantidad = $data['cantidad'];
            $item->subtotal = $item->cantidad * $item->precio_unitario;
            $item->save();

            $pedido        = $item->pedido;
            $pedido->total = $pedido->productos()->sum('subtotal');
            $pedido->save();
        });

        return back()->with('success', 'Cantidad actualizada.');
    }

    /* ── ELIMINAR ÍTEM (solo borrador) ────────────────────────────*/
    public function destroyItem(pedido_producto $item)
    {
        $this->autorizarItem($item);

        DB::transaction(function () use ($item) {
            $pedido = $item->pedido;
            $item->delete();
            $pedido->total = $pedido->productos()->sum('subtotal');
            $pedido->save();
        });

        return back()->with('success', 'Producto eliminado del pedido.');
    }

    /* ── CONFIRMAR PEDIDO: borrador → pendiente ───────────────────
     |  Solo pide método de pago.
     |  La fecha de entrega se fija automática a +2 días.
     * ─────────────────────────────────────────────────────────────*/
    public function confirmar(Request $request, Pedido $pedido)
    {
        $this->autorizarPedido($pedido);

        if ($pedido->estado !== 'borrador') abort(403);

        if ($pedido->productos()->count() === 0) {
            return back()->withErrors(['pedido' => 'El pedido está vacío.']);
        }

        $data = $request->validate([
            'metodo_pago' => ['required', 'in:efectivo,tarjeta'],
        ]);

        DB::transaction(function () use ($pedido, $data) {
            $pedido->update([
                'estado'        => 'pendiente',
                'fecha_entrega' => now()->addDays(2),   // automático
            ]);

            Pago::updateOrCreate(
                ['pedido_id' => $pedido->id],
                [
                    'metodo_pago' => $data['metodo_pago'],
                    'estado_pago' => 'pendiente',
                    'monto'       => $pedido->total,
                ]
            );
        });

        return redirect()->route('pedidos.show', $pedido)
                         ->with('success', 'Pedido confirmado. Ya puedes proceder a la compra.');
    }

    /* ── COMPRAR: pendiente → por_confirmar ──────────────────────────
     |  Descuenta stock y fija entrega +7 días desde hoy.
     * ─────────────────────────────────────────────────────────────*/
    public function comprar(Pedido $pedido)
    {
        $this->autorizarPedido($pedido);

        if ($pedido->estado !== 'pendiente') abort(403);

        DB::transaction(function () use ($pedido) {
            $pedido->load('productos.producto');

            foreach ($pedido->productos as $item) {
                $producto = Producto::lockForUpdate()->findOrFail($item->producto_id);
                if ($producto->stock < $item->cantidad) {
                    throw ValidationException::withMessages([
                        'stock' => "Sin stock suficiente para «{$producto->nombre}».",
                    ]);
                }
            }

            foreach ($pedido->productos as $item) {
                Producto::where('id', $item->producto_id)->decrement('stock', $item->cantidad);
            }

            $pedido->pago?->update(['estado_pago' => 'pagado']);

            $pedido->update([
                'estado'        => 'por_confirmar',
                'fecha_entrega' => now()->addWeek(),    // automático +7 días
            ]);
        });

        return redirect()->route('pedidos.show', $pedido)
                         ->with('success', '¡Compra realizada! Tu pedido estará listo en aprox. 7 días.');
    }

    /* ── CANCELAR (solo pendiente) ────────────────────────────────*/
    public function cancelar(Pedido $pedido)
    {
        $this->autorizarPedido($pedido);

        if ($pedido->estado !== 'pendiente') abort(403);

        DB::transaction(function () use ($pedido) {
            $pedido->update(['estado' => 'cancelado']);
            $pedido->pago?->delete();
        });

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido cancelado.');
    }

    /* ── ADMIN: cambiar estado ────────────────────────────────────*/
    public function updateEstado(Request $request, Pedido $pedido)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $data = $request->validate([
            'estado' => ['required', 'in:pendiente,por_confirmar,horneando,listo,rechazado,cancelado'],
        ]);

        $pedido->update(['estado' => $data['estado']]);

        return back()->with('success', 'Estado actualizado.');
    }

    //Para Admin
    public function aprobar(Pedido $pedido)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        if ($pedido->estado !== 'por_confirmar') abort(403);

        DB::transaction(function () use ($pedido) {
            $pedido->load('productos.producto');

            foreach ($pedido->productos as $item) {
                $producto = Producto::lockForUpdate()->findOrFail($item->producto_id);

                if ($producto->stock < $item->cantidad) {
                    throw ValidationException::withMessages([
                        'stock' => "Sin stock suficiente para «{$producto->nombre}».",
                    ]);
                }
            }

            foreach ($pedido->productos as $item) {
                Producto::where('id', $item->producto_id)->decrement('stock', $item->cantidad);
            }

            $pedido->pago?->update(['estado_pago' => 'pagado']);

            $pedido->update([
                'estado' => 'horneando',
            ]);
        });

        return back()->with('success', 'Pedido aprobado. Ahora está horneando.');
    }

    public function rechazar(Pedido $pedido)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        if ($pedido->estado !== 'por_confirmar') abort(403);

        DB::transaction(function () use ($pedido) {
            $pedido->update([
                'estado' => 'rechazado',
            ]);

            $pedido->pago?->update([
                'estado_pago' => 'rechazado',
            ]);
        });

        return back()->with('success', 'Pedido rechazado.');
    }

    public function marcarListo(Pedido $pedido)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        if ($pedido->estado !== 'horneando') abort(403);

        $pedido->update([
            'estado' => 'listo',
        ]);

        return back()->with('success', 'Pedido marcado como listo para entrega.');
    }

    /* ── Helpers ──────────────────────────────────────────────────*/
    private function autorizarPedido(Pedido $pedido): void
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $pedido->user_id !== $user->id) abort(403);
    }

    private function autorizarItem(pedido_producto $item): void
    {
        $pedido = $item->pedido;
        $this->autorizarPedido($pedido);
        if ($pedido->estado !== 'borrador') abort(403);  // solo en borrador
    }
}