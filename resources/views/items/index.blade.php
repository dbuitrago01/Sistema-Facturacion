<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Items (Servicios y Productos)
            </h2>

            <a href="{{ route('items.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Crear Item
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white shadow rounded p-4">

                <table class="w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">Nombre</th>
                            <th class="p-2 border">Tipo</th>
                            <th class="p-2 border">Precio</th>
                            <!-- <th class="p-2 border">Stock</th> -->
                            <th class="p-2 border">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td class="p-2 border">{{ $item->nombre }}</td>
                                <td class="p-2 border capitalize">{{ $item->tipo }}</td>
                                <td class="p-2 border">$ {{ number_format($item->precio, 0) }}</td>
                                <!-- <td class="p-2 border">
                                    {{ $item->tipo === 'producto' ? $item->stock : '-' }}
                                </td> -->
                                <td class="p-2 border">
                                    <a href="{{ route('items.edit', $item->id) }}"
                                       class="text-blue-600 hover:underline">Editar</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-4">
                                    No hay items registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
