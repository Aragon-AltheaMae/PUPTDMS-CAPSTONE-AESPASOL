<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicPeriod;

class AcademicPeriodSeeder extends Seeder
{
    public function run(): void
    {
        $periods = [
            [
                'academic_year' => '2025-2026',
                'semester' => '1st Semester',
                'start_date' => '2025-09-01',
                'end_date' => '2026-01-31',
                'description' => 'Default academic period for AY 2025-2026.',
                'is_active' => false,
            ],
            [
                'academic_year' => '2025-2026',
                'semester' => '2nd Semester',
                'start_date' => '2026-02-01',
                'end_date' => '2026-06-21',
                'description' => 'Default academic period for AY 2025-2026.',
                'is_active' => true,
            ],
            [
                'academic_year' => '2025-2026',
                'semester' => 'Summer',
                'start_date' => '2026-06-29',
                'end_date' => '2026-08-08',
                'description' => 'Default summer term for AY 2025-2026.',
                'is_active' => false,
            ],
        ];

        foreach ($periods as $period) {
            AcademicPeriod::updateOrCreate(
                [
                    'academic_year' => $period['academic_year'],
                    'semester' => $period['semester'],
                ],
                $period
            );
        }
    }
}