<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
    ];

    /**
     * Relationship: Category has many Products (Plants)
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Auto generate slug when setting name if slug is empty
     */
    public static function boot()
    {
        parent::boot();
        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
