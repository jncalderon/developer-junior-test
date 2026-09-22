@extends('layouts.app') @section('content')<h1>Editar producto</h1>
<form method="POST" action="{{ route('products.update',$product) }}">@csrf @method('PUT') @include('products._form')</form>
<hr>
<form method="POST" action="{{ route('products.destroy',$product) }}" onsubmit="return confirm('¿Eliminar producto?')">@csrf @method('DELETE')<button class="btn btn-danger">Eliminar</button></form>@endsection