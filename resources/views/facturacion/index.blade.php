<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Módulo Facturación - POS
        </h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded-lg center">
        <div class="grid grid-cols-2 gap-6">

            <!-- Selección de Items -->
            <div>
                <h4 class="font-bold mb-2">Seleccionar Items</h4>
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Item</th>
                            <th class="px-4 py-2">Tipo</th>
                            <th class="px-4 py-2">Precio</th>
                            <th class="px-4 py-2">Cantidad</th>
                            <th class="px-4 py-2">Subtotal</th>
                            <th class="px-4 py-2">Agregar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr class="text-center border-t">
                            <td class="px-4 py-2">{{ $item->nombre }}</td>
                            <td class="px-4 py-2">{{ ucfirst($item->tipo) }}</td>
                            <td class="px-4 py-2">{{ number_format($item->precio, 2) }}</td>
                            <td class="px-4 py-2">
                                <input type="number" min="1" value="1"
                                    class="form-input qty border rounded px-2 py-1"
                                    data-id="{{ $item->id }}"
                                    data-precio="{{ $item->precio }}"
                                    data-tipo="{{ $item->tipo }}">
                            </td>
                            <td class="px-4 py-2 subtotal" id="subtotal-{{ $item->id }}">{{ number_format($item->precio, 2) }}</td>
                            <td class="px-4 py-2">
                                <button type="button"
                                    class="bg-green-600 hover:bg-green-700 text-black font-semibold px-3 py-1 rounded shadow addItem transition duration-200"
                                    data-id="{{ $item->id }}"
                                    data-nombre="{{ $item->nombre }}"
                                    data-precio="{{ $item->precio }}"
                                    data-tipo="{{ $item->tipo }}">
                                    Agregar
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Carrito y Total -->
            <div>
                <h4 class="font-bold mb-2">Carrito</h4>
                <table class="min-w-full divide-y divide-gray-200 border" id="cartTable">
                    <thead class="bg-gray-50 text-center">
                        <tr>
                            <th class="px-4 py-2">Item</th>
                            <th class="px-4 py-2">Tipo</th>
                            <th class="px-4 py-2">Precio</th>
                            <th class="px-4 py-2">Cantidad</th>
                            <th class="px-4 py-2">Subtotal</th>
                            <th class="px-4 py-2">Quitar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <h4 class="mt-4 font-bold text-lg">Total: $<span id="total">0.00</span></h4>
                <button type="button" id="checkoutBtn"
                    class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">
                    Finalizar Venta
                </button>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let cart = [];

            function updateCartTable() {
                let tbody = document.querySelector('#cartTable tbody');
                tbody.innerHTML = '';
                let total = 0;

                cart.forEach((item, index) => {
                    let subtotal = item.precio * item.cantidad;
                    total += subtotal;

                    tbody.innerHTML += `
                        <tr class="text-center border-t">
                            <td class="px-2 py-1">${item.nombre}</td>
                            <td class="px-2 py-1">${item.tipo}</td>
                            <td class="px-2 py-1">${item.precio.toFixed(2)}</td>
                            <td class="px-2 py-1">
                                <input type="number" min="1" value="${item.cantidad}" data-index="${index}" class="form-input cartQty border rounded px-2 py-1">
                            </td>
                            <td class="px-2 py-1">${subtotal.toFixed(2)}</td>
                            <td class="px-2 py-1">
                                <button type="button" class="bg-red-500 text-black hover:bg-red-600 px-2 py-1 rounded removeItem font-bold text-lg" data-index="${index}">X</button>
                            </td>
                        </tr>
                    `;
                });

                document.getElementById('total').innerText = total.toFixed(2);
            }

            // Agregar item al carrito
            document.querySelectorAll('.addItem').forEach(btn => {
                btn.addEventListener('click', () => {
                    let id = btn.dataset.id;
                    let nombre = btn.dataset.nombre;
                    let tipo = btn.dataset.tipo;
                    let precio = parseFloat(btn.dataset.precio);
                    let cantidad = parseInt(document.querySelector(`.qty[data-id="${id}"]`).value);

                    let existing = cart.find(i => i.id == id);
                    if(existing) existing.cantidad += cantidad;
                    else cart.push({id, nombre, tipo, precio, cantidad});

                    updateCartTable();
                });
            });

            // Actualiza subtotal cuando cambia cantidad en tabla de items
            document.querySelectorAll('.qty').forEach(input => {
                input.addEventListener('input', () => {
                    let id = input.dataset.id;
                    let precio = parseFloat(input.dataset.precio);
                    let cantidad = parseInt(input.value) || 1;
                    let subtotalTd = document.getElementById(`subtotal-${id}`);
                    subtotalTd.textContent = (precio * cantidad).toFixed(2);
                });
            });

            // Cambiar cantidad en carrito
            document.addEventListener('input', function(e){
                if(e.target.classList.contains('cartQty')){
                    let index = e.target.dataset.index;
                    cart[index].cantidad = parseInt(e.target.value);
                    updateCartTable();
                }
            });

            // Quitar item del carrito
            document.addEventListener('click', function(e){
                if(e.target.classList.contains('removeItem')){
                    let index = e.target.dataset.index;
                    cart.splice(index, 1);
                    updateCartTable();
                }
            });

           // Finalizar venta
            document.getElementById('checkoutBtn').addEventListener('click', () => {
                if(cart.length === 0){
                    alert('El carrito está vacío');
                    return;
                }

                fetch('{{ route("ventas.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ items: cart })
                })
                .then(async res => {
                    let data;

                    try {
                        data = await res.json();
                    } catch (e) {
                        throw new Error('Respuesta inválida del servidor');
                    }

                    if (!res.ok) {
                        // 401 / 422 / 500 controlados
                        alert(data.message ?? 'Error al procesar la venta');
                        return;
                    }

                    alert(data.message);
                    cart = [];
                    updateCartTable();
                })
                .catch(err => {
                    console.error(err);
                    alert('Error inesperado al registrar la venta');
                });
            });

        });
    </script>
</x-app-layout>
