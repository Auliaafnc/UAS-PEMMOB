<?php

namespace Database\Seeders;

use App\Models\DescriptionProduct;
use Illuminate\Database\Seeder;

class DescriptionProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! DescriptionProduct::where('name', 'Inlab')->exists()) {
            DescriptionProduct::create([
                'name' => 'Inlab',
            ]);
        }
        if (! DescriptionProduct::where('name', 'Subkon')->exists()) {
            DescriptionProduct::create([
                'name' => 'Subkon',
            ]);
        }
        if (! DescriptionProduct::where('name', 'Inlab(PRL)')->exists()) {
            DescriptionProduct::create([
                'name' => 'Inlab(PRL)',
            ]);
        }
    }
}
