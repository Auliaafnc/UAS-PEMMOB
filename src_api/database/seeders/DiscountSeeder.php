<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('discounts')->insert([
            ['name' => '30'],
            ['name' => '25'],
            ['name' => '20'],
            ['name' => '15'],
            ['name' => '10'],
            ['name' => '5'],
        ]);
    }
}
