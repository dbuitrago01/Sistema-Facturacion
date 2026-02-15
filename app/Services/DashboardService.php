<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    public function hoy()
    {
        $hoy = Carbon::today();

        return [
            'total' => DB::table('ventas')
                ->whereDate('created_at', $hoy)
                ->sum('total'),

            'ventas' => DB::table('ventas')
                ->whereDate('created_at', $hoy)
                ->count(),

            'servicios' => DB::table('venta_items')
                ->join('items', 'venta_items.item_id', '=', 'items.id')
                ->where('items.tipo', 'servicio')
                ->whereDate('venta_items.created_at', $hoy)
                ->sum('venta_items.cantidad'),

            'productos' => DB::table('venta_items')
                ->join('items', 'venta_items.item_id', '=', 'items.id')
                ->where('items.tipo', 'producto')
                ->whereDate('venta_items.created_at', $hoy)
                ->sum('venta_items.cantidad'),
        ];
    }

    public function ultimasVentas()
    {
        return DB::table('ventas')
            ->join('users', 'ventas.user_id', '=', 'users.id')
            ->select(
                'ventas.id',
                'ventas.total',
                'users.name as usuario',
                'ventas.created_at'
            )
            ->latest()
            ->limit(5)
            ->get();
    }

    public function stockBajo()
    {
        return DB::table('items')
            ->where('tipo', 'producto')
            ->where('stock', '<=', 5)
            ->select('nombre', 'stock')
            ->orderBy('stock')
            ->get();
    }
}
