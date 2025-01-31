<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUsers();
        $this->callSeeders();
    }

    private function seedUsers(): void
    {
        if (! User::where('email', 'admin@admin.com')->exists()) {
            $users = User::factory()->createMany([
                [
                    'name' => 'Admin',
                    'email' => 'admin@admin.com',
                    'password' => bcrypt('password'),
                ],
                [
                    'name' => 'Sales',
                    'email' => 'sales@gmail.com',
                    'password' => bcrypt('password'),
                ],
                [
                    'name' => 'Labolatory',
                    'email' => 'labolatory@gmail.com',
                    'password' => bcrypt('password'),
                ],
                [
                    'name' => 'Finance',
                    'email' => 'finance@gmail.com',
                    'password' => bcrypt('password'),
                ],
            ]);

            foreach ($users as $user) {
                if ($user->email === 'admin@admin.com') {
                    $user->assignRole('super_admin');
                }
            }
        }
    }

    private function callSeeders(): void
    {
        $this->call([
            CompanySeeder::class,
            BranchCompanySeeder::class,
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            ClientSeeder::class,
            TypeProductSeeder::class,
            RegulationSeeder::class,
            DescriptionProductSeeder::class,
            ParameterSeeder::class,
            MethodeSeeder::class,
            ProductSeeder::class,
            PriceProductSeeder::class,
            DiscountSeeder::class,
            OrderSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
