@extends('layouts.app') @section('content')<div style="display:flex;justify-content:space-between;align-items:center">
    <h1>Categorías</h1><a class="btn" href="{{ route('categories.create') }}">Nueva categoría</a>
</div>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Productos</th>
            <th></th>
        </tr>
    </thead>
    <tbody>@foreach($categories as $category)<tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->products_count }}</td>
            <td><a href="{{ route('categories.edit',$category) }}">Editar</a></td>
        </tr>@endforeach</tbody>
</table>@endsection