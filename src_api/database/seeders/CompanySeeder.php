<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! Company::where('name', 'PT CBI')->exists()) {
            Company::create([
                'name' => 'PT CBI',
                'logo' => '',
            ]);
        }
    }
}
