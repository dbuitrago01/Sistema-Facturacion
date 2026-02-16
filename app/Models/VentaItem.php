<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class VentaItem extends Model
{
    protected $fillable = [
        'venta_id',
        'item_id',
        'cantidad',
        'precio',
        'subtotal'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
