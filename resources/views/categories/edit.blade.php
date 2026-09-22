@extends('layouts.app') @section('content')<h1>Editar categoría</h1>
<form method="POST" action="{{ route('categories.update',$category) }}">@csrf @method('PUT')<div class="field"><label>Nombre</label><input name="name" value="{{ old('name',$category->name) }}" required></div><button class="btn">Guardar</button></form>
<hr>
<form method="POST" action="{{ route('categories.destroy',$category) }}">@csrf @method('DELETE')<button class="btn btn-danger">Eliminar</button></form>@endsection