<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'Kekeruhan', 'parameter_id' => 1, 'methode_id' => 1, 'type_product_id' => 1, 'description_product_id' => 1], // fisika
            ['name' => 'pH', 'parameter_id' => 3, 'methode_id' => 1, 'type_product_id' => 1, 'description_product_id' => 2], // anorganik
            ['name' => 'Deterjen (MBAS)', 'parameter_id' => 4, 'methode_id' => 2, 'type_product_id' => 1, 'description_product_id' => 3], // organik
            ['name' => 'E-Coli', 'parameter_id' => 2, 'methode_id' => 2, 'type_product_id' => 1, 'description_product_id' => 1], // mikrobiologi
        ]);

        DB::table('product_regulation')->insert([
            ['product_id' => 1, 'regulation_id' => 1],
            ['product_id' => 2, 'regulation_id' => 1],
            ['product_id' => 3, 'regulation_id' => 2],
            ['product_id' => 4, 'regulation_id' => 2],
        ]);
    }
}
