<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminLocalAccountSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('LOCAL_ADMIN_EMAIL');
        $password = env('LOCAL_ADMIN_PASSWORD');

        if (!filled($email) || !filled($password)) {
            return;
        }

        $adminRole = Role::where('slug', 'admin')->first();

        if (!$adminRole) {
            return;
        }

        $name = env('LOCAL_ADMIN_NAME', 'System Administrator');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'first_name' => env('LOCAL_ADMIN_FIRST_NAME'),
                'middle_name' => env('LOCAL_ADMIN_MIDDLE_NAME'),
                'last_name' => env('LOCAL_ADMIN_LAST_NAME'),
                'suffix_name' => env('LOCAL_ADMIN_SUFFIX_NAME'),
                'password' => Hash::make($password),
                'role_id' => $adminRole->id,
                'status' => 'active',
            ]
        );
    }
}