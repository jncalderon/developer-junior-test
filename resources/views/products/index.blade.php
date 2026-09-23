@extends('layouts.app') @section('content')
<div style="display:flex;justify-content:space-between;align-items:center">
    <div>
        <h1>Productos</h1>
        <p class="muted">Inventario de ejemplo para la prueba técnica.</p>
    </div><a class="btn" href="{{ route('products.create') }}">Nuevo producto</a>
</div>
<form class="search" id="product-search" method="GET" action="{{ route('products.index') }}" role="search" data-initial="{{ $search }}">
    <input type="search" name="q" value="{{ $search }}" placeholder="Buscar por nombre o SKU" aria-label="Buscar por nombre o SKU" autocomplete="off">
    <a class="search-clear" href="{{ route('products.index') }}" title="Limpiar búsqueda" aria-label="Limpiar búsqueda" @if($search === '') hidden @endif>&times;</a>
</form>
<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="product-rows">
        @foreach($products as $product)<tr class="product-row" data-search="{{ $product->name }} {{ $product->sku }}">
            <td><strong>{{ $product->name }}</strong><br><span class="muted">{{ $product->sku }}</span></td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->category->name }}</td>
            <td>${{ number_format((float)$product->price,2) }}</td>
            <td>{{ $product->active ? 'Activo' : 'Inactivo' }}</td>
            <td><a href="{{ route('products.edit',$product) }}">Editar</a></td>
        </tr>@endforeach
        <tr id="no-results" @if($products->isNotEmpty()) hidden @endif>
            <td colspan="6">{{ $search !== '' ? 'No se encontraron productos para "'.$search.'".' : 'Sin productos.' }}</td>
        </tr>
    </tbody>
</table>
<script>
    /**
     * Búsqueda instantánea: filtra en el navegador las filas que ya están en la
     * tabla, comparando el texto con el nombre y el SKU de cada producto
     * (atributo data-search). No distingue mayúsculas ni acentos.
     *
     * Si la página se abrió con ?q=, el servidor solo envió las filas que
     * coincidían. En ese caso, al primer cambio se pide una vez el listado
     * completo y a partir de ahí todo se filtra en el navegador.
     * Sin JavaScript, el formulario sigue funcionando al presionar Enter.
     */
    (function () {
        const form = document.getElementById('product-search');
        const input = form.querySelector('input[name="q"]');
        const clear = form.querySelector('.search-clear');
        const rows = document.getElementById('product-rows');
        let fullList = form.dataset.initial === '' ? Promise.resolve() : null;

        // Pasa a minúsculas y quita acentos: "Mecánico" → "mecanico".
        const normalize = text => text.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase().trim();

        function loadFullList() {
            if (!fullList) {
                fullList = fetch(form.action)
                    .then(response => response.text())
                    .then(html => {
                        const page = new DOMParser().parseFromString(html, 'text/html');
                        rows.innerHTML = page.getElementById('product-rows').innerHTML;
                    });
            }
            return fullList;
        }

        function filter() {
            const term = normalize(input.value);
            let visible = 0;

            rows.querySelectorAll('.product-row').forEach(row => {
                const match = normalize(row.dataset.search).includes(term);
                row.hidden = !match;
                if (match) visible++;
            });

            const empty = document.getElementById('no-results');
            empty.hidden = visible > 0;
            empty.firstElementChild.textContent = term === '' ? 'Sin productos.' : 'No se encontraron productos para "' + input.value.trim() + '".';

            // Actualiza la URL para que la búsqueda se conserve al recargar.
            const url = new URL(form.action);
            if (term !== '') url.searchParams.set('q', input.value.trim());
            history.replaceState(null, '', url);
        }

        function search() {
            clear.hidden = input.value === '';
            loadFullList().then(filter, () => form.submit());
        }

        input.addEventListener('input', search);

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            search();
        });

        clear.addEventListener('click', function (event) {
            event.preventDefault();
            input.value = '';
            input.focus();
            search();
        });
    })();
</script>
@endsection
