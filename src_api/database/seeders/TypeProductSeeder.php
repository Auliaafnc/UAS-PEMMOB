<?php

namespace Database\Seeders;

use App\Models\TypeProduct;
use Illuminate\Database\Seeder;

class TypeProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! TypeProduct::where('name', 'ChemLab')->exists()) {
            TypeProduct::create([
                'branch_company_id' => 1,
                'name' => 'ChemLab',
            ]);
        }
        if (! TypeProduct::where('name', 'ChemCal')->exists()) {
            TypeProduct::create([
                'branch_company_id' => 1,
                'name' => 'ChemCal',
            ]);
        }
        if (! TypeProduct::where('name', 'ChemTrade')->exists()) {
            TypeProduct::create([
                'branch_company_id' => 1,
                'name' => 'ChemTrade',
            ]);
        }
        if (! TypeProduct::where('name', 'ChemConst')->exists()) {
            TypeProduct::create([
                'branch_company_id' => 1,
                'name' => 'ChemConst',
            ]);
        }

    }
}
