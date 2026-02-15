<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class FacturacionController extends Controller
{
    public function index()
    {
        // Traemos solo los items activos (productos y servicios)
        $items = Item::where('activo', true)->get();

        // Pasamos la variable a la vista
        return view('facturacion.index', compact('items'));
    }
}

