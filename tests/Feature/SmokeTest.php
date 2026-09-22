<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use RefreshDatabase;
    public function test_products_page_loads(): void
    {
        $this->get('/products')->assertOk()->assertSee('Productos');
    }
}
