<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Item
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 shadow rounded">

            <form method="POST" action="{{ route('items.update', $item->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium">Nombre</label>
                    <input
                        type="text"
                        name="nombre"
                        class="w-full border p-2 rounded"
                        value="{{ old('nombre', $item->nombre) }}"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Tipo</label>
                    <select name="tipo" id="tipo" class="w-full border p-2 rounded" required>
                        <option value="">Seleccione</option>
                        <option value="servicio" {{ $item->tipo == 'servicio' ? 'selected' : '' }}>
                            Servicio
                        </option>
                        <option value="producto" {{ $item->tipo == 'producto' ? 'selected' : '' }}>
                            Producto
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Precio</label>
                    <input
                        type="number"
                        name="precio"
                        step="0.01"
                        class="w-full border p-2 rounded"
                        value="{{ old('precio', $item->precio) }}"
                        required
                    >
                </div>

                <!-- <select name="activo" class="w-full border p-2 rounded">
        <option value="1" {{ $item->activo ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ !$item->activo ? 'selected' : '' }}>No</option>
    </select> -->

                <div
                    class="mb-4"
                    id="stock-field"
                    style="{{ $item->tipo === 'producto' ? '' : 'display:none;' }}"
                >
                    <label class="block font-medium">Stock</label>
                    <input
                        type="number"
                        name="stock"
                        class="w-full border p-2 rounded"
                        value="{{ old('stock', $item->stock) }}"
                    >
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('items.index') }}" class="px-4 py-2 border rounded">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Actualizar
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        document.getElementById('tipo').addEventListener('change', function () {
            document.getElementById('stock-field').style.display =
                this.value === 'producto' ? 'block' : 'none';
        });
    </script>
</x-app-layout>
