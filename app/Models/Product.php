<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // kolom yang boleh diisi mass-assignment
    protected $fillable = ['category_id','name','price','stock','is_active','description'];

    // casting tipe data
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    // RELASI: satu produk milik satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
