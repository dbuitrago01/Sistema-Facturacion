<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-6">

        <h2 class="text-2xl font-bold">📥 Reportes en Excel</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Ventas totales --}}
            <a href="{{ route('reportes.ventas') }}"
               class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition border-l-4 border-green-600">

                <div class="flex items-center gap-4">
                    <div class="text-4xl">📊</div>
                    <div>
                        <h3 class="text-lg font-semibold">Ventas totales</h3>
                        <p class="text-sm text-gray-500">
                            Descargar todas las ventas registradas
                        </p>
                    </div>
                </div>

                <div class="mt-4 text-green-600 font-semibold">
                    Descargar Excel →
                </div>
            </a>

            {{-- Ventas por fechas --}}
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-600">

                <div class="flex items-center gap-3 mb-4">
                    <div class="text-3xl">📅</div>
                    <h3 class="text-lg font-semibold">Ventas por fechas</h3>
                </div>

                <form method="POST" action="{{ route('reportes.ventas.fecha') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="text-sm text-gray-600">Fecha inicio</label>
                        <input type="date" name="inicio" required
                               class="w-full border rounded px-2 py-1">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Fecha fin</label>
                        <input type="date" name="fin" required
                               class="w-full border rounded px-2 py-1">
                    </div>

                    <button
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Descargar Excel
                    </button>
                </form>

            </div>

        </div>

    </div>
</x-app-layout>
