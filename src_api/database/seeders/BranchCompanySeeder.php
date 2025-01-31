<?php

namespace Database\Seeders;

use App\Models\BranchCompany;
use Illuminate\Database\Seeder;

class BranchCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! BranchCompany::where('name', 'Head Office')->exists()) {
            BranchCompany::create([
                'company_id' => 1,
                'name' => 'Head Office',
                'address' => 'Ruko Imperium Park No.C19, Ciriung, Cibinong, Bogor. 16918',
                'email' => 'ho@cbi.com',
                'phone' => '(021)87914212',
            ]);
        }

        if (! BranchCompany::where('name', 'PT CBI Lampung')->exists()) {
            BranchCompany::create([
                'company_id' => 1,
                'name' => 'PT CBI Lampung',
                'address' => 'Jl. Palem VI Perum No.21 Blok 18B, Beringin Raya, Kec. Kemiling, Kota Bandar Lampung, Lampung. 35153',
                'email' => 'lampung@cbi.com',
                'phone' => '',
            ]);
        }
    }
}
