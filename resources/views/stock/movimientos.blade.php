<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historial de movimientos
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto">

        {{-- Filtros --}}
        <form method="GET" class="flex gap-4 mb-6">
            <select name="tipo" class="border rounded px-3 py-2">
                <option value="">Todos</option>
                <option value="entrada" {{ request('tipo') === 'entrada' ? 'selected' : '' }}>Entradas</option>
                <option value="salida" {{ request('tipo') === 'salida' ? 'selected' : '' }}>Salidas</option>
                <option value="adicion" {{ request('tipo') === 'adicion' ? 'selected' : '' }}>Adicion</option>
            </select>

            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="border rounded px-3 py-2" />
            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="border rounded px-3 py-2" />

            <button type="submit" class="bg-blue-600 text-white px-4 rounded">
                Filtrar
            </button>
        </form>

        {{-- Tabla --}}
        <div class="p-6 bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border text-center">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Item</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Movimiento</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Stock</th>
                        <th class="px-4 py-2">Motivo</th>
                        <th class="px-4 py-2">Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movimientos as $mov)
                        @php
                            $tipo = strtolower(trim($mov->tipo));
                            $colorTipo = match($tipo) {
                                'entrada' => 'bg-green-600 text-white font-semibold',
                                'salida'  => 'bg-red-600 text-white font-semibold',
                                'adicion' => 'bg-blue-600 text-white font-semibold',
                                default   => 'bg-gray-400 text-white font-semibold',
                            };
                        @endphp

                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2">{{ $mov->item->nombre ?? 'Item eliminado' }}</td>
                            <td class="px-4 py-2">{{ $mov->item->tipo }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs {{ $colorTipo }}" style="color: white !important;">
                                    {{ ucfirst($tipo) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $mov->cantidad }}</td>
                            <td class="px-4 py-2">{{ $mov->stock_anterior }} → {{ $mov->stock_actual }}</td>
                            <td class="px-4 py-2">{{ $mov->motivo ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $mov->user->name ?? 'Sistema' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                No hay movimientos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $movimientos->links() }}
        </div>
    </div>
</x-app-layout>
