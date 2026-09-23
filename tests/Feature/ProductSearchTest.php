<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $category = Category::create(['name' => 'General']);
        Product::create(['category_id' => $category->id, 'name' => 'Teclado mecánico', 'sku' => 'TEC-001', 'stock' => 5, 'price' => 50]);
        Product::create(['category_id' => $category->id, 'name' => 'Mouse óptico', 'sku' => 'MOU-002', 'stock' => 3, 'price' => 20]);
    }

    public function test_filters_by_name(): void
    {
        $this->get('/products?q=teclado')->assertOk()->assertSee('Teclado mecánico')->assertDontSee('Mouse óptico');
    }

    public function test_filters_by_sku(): void
    {
        $this->get('/products?q=MOU-002')->assertOk()->assertSee('Mouse óptico')->assertDontSee('Teclado mecánico');
    }

    public function test_accepts_code_as_alias(): void
    {
        $this->get('/products?code=TEC')->assertOk()->assertSee('Teclado mecánico')->assertDontSee('Mouse óptico');
    }

    public function test_blank_search_shows_all_products(): void
    {
        $this->get('/products?q=%20%20')->assertOk()->assertSee('Teclado mecánico')->assertSee('Mouse óptico');
    }

    public function test_no_results_message(): void
    {
        $this->get('/products?q=inexistente')->assertOk()->assertSee('No se encontraron productos');
    }
}
