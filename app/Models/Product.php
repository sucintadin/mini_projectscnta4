<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'scientific_name',
        'sku',
        'price',
        'stock',
        'min_stock',
        'light_requirement',
        'watering_schedule',
        'image_url',
        'description',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer',
        'is_featured' => 'boolean',
    ];

    /**
     * Relationship: Product belongs to Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get stock status string
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'out_of_stock';
        }
        if ($this->stock <= $this->min_stock) {
            return 'low_stock';
        }
        return 'in_stock';
    }

    /**
     * Human-readable stock label
     */
    public function getStockStatusLabelAttribute(): string
    {
        return match ($this->stock_status) {
            'out_of_stock' => 'Stok Habis',
            'low_stock' => 'Stok Menipis',
            default => 'Stok Tersedia',
        };
    }

    /**
     * Formatted price in IDR
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Total inventory value for this item
     */
    public function getTotalValueAttribute(): float
    {
        return (float) ($this->price * $this->stock);
    }

    public function getFormattedTotalValueAttribute(): string
    {
        return 'Rp ' . number_format($this->total_value, 0, ',', '.');
    }

    /**
     * Scope for searching by name, sku, or scientific name
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%")
              ->orWhere('scientific_name', 'like', "%{$search}%");
        });
    }

    /**
     * Scope for filtering by category
     */
    public function scopeFilterCategory(Builder $query, ?string $categoryId): Builder
    {
        if (!$categoryId || $categoryId === 'all') {
            return $query;
        }

        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope for filtering by stock status
     */
    public function scopeFilterStock(Builder $query, ?string $status): Builder
    {
        if (!$status || $status === 'all') {
            return $query;
        }

        if ($status === 'out_of_stock') {
            return $query->where('stock', '<=', 0);
        }

        if ($status === 'low_stock') {
            return $query->where('stock', '>', 0)
                         ->whereColumn('stock', '<=', 'min_stock');
        }

        if ($status === 'in_stock') {
            return $query->whereColumn('stock', '>', 'min_stock');
        }

        return $query;
    }

    /**
     * Scope for sorting
     */
    public function scopeSort(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'stock_asc' => $query->orderBy('stock', 'asc'),
            'stock_desc' => $query->orderBy('stock', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };
    }
}
