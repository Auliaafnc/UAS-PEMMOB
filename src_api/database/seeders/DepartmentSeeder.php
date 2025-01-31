<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! Department::where('name', 'Sales')->exists()) {
            Department::create([
                'branch_company_id' => 1,
                'name' => 'Sales',
            ]);
        }

        if (! Department::where('name', 'Laboratory')->exists()) {
            Department::create([
                'branch_company_id' => 1,
                'name' => 'Laboratory',
            ]);
        }

        if (! Department::where('name', 'Finance')->exists()) {
            Department::create([
                'branch_company_id' => 1,
                'name' => 'Finance',
            ]);
        }
    }
}
