<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


    class Venta extends Model
{
    protected $fillable = ['total', 'user_id'];

    public function items()
    {
        return $this->hasMany(VentaItem::class);
    }
}

