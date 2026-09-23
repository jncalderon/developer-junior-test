<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Lista los productos y permite filtrarlos por nombre o SKU.
     *
     * El término se recibe por GET en el parámetro "q". Por compatibilidad con
     * las integraciones de inventario, que exponen el identificador como "code",
     * ese parámetro también se acepta como alias de "q".
     *
     * La búsqueda es parcial (LIKE %término%) sobre las columnas "name" y "sku".
     * Si el término está vacío o solo tiene espacios, no se filtra y se
     * muestran todos los productos.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('q', $request->input('code', '')));

        $products = Product::with('category')
        
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->get();

        return view('products.index', compact('products', 'search'));
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
        $product->update($data);
        return redirect()->route('products.index')->with('ok', 'Producto actualizado.');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('ok', 'Producto eliminado.');
    }
}
