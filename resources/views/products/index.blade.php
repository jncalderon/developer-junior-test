@extends('layouts.app') @section('content')
<div style="display:flex;justify-content:space-between;align-items:center">
    <div>
        <h1>Productos</h1>
        <p class="muted">Inventario de ejemplo para la prueba técnica.</p>
    </div><a class="btn" href="{{ route('products.create') }}">Nuevo producto</a>
</div>
<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)<tr>
            <td><strong>{{ $product->name }}</strong><br><span class="muted">{{ $product->sku }}</span></td>
            <td>{{ $product->category->name }}</td>
            <td>${{ number_format((float)$product->price,2) }}</td>
            <td>{{ $product->active ? 'Activo' : 'Inactivo' }}</td>
            <td><a href="{{ route('products.edit',$product) }}">Editar</a></td>
        </tr>@empty<tr>
            <td colspan="5">Sin productos.</td>
        </tr>@endforelse
    </tbody>
</table>@endsection