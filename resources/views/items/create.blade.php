<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Item
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 shadow rounded">

            <form method="POST" action="{{ route('items.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium">Nombre</label>
                    <input type="text" name="nombre" class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Tipo</label>
                    <select name="tipo" id="tipo" class="w-full border p-2 rounded" required>
                        <option value="">Seleccione</option>
                        <option value="servicio">Servicio</option>
                        <option value="producto">Producto</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Precio</label>
                    <input type="number" name="precio" step="0.01" class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4" id="stock-field" style="display:none;">
                    <label class="block font-medium">Stock</label>
                    <input type="number" name="stock" class="w-full border p-2 rounded">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('items.index') }}" class="px-4 py-2 border rounded">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Guardar
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
