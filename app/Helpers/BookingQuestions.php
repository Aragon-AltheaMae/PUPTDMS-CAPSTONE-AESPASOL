<?php

namespace App\Helpers;

class BookingQuestions
{
    public static function dental(): array
    {
        return [
            'symptoms' => [
                [
                    'code' => 'bleeding_gums',
                    'label' => 'Do your gums bleed while brushing/flossing?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'sensitive_temp',
                    'label' => 'Are your teeth sensitive to hot or cold?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'sensitive_taste',
                    'label' => 'Are your teeth sensitive to sweets or sour?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'tooth_pain',
                    'label' => 'Do you feel any pain in your teeth?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'sores',
                    'label' => 'Do you have any sores/lumps in or near your mouth?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'injuries',
                    'label' => 'Have you had any head, neck, or jaw injuries?',
                    'type' => 'bool',
                ],
            ],

            'jaw_bite' => [
                [
                    'code' => 'clicking',
                    'label' => 'Clicking',
                    'type' => 'bool',
                ],
                [
                    'code' => 'joint_pain',
                    'label' => 'Pain (joint, side of the face)',
                    'type' => 'bool',
                ],
                [
                    'code' => 'difficulty_moving',
                    'label' => 'Difficulty in opening/closing',
                    'type' => 'bool',
                ],
                [
                    'code' => 'difficulty_chewing',
                    'label' => 'Difficulty in chewing',
                    'type' => 'bool',
                ],
                [
                    'code' => 'jaw_headaches',
                    'label' => 'Frequent headaches',
                    'type' => 'bool',
                ],
                [
                    'code' => 'clench_grind',
                    'label' => 'Do you clench or grind your teeth?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'biting',
                    'label' => 'Frequent lips/cheek biting',
                    'type' => 'bool',
                ],
                [
                    'code' => 'teeth_loosening',
                    'label' => 'Have you noticed loosening of your teeth?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'food_teeth',
                    'label' => 'Does food get caught between your teeth?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'med_reaction',
                    'label' => 'Have you ever had a reaction to any medicine or dental anesthetic?',
                    'type' => 'bool',
                ],
            ],

            'procedures' => [
                [
                    'code' => 'periodontal',
                    'label' => 'Have you had any periodontal (gum) treatment?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'difficult_extraction',
                    'label' => 'Have you had a difficult tooth extraction?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'prolonged_bleeding',
                    'label' => 'Have you had prolonged bleeding following tooth extractions?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'dentures',
                    'label' => 'Do you wear complete or partial dentures?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'ortho_treatment',
                    'label' => 'Have you had orthodontic treatment?',
                    'type' => 'bool',
                ],
            ],
        ];
    }

    public static function medical(): array
    {
        return [
            'general_health' => [
                [
                    'code' => 'good_health',
                    'label' => 'Are you in good health?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'good_health_details',
                    'label' => 'If NO, please provide details:',
                    'type' => 'text',
                ],
                [
                    'code' => 'had_medical_exam',
                    'label' => 'When was your last medical examination?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'medical_exam_date',
                    'label' => 'If YES, when was your last medical examination?',
                    'type' => 'date',
                ],
                [
                    'code' => 'under_treatment',
                    'label' => 'Are you currently receiving treatment for any illness?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'treatment_details',
                    'label' => 'If YES, please specify:',
                    'type' => 'text',
                ],
                [
                    'code' => 'hospitalized',
                    'label' => 'Have you ever been hospitalized?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'hospital_details',
                    'label' => 'If YES, please provide details:',
                    'type' => 'text',
                ],
            ],

            'allergies' => [
                [
                    'code' => 'allergy_medicine',
                    'label' => 'Medicines',
                    'type' => 'bool',
                ],
                [
                    'code' => 'allergy_food',
                    'label' => 'Food',
                    'type' => 'bool',
                ],
                [
                    'code' => 'allergy_others',
                    'label' => 'Others (please specify):',
                    'type' => 'text',
                ],
            ],

            'medication' => [
                [
                    'code' => 'medication',
                    'label' => 'Are you taking any prescription or non-prescription medication?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'medication_details',
                    'label' => 'If YES, please specify:',
                    'type' => 'text',
                ],
            ],

            'women' => [
                [
                    'code' => 'pregnant',
                    'label' => 'Are you pregnant?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'nursing',
                    'label' => 'Are you nursing?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'birth_control',
                    'label' => 'Are you taking birth control pills?',
                    'type' => 'bool',
                ],
            ],

            'tobacco' => [
                [
                    'code' => 'tobacco_use',
                    'label' => 'Do you use tobacco products or any derivatives?',
                    'type' => 'bool',
                ],
                [
                    'code' => 'tobacco_per_day',
                    'label' => 'How much per day',
                    'type' => 'text',
                ],
                [
                    'code' => 'tobacco_per_week',
                    'label' => 'Per week',
                    'type' => 'text',
                ],
            ],

            'symptoms' => [
                [
                    'code' => 'headaches',
                    'label' => 'Headaches',
                    'type' => 'bool',
                ],
                [
                    'code' => 'earaches',
                    'label' => 'Earaches',
                    'type' => 'bool',
                ],
                [
                    'code' => 'neck_aches',
                    'label' => 'Neck aches',
                    'type' => 'bool',
                ],
            ],
        ];
    }

    public static function dentalFlat(): array
    {
        return collect(self::dental())
            ->flatten(1)
            ->values()
            ->all();
    }

    public static function medicalFlat(): array
    {
        return collect(self::medical())
            ->flatten(1)
            ->values()
            ->all();
    }

    public static function medicalByCode(): array
    {
        return collect(self::medicalFlat())
            ->keyBy('code')
            ->all();
    }

    public static function dentalByCode(): array
    {
        return collect(self::dentalFlat())
            ->keyBy('code')
            ->all();
    }

    public static function medicalCodesByType(
        string $type
    ): array {
        return collect(self::medicalFlat())
            ->where('type', $type)
            ->pluck('code')
            ->values()
            ->all();
    }
}
