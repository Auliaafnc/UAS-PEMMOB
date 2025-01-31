<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('price_products')->insert([
            ['product_id' => 1, 'price' => 50000],
            ['product_id' => 2, 'price' => 75000],
            ['product_id' => 3, 'price' => 120000],
            ['product_id' => 4, 'price' => 85000],
        ]);
    }
}
