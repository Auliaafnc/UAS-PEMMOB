<?php

// namespace App\Filament\Admin\Resources\UserResource\Widgets;

// use Spatie\Permission\Models\Role;
// use Filament\Widgets\StatsOverviewWidget\Stat;
// use Filament\Widgets\StatsOverviewWidget as BaseWidget;

// class Roles extends BaseWidget
// {
//     protected function getStats(): array
//     {
//         // Mengambil data role beserta user terkait
//         $roles = Role::with('users')->get();

//         // Menghasilkan array Stat untuk setiap role dengan warna yang berbeda
//         return $roles->map(function ($role) {
//             // Mengambil nama user berdasarkan role
//             $userNames = $role->users->pluck('name')->implode(', '); // Menampilkan nama user dipisah koma

//             // Menentukan warna berdasarkan nama role atau logika lainnya
//             $color = $this->getRoleColor($role->name);

//             return Stat::make($role->name, $userNames ?: 'Data tidak ada')
//                 ->description(
//                     // $userNames ?:
//                     'Jumlah pengguna'
//                     )
//                 ->descriptionIcon('heroicon-o-users')
//                 ->color($color);
//         })->toArray();
//     }

//     /**
//      * Menentukan warna berdasarkan nama role.
//      *
//      * @param string $roleName
//      * @return string
//      */
//     protected function getRoleColor(string $roleName): string
//     {
//         // Logika untuk menentukan warna berdasarkan nama role
//         return match ($roleName) {
//             'Admin' => 'primary', // Warna biru untuk Admin
//             default => 'info', // Warna default untuk role lainnya
//         };
//     }
// }

// untuk logic ketika querry data count dari user per role
// <?php

namespace App\Filament\Admin\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\Permission\Models\Role;

class Roles extends BaseWidget
{
    protected function getStats(): array
    {
        // Mengambil data jumlah user per role
        $roles = Role::withCount('users')->get();

        // Menghasilkan array Stat untuk setiap role dengan warna yang berbeda
        return $roles->map(function ($role) {
            // Menentukan warna berdasarkan nama role atau logika lainnya
            $color = $this->getRoleColor($role->name);

            return Stat::make($role->name, $role->users_count)
                ->description('Jumlah pengguna')
                ->descriptionIcon('heroicon-o-users')
                ->color($color);
        })->toArray();
    }

    /**
     * Menentukan warna berdasarkan nama role.
     */
    protected function getRoleColor(string $roleName): string
    {
        // Logika untuk menentukan warna berdasarkan nama role
        return match ($roleName) {
            'Admin' => 'primary', // Warna biru untuk Admin
            default => 'info', // Warna default untuk role lainnya
        };
    }
}
