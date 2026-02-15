<?php

namespace App\Http\Controllers;

use App\Models\Item;

class InventarioController extends Controller
{
    public function index()
    { 
        
        $items = Item::orderBy('tipo')   // productos primero, servicios después
                    ->orderBy('nombre')
                    ->get();

        


        return view('stock.index', compact('items'));
    }
}
