<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DentalServiceRecord extends Model
{
    protected $fillable = [
        'created_by',
        'time_in','time_out',
        'patient_last_name','patient_first_name','patient_middle_name',
        'age','gender',
        'is_senior','is_pwd',
        'email','contact',
        'visit_type','department',
        'program_code','year_level','section',
        'has_signature','signature_path',
    ];

    protected $casts = [
        'time_in' => 'datetime',
        'time_out' => 'datetime',
        'is_senior' => 'boolean',
        'is_pwd' => 'boolean',
        'has_signature' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
