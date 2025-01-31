<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parameters')->insert([
            ['name' => 'Fisika'],
            ['name' => 'Mikrobiologi'],
            ['name' => 'Anorganik'],
            ['name' => 'Organik'],
        ]);
    }
}
