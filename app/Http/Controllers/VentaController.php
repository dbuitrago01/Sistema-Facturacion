<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use App\Models\VentaItem;
use App\Models\Item;
use App\Models\StockMovimiento;

class VentaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'items'             => 'required|array|min:1',
            'items.*.id'        => 'required|exists:items,id',
            'items.*.cantidad'  => 'required|integer|min:1',
            'items.*.precio'    => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {

                // 1️⃣ Crear la venta
                $venta = Venta::create([
                    'user_id' => Auth::id(),
                    'total'   => 0,
                ]);

                $total = 0;

                // 2️⃣ Recorrer los items vendidos
                foreach ($request->items as $data) {

                    $item = Item::lockForUpdate()->findOrFail($data['id']);

                    $subtotal = $data['cantidad'] * $data['precio'];
                    $total   += $subtotal;

                    // 3️⃣ Guardar detalle de la venta
                    VentaItem::create([
                        'venta_id' => $venta->id,
                        'item_id'  => $item->id,
                        'cantidad' => $data['cantidad'],
                        'precio'   => $data['precio'],
                        'subtotal' => $subtotal,
                    ]);

                    // 4️⃣ Registrar movimiento SIEMPRE como SALIDA
                    if ($item->tipo === 'producto') {

                        if ($item->stock < $data['cantidad']) {
                            throw new \Exception("Stock insuficiente para {$item->nombre}");
                        }

                        $stockAnterior = $item->stock;
                        $stockActual   = $stockAnterior - $data['cantidad'];

                        Item::withoutEvents(function () use ($item, $stockActual) {
                            $item->update(['stock' => $stockActual]);
                        });

                        StockMovimiento::create([
                            'item_id'        => $item->id,
                            'tipo'           => 'salida',
                            'cantidad'       => $data['cantidad'],
                            'stock_anterior' => $stockAnterior,
                            'stock_actual'   => $stockActual,
                            'user_id'        => Auth::id(),
                            'motivo'         => 'Venta de producto',
                        ]);

                    } else { // SERVICIO → salida sin stock

                        StockMovimiento::create([
                            'item_id'        => $item->id,
                            'tipo'           => 'salida',
                            'cantidad'       => $data['cantidad'],
                            'stock_anterior' => 0,
                            'stock_actual'   => 0,
                            'user_id'        => Auth::id(),
                            'motivo'         => 'Venta de servicio',
                        ]);
                    }
                }

                // 5️⃣ Actualizar total de la venta
                $venta->update(['total' => $total]);
            });

            return response()->json([
                'message' => 'Venta registrada con éxito'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar la venta',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
