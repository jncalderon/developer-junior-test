<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $t->string('name');
            $t->string('sku', 40);
            $t->unsignedInteger('stock')->default(0);
            $t->string('location', 80)->nullable();
            $t->decimal('price', 10, 2);
            $t->boolean('active')->default(true);
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
