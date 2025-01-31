<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! Client::where('name', 'PT JIN')->exists()) {
            Client::create([
                'branch_company_id' => 1,
                'name' => 'PT JIN',
                'address' => 'Jl. Terus Pantang Mundur',
                'email' => 'ptjin@admin.com',
                'phone' => '(021)123456789',
                //'client_code' => ''
            ]);
        }
    }
}
