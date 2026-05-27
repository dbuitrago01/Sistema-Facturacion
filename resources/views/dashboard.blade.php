



<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             Barbería
        </h2>
    </x-slot><br><br>

    <div class="py-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <a href="{{ route('items.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold">🧴 Items</h3>
                <p class="text-gray-600">Servicios y productos</p>
            </a>

            <a href="{{ route('facturacion.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold">💰 Facturación</h3>
                <p class="text-gray-600">Caja y ventas</p>
            </a>

            <a href="{{ route('stock.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold">📦 Stock</h3>
                <p class="text-gray-600">Inventario</p>
            </a>
            <a href="{{ route('stock.movimientos') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold">📜 Historial</h3>
                <p class="text-gray-600">Movimientos Transaccionales</p>
            </a>

             <a href="{{ route('panel') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold">📊 Panel</h3>
                <p class="text-gray-600">Venta Diaria</p>
            </a>

            <a href="{{ route('reportes') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-lg font-bold">📈 Reportes</h3>
                <p class="text-gray-600">Ventas y estadísticas</p>
            </a>

        </div>
    </div>
</x-app-layout>

