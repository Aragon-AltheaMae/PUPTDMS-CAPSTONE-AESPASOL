<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceType;

class ServiceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            [
                'name' => 'Oral Check-Up',
                'description' => 'Routine exam • Consultation',
            ],
            [
                'name' => 'Dental Cleaning',
                'description' => 'Oral hygiene • Surface buildup',
            ],
            [
                'name' => 'Restoration & Prosthesis',
                'description' => 'Fillings • Crowns • Bridges',
            ],
            [
                'name' => 'Dental Surgery',
                'description' => 'Extraction • Implants',
            ],
        ];

        foreach ($defaults as $service) {
            ServiceType::firstOrCreate(
                ['name' => $service['name']], // prevents duplicates
                ['description' => $service['description']]
            );
        }
    }
}