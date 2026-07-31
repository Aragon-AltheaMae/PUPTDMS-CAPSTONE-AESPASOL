<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DentalHistoryCondition;

class DentalHistoryConditionSeeder extends Seeder
{
    public function run(): void
    {
        $conditions = [
            'bleeding_gums',
            'sensitive_temp',
            'sensitive_taste',
            'tooth_pain',
            'sores',
            'injuries',
            'clicking',
            'joint_pain',
            'difficulty_moving',
            'difficulty_chewing',
            'jaw_headaches',
            'clench_grind',
            'biting',
            'teeth_loosening',
            'food_teeth',
            'med_reaction',
            'periodontal',
            'difficult_extraction',
            'prolonged_bleeding',
            'dentures',
            'ortho_treatment'
        ];

        foreach ($conditions as $i => $code) {
            DentalHistoryCondition::updateOrCreate(
                ['code' => $code],
                ['sort_order' => $i + 1]
            );
        }
    }
}