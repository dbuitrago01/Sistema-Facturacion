<?php

namespace App\Http\Controllers;


use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('created_at', 'desc')->get();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }
    

    public function store(Request $request)
    {
     $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo' => 'required|in:servicio,producto',
        'precio' => 'required|numeric|min:0',
        'stock' => 'nullable|integer|min:0'
    ]);

    Item::create([
        'nombre' => $request->nombre,
        'tipo' => $request->tipo,
        'precio' => $request->precio,
        'stock' => $request->tipo === 'producto' ? $request->stock : null,
        'activo' => true
    ]);

    return redirect()->route('items.index')
        ->with('success', 'Item creado correctamente');
   }



   public function edit($id)
{
    $item = Item::findOrFail($id);
    return view('items.edit', compact('item'));
}    


public function update(Request $request, $id)
{

    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo'   => 'required|in:servicio,producto',
        'precio' => 'required|numeric|min:0',
        'stock'  => 'nullable|integer|min:0',
        'activo' => 'nullable|boolean',
    ]);
// dd($request->all());

    $item = Item::findOrFail($id);
    $item->update([
        'nombre' => $request->nombre,
        'tipo'   => $request->tipo,
        'precio' => $request->precio,
        'stock'  => $request->tipo === 'producto' ? $request->stock : null,
        'activo' => $request->activo ?? $item->activo,
    ]);

     

    return redirect()->route('items.index')
                     ->with('success', 'Item actualizado correctamente 💈');
}

}

