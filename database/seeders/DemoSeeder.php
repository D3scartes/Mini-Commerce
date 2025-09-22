<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // 1) Buat beberapa kategori tetap
            $names = ['Kopi', 'Teh', 'Snack', 'Bumbu', 'Peralatan'];
            $categories = collect($names)->mapWithKeys(function ($n) {
                $cat = Category::firstOrCreate(['name' => $n]);
                return [$n => $cat];
            });

            // 2) Buat produk acak per kategori (total ~40 item)
            Product::factory()->count(10)->create(['category_id' => $categories['Kopi']->id]);
            Product::factory()->count(8)->create(['category_id' => $categories['Teh']->id]);
            Product::factory()->count(8)->create(['category_id' => $categories['Snack']->id]);
            Product::factory()->count(7)->create(['category_id' => $categories['Bumbu']->id]);
            Product::factory()->count(7)->create(['category_id' => $categories['Peralatan']->id]);
        });
    }
}
