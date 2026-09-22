<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'stock',
        'location',
        'price',
        'active'
    ];
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'price' => 'decimal:2'
        ];
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
