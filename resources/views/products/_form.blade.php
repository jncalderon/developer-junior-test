<div class="row">
    <div class="field"><label>Nombre</label><input name="name" value="{{ old('name',$product->name ?? '') }}" required></div>
    <div class="field"><label>Categoría</label><select name="category_id" required>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$product->category_id ?? '')==$category->id)>{{ $category->name }}</option>@endforeach</select></div>
</div>
<div class="row">
    <div class="field"><label>SKU</label><input name="sku" value="{{ old('sku',$product->sku ?? '') }}" required></div>
    <div class="field"><label>Stock</label><input type="number" min="0" name="stock" value="{{ old('stock',$product->stock ?? 0) }}" required></div>
</div>
<div class="row">
    <div class="field"><label>Ubicación</label><input name="location" value="{{ old('location',$product->location ?? '') }}"></div>
    <div class="field"><label>Precio</label><input type="number" step="0.01" min="0" name="price" value="{{ old('price',$product->price ?? '') }}" required></div>
</div>
<div class="field"><label><input style="width:auto" type="checkbox" name="active" value="1" @checked(old('active',$product->active ?? true))> Activo</label></div><button class="btn" type="submit">Guardar</button>