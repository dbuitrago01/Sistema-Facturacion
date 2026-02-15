<?php

namespace App\Http\Controllers;

use App\Models\StockMovimiento;
use Illuminate\Http\Request;

class StockMovimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovimiento::with(['item', 'user'])
            ->orderBy('created_at', 'desc');

        // 🔍 Filtros opcionales
        if ($request->item_id) {
            $query->where('item_id', $request->item_id);
        }

        if ($request->tipo) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->fecha_desde && $request->fecha_hasta) {
            $query->whereBetween('created_at', [
                $request->fecha_desde . ' 00:00:00',
                $request->fecha_hasta . ' 23:59:59',
            ]);
        }

        $movimientos = $query->paginate(20);
      
        return view('stock.movimientos', compact('movimientos'));
        // return response()->json($movimientos);
    }
}
