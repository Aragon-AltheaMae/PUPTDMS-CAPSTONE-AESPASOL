<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disease;

class DiseaseSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => 'aids_hiv',           'label' => 'AIDS/HIV',                               'sort_order' => 1],
            ['code' => 'fainting',           'label' => 'Fainting/Dizzy Spells',                  'sort_order' => 2],
            ['code' => 'alcohol_dependency', 'label' => 'Alcohol or Chemical Dependency',         'sort_order' => 3],
            ['code' => 'high_low_bp',        'label' => 'High/Low Blood Pressure',                'sort_order' => 4],
            ['code' => 'arthritis',          'label' => 'Arthritis/Rheumatism',                   'sort_order' => 5],
            ['code' => 'hyper_hypoglycemia', 'label' => 'Hyper/Hypoglycemia',                     'sort_order' => 6],
            ['code' => 'artificial_joints',  'label' => 'Artificial Joints or Valves',            'sort_order' => 7],
            ['code' => 'kidney_disease',     'label' => 'Kidney Disease',                         'sort_order' => 8],
            ['code' => 'asthma',             'label' => 'Asthma',                                 'sort_order' => 9],
            ['code' => 'liver_disease',      'label' => 'Liver Disease',                          'sort_order' => 10],
            ['code' => 'blood_transfusion',  'label' => 'Blood Transfusion',                      'sort_order' => 11],
            ['code' => 'mental_disorder',    'label' => 'Mental/Nervous Disorder',                'sort_order' => 12],
            ['code' => 'cancer',             'label' => 'Cancer/Radiotherapy/Chemotherapy',       'sort_order' => 13],
            ['code' => 'stomach_ulcers',     'label' => 'Stomach Ulcers',                         'sort_order' => 14],
            ['code' => 'diabetes',           'label' => 'Diabetes',                               'sort_order' => 15],
            ['code' => 'stroke',             'label' => 'Stroke',                                 'sort_order' => 16],
            ['code' => 'eating_disorders',   'label' => 'Eating Disorders',                       'sort_order' => 17],
            ['code' => 'tuberculosis',       'label' => 'Tuberculosis',                           'sort_order' => 18],
            ['code' => 'epilepsy',           'label' => 'Epilepsy/Seizures',                       'sort_order' => 19],
            ['code' => 'venereal_disease',   'label' => 'Venereal/Communicable Disease',          'sort_order' => 20],
        ];

        foreach ($rows as $r) {
            Disease::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}