<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
   protected $fillable = [
        'nombre',
        'tipo',
        'precio',
        'stock',
        'activo' => 'boolean'
    ];

    public function ventaItems()
    {
        return $this->hasMany(VentaItem::class);
    }

    public function movimientos()
    {
        return $this->hasMany(StockMovimiento::class);
    }
    
}
