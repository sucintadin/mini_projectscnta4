<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'flower_name',
        'quantity',
        'unit_price',
        'sale_date',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'sale_date' => 'date',
    ];

    public function getTotalPriceAttribute(): float
    {
        return (float) ($this->quantity * $this->unit_price);
    }

    public function getFormattedUnitPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->unit_price, 0, ',', '.');
    }

    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
}
