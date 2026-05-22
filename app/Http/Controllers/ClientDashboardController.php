<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $misPedidos = Pedido::where('user_id', $user->id)->count();
        $pendientes = Pedido::where('user_id', $user->id)->where('estado', 'pendiente')->count();
        $horneando = Pedido::where('user_id', $user->id)->where('estado', 'horneando')->count();
        $listos = Pedido::where('user_id', $user->id)->where('estado', 'listo')->count();

        $labels = ['Pendiente', 'Horneando', 'Listo', 'Cancelado'];
        $data = [
            Pedido::where('user_id', $user->id)->where('estado', 'pendiente')->count(),
            Pedido::where('user_id', $user->id)->where('estado', 'horneando')->count(),
            Pedido::where('user_id', $user->id)->where('estado', 'listo')->count(),
            Pedido::where('user_id', $user->id)->where('estado', 'cancelado')->count(),
        ];

        return view('client.dashboard', compact('misPedidos', 'pendientes', 'horneando', 'listos', 'labels', 'data'));
    }
}