<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MethodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('methodes')->insert([
            ['name' => 'Direct Reading'],
            ['name' => 'Gravimetri'],
            ['name' => 'ICP/AAS Furnace'],
        ]);
    }
}
