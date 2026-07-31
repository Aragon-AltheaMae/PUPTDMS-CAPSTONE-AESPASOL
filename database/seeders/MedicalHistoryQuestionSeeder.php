<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalHistoryQuestion;

class MedicalHistoryQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // GENERAL HEALTH
            ['code' => 'good_health', 'type' => 'bool', 'sort_order' => 1],
            ['code'  => 'had_medical_exam', 'type' => 'bool', 'sort_order' => 2],
            ['code' => 'good_health_details', 'type' => 'text', 'sort_order' => 3],
            ['code' => 'medical_exam_date', 'type' => 'date', 'sort_order' => 4],

            ['code' => 'under_treatment', 'type' => 'bool', 'sort_order' => 5],
            ['code' => 'treatment_details', 'type' => 'text', 'sort_order' => 6],

            ['code' => 'hospitalized', 'type' => 'bool', 'sort_order' => 7],
            ['code' => 'hospital_details', 'type' => 'text', 'sort_order' => 8],

            // ALLERGIES
            ['code' => 'allergy_medicine', 'type' => 'bool', 'sort_order' => 9],
            ['code' => 'allergy_food', 'type' => 'bool', 'sort_order' => 10],
            ['code' => 'allergy_others', 'type' => 'text', 'sort_order' => 11],

            // MEDICATION
            ['code' => 'medication', 'type' => 'bool', 'sort_order' => 12],
            ['code' => 'medication_details', 'type' => 'text', 'sort_order' => 13],

            // WOMEN
            ['code' => 'pregnant', 'type' => 'bool', 'sort_order' => 14],
            ['code' => 'nursing', 'type' => 'bool', 'sort_order' => 15],
            ['code' => 'birth_control', 'type' => 'bool', 'sort_order' => 16],

            // TOBACCO
            ['code' => 'tobacco_use', 'type' => 'bool', 'sort_order' => 17],
            ['code' => 'tobacco_per_day', 'type' => 'text', 'sort_order' => 18],
            ['code' => 'tobacco_per_week', 'type' => 'text', 'sort_order' => 19],

            // SYMPTOMS
            ['code' => 'headaches', 'type' => 'bool', 'sort_order' => 20],
            ['code' => 'earaches', 'type' => 'bool', 'sort_order' => 21],
            ['code' => 'neck_aches', 'type' => 'bool', 'sort_order' => 22],
        ];

        foreach ($rows as $r) {
            MedicalHistoryQuestion::updateOrCreate(
                ['code' => $r['code']],
                $r
            );
        }
    }
}