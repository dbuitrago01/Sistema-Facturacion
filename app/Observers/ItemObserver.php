<?php

namespace App\Observers;

use App\Models\Item;
use App\Models\StockMovimiento;
use Illuminate\Support\Facades\Auth;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     */
    public function created(Item $item): void
    {
        // Registrar el stock inicial como 'entrada'
        if ($item->stock > 0) {
            StockMovimiento::create([
                'item_id' => $item->id,
                'tipo' => 'entrada',
                'cantidad' => $item->stock,
                'stock_anterior' => 0,
                'stock_actual' => $item->stock,
                'user_id' => Auth::id(),
                'motivo' => 'Creación de producto con stock inicial',
            ]);
        }
    }

    /**
     * Handle the Item "updated" event.
     */
    public function updated(Item $item): void
    {
        // Evitamos registrar movimientos si solo estamos guardando desde VentaController
        if ($item->wasChanged('stock')) {
            $stockAnterior = $item->getOriginal('stock');
            $stockActual = $item->stock;

            // Solo registramos si se **adiciona stock** (no permitimos restar)
            if ($stockActual > $stockAnterior) {
                StockMovimiento::create([
                    'item_id' => $item->id,
                    'tipo' => 'adicion', // Tipo: adición
                    'cantidad' => $stockActual - $stockAnterior,
                    'stock_anterior' => $stockAnterior,
                    'stock_actual' => $stockActual,
                    'user_id' => Auth::id(),
                    'motivo' => 'Adición de producto',
                ]);
            }
        }
    }
}
