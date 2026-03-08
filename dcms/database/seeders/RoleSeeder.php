<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(['slug' => 'super_admin'], ['name' => 'Super Admin']);
        Role::updateOrCreate(['slug' => 'dentist'], ['name' => 'Dentist']);
        Role::updateOrCreate(['slug' => 'patient'], ['name' => 'Patient']);
    }
}