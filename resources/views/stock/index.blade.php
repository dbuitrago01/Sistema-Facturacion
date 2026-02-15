<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inventario
        </h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 border">
            <thead class="bg-gray-50">
                <tr class="text-center">
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Tipo</th>
                    <th class="px-4 py-2">Stock</th>
                     <th class="px-4 py-2">Precio Unidad</th>
                    <th class="px-4 py-2">Estado</th>
                </tr>
            </thead>

            <tbody>
    @forelse($items as $item)
        <tr class="text-center border-t">
            <!-- Nombre -->
            <td class="px-4 py-2">{{ $item->nombre }}</td>

            <!-- Tipo -->
            <td class="px-4 py-2">
                <span class="px-2 py-1 rounded text-sm
                    {{ $item->tipo === 'producto'
                        ? 'bg-blue-100 text-blue-800'
                        : 'bg-purple-100 text-purple-800' }}">
                    {{ ucfirst($item->tipo) }}
                </span>
            </td>

            <!-- Stock -->
            <td class="px-4 py-2
                {{ $item->tipo === 'producto' && ($item->stock ?? 0) <= 5
                    ? 'bg-red-100 text-red-700 font-bold'
                    : '' }}">
                @if($item->tipo === 'producto')
                    {{ $item->stock ?? 0 }}
                @else
                    <span class="text-gray-400 italic">No aplica</span>
                @endif
            </td>

            <!-- Precio -->
            <td class="px-4 py-2">
                @if($item->precio)
                    ${{ number_format($item->precio, 2) }}
                @else
                    <span class="text-gray-400 italic">No aplica</span>
                @endif
            </td>

            <!-- Estado -->
            <td class="px-4 py-2">
                @if($item->activo)
                    <span class="text-green-600 font-semibold">Activo</span>
                @else
                    <span class="text-red-600 font-semibold">Inactivo</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                No hay items registrados
            </td>
        </tr>
    @endforelse
</tbody>
        </table>
    </div>
</x-app-layout>
