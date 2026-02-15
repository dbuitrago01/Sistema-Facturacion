<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                📊 Panel de Control
            </h2>

            {{-- KPIs --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-sm text-gray-500">💰 Total hoy</p>
                    <p id="total" class="text-3xl font-bold text-green-600">$0</p>
                </div>

                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-sm text-gray-500"> 🧾 Ventas</p>
                    <p id="ventas" class="text-3xl font-bold text-blue-600">0</p>
                </div>

                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-sm text-gray-500">✂️ Servicios</p>
                    <p id="servicios" class="text-3xl font-bold text-purple-600">0</p>
                </div>

                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-sm text-gray-500">📦 Productos</p>
                    <p id="productos" class="text-3xl font-bold text-orange-600">0</p>
                </div>

            </div>

            {{-- Listas --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="bg-white rounded-lg shadow p-5">
                    <h3 class="font-bold mb-4">🕒 Últimas ventas</h3>
                    <ul id="ultimasVentas" class="space-y-2 text-sm text-gray-700"></ul>
                </div>

                <div class="bg-white rounded-lg shadow p-5">
                    <h3 class="font-bold mb-4">⚠️ Stock bajo</h3>
                    <ul id="stockBajo" class="space-y-2 text-sm text-gray-700"></ul>
                </div>

            </div>

        </div>
    </div>

    <script>
        async function cargarPanel() {
            const res = await fetch('/api/panel');
            const data = await res.json();

            document.getElementById('total').innerText = `$${data.kpis.total}`;
            document.getElementById('ventas').innerText = data.kpis.ventas;
            document.getElementById('servicios').innerText = data.kpis.servicios;
            document.getElementById('productos').innerText = data.kpis.productos;

            document.getElementById('ultimasVentas').innerHTML =
                data.ultimasVentas.map(v =>
                    `<li class="flex justify-between border-b pb-1">
                        <span>#${v.id} - ${v.usuario}</span>
                        <span class="font-semibold">$${v.total}</span>
                    </li>`
                ).join('');

            document.getElementById('stockBajo').innerHTML =
                data.stockBajo.map(i =>
                    `<li class="flex justify-between border-b pb-1">
                        <span>${i.nombre}</span>
                        <span class="font-semibold text-red-600">${i.stock}</span>
                    </li>`
                ).join('');
        }

        cargarPanel();
        setInterval(cargarPanel, 5000);
    </script>
</x-app-layout>
