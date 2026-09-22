<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('name')->get();
        return view('products.index', compact('products'));
    }
    public function create()
    {
        return view('products.create', ['categories' => Category::orderBy('name')->get()]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'max:120'],
            'sku' => ['required', 'max:40'],
            'stock' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'max:80'],
            'price' => ['required', 'numeric', 'min:0'],
            'active' => ['nullable', 'boolean'],
        ]);
        $data['active'] = $request->boolean('active');
        Product::create($data);
        return redirect()->route('products.index')->with('ok', 'Producto creado.');
    }
    public function show(Product $product)
    {
        return redirect()->route('products.edit', $product);
    }
    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product, 'categories' => Category::orderBy('name')->get()]);
    }
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'max:120'],
            'sku' => ['required', 'max:40'],
            'stock' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'max:80'],
            'price' => ['required', 'numeric', 'min:0'],
            'active' => ['nullable', 'boolean'],
        ]);
        $data['active'] = $request->boolean('active');
        $data['category_id'] = $product->category_id;
        $product->update($data);
        return redirect()->route('products.index')->with('ok', 'Producto actualizado.');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('ok', 'Producto eliminado.');
    }
}
