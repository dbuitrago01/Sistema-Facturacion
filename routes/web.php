<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FacturacionController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\StockMovimientoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReporteController;


Route::get('/', function () {
    return  redirect()->route('login');
});


//RUTA PARA ENVIO DE DATOS DEL LOGIN
   Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

//RUTA VALIDACION DE AUTENTICACION
    Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //RUTA QUE DIRECCIONA EL LOGIN 
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Route::view('/items', 'items.index')->name('items');

    Route::middleware('auth')->post('/ventas', [VentaController::class, 'store'])
    ->name('ventas.store');

    //CRUD DE ITEMS
    Route::resource('items', ItemController::class);
   
    

    Route::get('/facturacion', [FacturacionController::class, 'index'])->name('facturacion.index');
    Route::post('/ventas', [VentaController::class, 'store'])->middleware('auth')->name('ventas.store');
    
    Route::get('/inventario', [InventarioController::class, 'index'])
    ->name('stock.index');

    Route::get('/stock-movimientos', [StockMovimientoController::class, 'index'])->name('stock.movimientos');

    // Route::view('/facturacion', 'facturacion.index')->name('facturacion');
    // Route::view('/stock', 'stock.index')->name('stock');
    Route::view('/reportes', 'reportes.index')->name('reportes');

    Route::middleware('auth')->group(function () {

    Route::get('/panel', [DashboardController::class, 'index'])
        ->name('panel');

    Route::get('/api/panel', [DashboardController::class, 'data']);
     });


      Route::middleware(['auth'])->group(function () {

    Route::get('/reportes', [ReporteController::class, 'index'])
        ->name('reportes');

    Route::get('/reportes/ventas', [ReporteController::class, 'ventas'])
        ->name('reportes.ventas');

    Route::post('/reportes/ventas-fecha', [ReporteController::class, 'ventasPorFecha'])
        ->name('reportes.ventas.fecha');
});

    
});






require __DIR__.'/auth.php';
