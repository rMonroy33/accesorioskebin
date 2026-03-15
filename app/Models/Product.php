<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'sale_price',
        'stock',
        'min_stock',
        'main_image',
        'is_featured',
        'is_new',
        'is_on_sale',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_on_sale' => 'boolean',
        'status' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function getFinalPriceAttribute(): float
    {
        return (float) ($this->sale_price ?? $this->price);
    }

    public function getIsSoldOutAttribute(): bool
    {
        return $this->stock <= 0;
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }
}