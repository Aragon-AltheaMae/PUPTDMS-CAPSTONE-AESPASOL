<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistoryCondition extends Model
{
    protected $fillable = [
        'medical_history_id',

        'aids_hiv',
        'fainting',
        'alcohol_dependency',
        'high_low_bp',
        'arthritis',
        'hyper_hypoglycemia',
        'artificial_joints',
        'kidney_disease',
        'asthma',
        'liver_disease',
        'blood_transfusion',
        'mental_disorder',
        'cancer',
        'stomach_ulcers',
        'diabetes',
        'stroke',
        'eating_disorders',
        'tuberculosis',
        'epilepsy',
        'venereal_disease',
    ];

    protected $casts = [
        // THESE ARE BOOLEAN IN DB
        'aids_hiv' => 'boolean',
        'fainting' => 'boolean',
        'alcohol_dependency' => 'boolean',
        'high_low_bp' => 'boolean',
        'arthritis' => 'boolean',
        'hyper_hypoglycemia' => 'boolean',
        'artificial_joints' => 'boolean',
        'kidney_disease' => 'boolean',
        'asthma' => 'boolean',
        'liver_disease' => 'boolean',
        'blood_transfusion' => 'boolean',
        'mental_disorder' => 'boolean',
        'cancer' => 'boolean',
        'stomach_ulcers' => 'boolean',
        'diabetes' => 'boolean',
        'stroke' => 'boolean',
        'eating_disorders' => 'boolean',
        'tuberculosis' => 'boolean',
        'epilepsy' => 'boolean',
        'venereal_disease' => 'boolean',
    ];

    public function medicalHistory()
    {
        return $this->belongsTo(MedicalHistory::class);
    }
}
