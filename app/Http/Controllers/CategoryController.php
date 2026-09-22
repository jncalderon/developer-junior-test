<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', ['categories' => Category::withCount('products')->orderBy('name')->get()]);
    }
    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        Category::create($request->validate(['name' => ['required', 'max:80']]));
        return redirect()->route('categories.index')->with('ok', 'Categoría creada.');
    }
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $category->update($request->validate(['name' => ['required', 'max:80']]));
        return redirect()->route('categories.index')->with('ok', 'Categoría actualizada.');
    }
    public function destroy(Category $category)
    {
        if ($category->products()->exists()) return back()->with('error', 'No se puede eliminar una categoría con productos.');
        $category->delete();
        return back()->with('ok', 'Categoría eliminada.');
    }
}
