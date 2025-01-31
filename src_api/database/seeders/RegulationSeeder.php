<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regulations')->insert([
            ['name' => 'Peraturan Menteri Kesehatan No. 32', 'year' => 2017],
            ['name' => 'Peraturan Menteri Kesehatan No. 2', 'year' => 2020],
        ]);
    }
}
