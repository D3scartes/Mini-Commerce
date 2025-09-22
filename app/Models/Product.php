<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'category_id', 'name', 'price', 'stock', 'is_active', 'description',
    ];

    // casting tipe data
    protected $casts = [
        'is_active' => 'boolean',
        'price'     => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Pencarian by name/description
    public function scopeSearch($query, ?string $q)
    {
        $q = trim((string) $q);
        if ($q === '') return $query;

        return $query->where(function ($qq) use ($q) {
            $qq->where('name', 'like', "%{$q}%")
               ->orWhere('description', 'like', "%{$q}%");
        });
    }

    // Hanya produk aktif
    public function scopeActive($query, bool $onlyActive = true)
    {
        return $onlyActive ? $query->where('is_active', true) : $query;
    }

    // Filter kategori
    public function scopeInCategory($query, $categoryId)
    {
        return $categoryId ? $query->where('category_id', $categoryId) : $query;
    }

    // Filter harga
    public function scopePriceBetween($query, $min = null, $max = null)
    {
        if ($min !== null && $min !== '') $query->where('price', '>=', $min);
        if ($max !== null && $max !== '') $query->where('price', '<=', $max);
        return $query;
    }

    // Urutan standar
    public function scopeSortBy($query, string $sort = 'newest')
    {
        return match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest('id'),
        };
    }
}
